/**
 * CodeQuest Kids — Interactive Grid Game Engine
 * Menggerakkan robot, validasi sekuensial, deteksi rintangan, live Python preview, dan sinkronisasi database.
 */

class CodeQuestEngine {
    constructor(config) {
        this.levelId = config.levelId || 1;
        this.challengeId = config.challengeId || 1;
        this.gridSize = config.gridSize || 4;
        this.startX = config.startX || 1;
        this.startY = config.startY || 2;
        this.startAngle = config.startAngle || 0; // 0: East, 90: South, 180: West, 270: North
        this.targetX = config.targetX || 4;
        this.targetY = config.targetY || 2;
        this.targetAngle = config.targetAngle ?? null;
        this.obstacles = config.obstacles || []; // [{x, y, name}]
        this.maxBlocks = config.maxBlocks || 8;
        this.xpReward = config.xpReward || 50;
        this.nextLevelUrl = config.nextLevelUrl || 'peta-belajar.php';
        this.saveProgressUrl = config.saveProgressUrl || 'api/save-progress.php';

        // State
        this.currentX = this.startX;
        this.currentY = this.startY;
        this.currentAngle = this.startAngle;
        this.commandQueue = [...(config.initialCommands || [])];
        this.isRunning = false;
        this.executionInterval = null;
        this.currentStep = -1;
        this.usedHint = false;

        this.init();
    }

    init() {
        this.renderQueue();
        this.updatePythonPreview();
        setTimeout(() => this.updateRobotUI(false), 50);
        this.updateCompassUI();
        this.updateMascotSpeech('initial');

        // Re-align on window resize
        window.addEventListener('resize', () => {
            this.updateRobotUI(false);
        });
    }

    // ─── Direction Helpers ─────────────────────────────────────
    getDirectionName(angle) {
        const norm = ((angle % 360) + 360) % 360;
        if (norm === 0) return 'TIMUR (Kanan ➡️)';
        if (norm === 90) return 'SELATAN (Bawah ⬇️)';
        if (norm === 180) return 'BARAT (Kiri ⬅️)';
        if (norm === 270) return 'UTARA (Atas ⬆️)';
        return `${norm}°`;
    }

    updateCompassUI() {
        const textEl = document.getElementById('hud-compass-text');
        if (textEl) {
            textEl.textContent = `🧭 Hadap: ${this.getDirectionName(this.currentAngle)}`;
        }
    }

    // ─── Mascot Speech Balloon ─────────────────────────────────
    updateMascotSpeech(state, customText = '') {
        const speechEl = document.getElementById('mascot-speech-text');
        const phaseBadge = document.getElementById('mascot-phase-badge');
        const emoteIcon = document.getElementById('mascot-face-icon');
        if (!speechEl) return;

        if (state === 'initial') {
            if (this.levelId === 1) {
                speechEl.innerHTML = `“Halo Penjelajah Cilik! Kiko siap jalan! Untuk Misi 1 ini, Kiko hanya perlu <strong style="color: var(--tertiary);">MAJU 3 langkah lurus</strong> ke arah Timur untuk memetik Bintang Emas ⭐. Yuk klik tombol hijau <span class="badge-pill badge-mint" style="font-size: 0.7rem;">MAJU</span> sebanyak 3 kali!”`;
            } else {
                speechEl.innerHTML = `“Awas rintangan karang di depan (2,3)! Putar robot dengan <strong style="color: var(--coral-shade);">BELOK KIRI</strong>, lalu <strong style="color: var(--tertiary);">MAJU 2 kali</strong> ke baris atas, <strong style="color: var(--secondary);">BELOK KANAN</strong>, dan <strong style="color: var(--tertiary);">MAJU 3 kali</strong> ke arah Bintang Emas!”`;
            }
            if (phaseBadge) phaseBadge.textContent = 'Panduan Gerakan';
            if (emoteIcon) emoteIcon.textContent = 'smart_toy';
        } else if (state === 'running') {
            speechEl.innerHTML = `“Wusss! ⚡ Kiko sedang bergerak melangkah sesuai urutan perintahmu... Perhatikan jalurnya!”`;
            if (phaseBadge) phaseBadge.textContent = 'Sedang Eksekusi Kode ⚡';
            if (emoteIcon) emoteIcon.textContent = 'directions_run';
        } else if (state === 'success') {
            speechEl.innerHTML = `“Horeee! 🎉 Misi selesai sempurna! Bintang Emas berhasil kita petik ⭐! Kamu telah menguasai instruksi berurutan (Sequencing)!”`;
            if (phaseBadge) phaseBadge.textContent = 'Misi Berhasil Dituntaskan 🎉';
            if (emoteIcon) emoteIcon.textContent = 'celebration';
        } else if (state === 'failure') {
            speechEl.innerHTML = customText || `“Oops, Robot Kiko belum sampai ke target bintang atau langkah belum pas. Yuk klik Coba Lagi atau gunakan Petunjuk!”`;
            if (phaseBadge) phaseBadge.textContent = 'Evaluasi & Coba Lagi ⚠️';
            if (emoteIcon) emoteIcon.textContent = 'sentiment_dissatisfied';
        }
    }

    // ─── Robot Position Rendering ──────────────────────────────
    updateRobotUI(animate = true) {
        const tokenWrapper = document.getElementById('robot-token-wrapper');
        const robotMascot = document.getElementById('robot-mascot');
        if (!tokenWrapper) return;

        const targetCell = document.getElementById(`cell-${this.currentX}-${this.currentY}`);
        if (targetCell) {
            tokenWrapper.style.transition = animate ? 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)' : 'none';
            tokenWrapper.style.left = targetCell.offsetLeft + 'px';
            tokenWrapper.style.top = targetCell.offsetTop + 'px';
            tokenWrapper.style.width = targetCell.offsetWidth + 'px';
            tokenWrapper.style.height = targetCell.offsetHeight + 'px';
        } else {
            const pctX = ((this.currentX - 1) / this.gridSize) * 100;
            const pctY = ((this.currentY - 1) / this.gridSize) * 100;
            tokenWrapper.style.transition = animate ? 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)' : 'none';
            tokenWrapper.style.left = `${pctX}%`;
            tokenWrapper.style.top = `${pctY}%`;
        }

        if (robotMascot) {
            robotMascot.style.transform = `rotate(${this.currentAngle}deg)`;
        }
        this.updateCompassUI();
    }

    // ─── Queue Management ──────────────────────────────────────
    addCommand(cmd) {
        if (this.isRunning) return;
        if (this.commandQueue.length >= this.maxBlocks) {
            if (typeof playErrorSound === 'function') playErrorSound();
            alert(`Kapasitas maksimum telah tercapai (${this.maxBlocks} blok perintah)!`);
            return;
        }
        this.commandQueue.push(cmd);
        if (typeof playClickSound === 'function') playClickSound();
        this.renderQueue();
        this.updatePythonPreview();
    }

    removeCommand(index) {
        if (this.isRunning) return;
        this.commandQueue.splice(index, 1);
        if (typeof playClickSound === 'function') playClickSound();
        this.renderQueue();
        this.updatePythonPreview();
    }

    clearCommands() {
        if (this.isRunning) return;
        this.commandQueue = [];
        if (typeof playClickSound === 'function') playClickSound();
        this.renderQueue();
        this.updatePythonPreview();
    }

    renderQueue() {
        const container = document.getElementById('command-slots-container') || document.getElementById('queue-list');
        const counter = document.getElementById('queue-counter') || document.getElementById('queue-capacity-badge');
        if (!container) return;

        const count = this.commandQueue.length;
        if (counter) {
            if (count === this.maxBlocks) {
                counter.textContent = `${count} / ${this.maxBlocks} Blok (Penuh)`;
                counter.className = 'badge-pill badge-mint';
            } else {
                counter.textContent = `${count} / ${this.maxBlocks} Blok`;
                counter.className = 'badge-pill badge-blue';
            }
        }

        if (count === 0) {
            container.innerHTML = `
                <div class="slot-empty-notice">
                    <span class="material-symbols-outlined text-[24px]">touch_app</span>
                    <span>Belum ada perintah. Klik tombol perintah di atas untuk menyusun!</span>
                </div>
            `;
            return;
        }

        let html = '';
        this.commandQueue.forEach((cmd, idx) => {
            let label = 'MAJU (1 Petak)';
            let icon = 'arrow_upward';
            let tagClass = 'slot-tag-maju';

            if (cmd === 'FORWARD' || cmd === 'MAJU') {
                label = 'MAJU (1 Petak)';
                icon = 'arrow_upward';
                tagClass = 'slot-tag-maju';
            } else if (cmd === 'TURN_RIGHT' || cmd === 'BELOK_KANAN' || cmd === 'RIGHT') {
                label = 'BELOK KANAN (90°)';
                icon = 'rotate_right';
                tagClass = 'slot-tag-right';
            } else if (cmd === 'TURN_LEFT' || cmd === 'BELOK_KIRI' || cmd === 'LEFT') {
                label = 'BELOK KIRI (90°)';
                icon = 'rotate_left';
                tagClass = 'slot-tag-left';
            }

            const isExecuting = (this.currentStep === idx);

            html += `
                <div class="slot-item ${isExecuting ? 'executing' : ''}" id="cmd-slot-${idx}">
                    <div class="slot-left">
                        <span class="slot-num">${idx + 1}</span>
                        <span class="slot-tag ${tagClass}">
                            <span class="material-symbols-outlined text-[14px]">${icon}</span>
                            <span>${label}</span>
                        </span>
                    </div>
                    <button class="slot-delete-btn" onclick="gameEngine.removeCommand(${idx})" title="Hapus">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    updatePythonPreview() {
        const preview = document.getElementById('python-code-lines') || document.getElementById('python-code-content');
        if (!preview) return;

        let code = '';
        if (this.commandQueue.length === 0) {
            code = '# (Tambahkan blok perintah untuk melihat kode Python)\n';
        } else {
            this.commandQueue.forEach((cmd, i) => {
                if (cmd === 'FORWARD' || cmd === 'MAJU') {
                    code += `kiko.maju()  # Langkah ${i + 1}\n`;
                } else if (cmd === 'TURN_RIGHT' || cmd === 'BELOK_KANAN' || cmd === 'RIGHT') {
                    code += `kiko.belok_kanan()  # Putar 90° ke kanan\n`;
                } else if (cmd === 'TURN_LEFT' || cmd === 'BELOK_KIRI' || cmd === 'LEFT') {
                    code += `kiko.belok_kiri()  # Putar 90° ke kiri\n`;
                }
            });
        }
        preview.textContent = code;
    }

    // ─── Reset ─────────────────────────────────────────────────
    resetPositionOnly() {
        if (this.executionInterval) {
            clearInterval(this.executionInterval);
            this.executionInterval = null;
        }
        this.isRunning = false;

        const runBtn = document.getElementById('run-button') || document.getElementById('btn-run');
        if (runBtn) {
            runBtn.disabled = false;
            runBtn.style.opacity = '1';
        }

        this.currentX = this.startX;
        this.currentY = this.startY;
        this.currentAngle = this.startAngle;
        this.currentStep = -1;
        this.updateRobotUI(true);
        this.renderQueue();
        this.updateMascotSpeech('initial');
    }

    // ─── Execution ─────────────────────────────────────────────
    executeProgram() {
        if (this.isRunning) return;
        if (this.commandQueue.length === 0) {
            alert('Silakan susun minimal 1 balok perintah sebelum menjalankan!');
            return;
        }

        this.isRunning = true;
        this.currentX = this.startX;
        this.currentY = this.startY;
        this.currentAngle = this.startAngle;
        this.currentStep = -1;
        this.updateRobotUI(false);
        this.updateMascotSpeech('running');

        const runBtn = document.getElementById('run-button') || document.getElementById('btn-run');
        if (runBtn) {
            runBtn.disabled = true;
            runBtn.style.opacity = '0.6';
        }

        let stepIndex = 0;
        this.executionInterval = setInterval(() => {
            if (stepIndex >= this.commandQueue.length) {
                clearInterval(this.executionInterval);
                this.executionInterval = null;
                this.isRunning = false;
                this.currentStep = -1;
                this.renderQueue();
                if (runBtn) {
                    runBtn.disabled = false;
                    runBtn.style.opacity = '1';
                }
                this.evaluateOutcome();
                return;
            }

            this.currentStep = stepIndex;
            this.renderQueue();
            const cmd = this.commandQueue[stepIndex];
            const result = this.applyCommand(cmd);

            if (!result.success) {
                clearInterval(this.executionInterval);
                this.executionInterval = null;
                this.isRunning = false;
                this.currentStep = -1;
                this.renderQueue();
                if (runBtn) {
                    runBtn.disabled = false;
                    runBtn.style.opacity = '1';
                }
                this.handleCollision(result.reason);
                return;
            }

            stepIndex++;
        }, 550);
    }

    stepProgram() {
        if (this.isRunning) return;
        if (this.commandQueue.length === 0) {
            alert('Belum ada balok perintah untuk dijalankan!');
            return;
        }

        const nextStep = this.currentStep + 1;
        if (nextStep >= this.commandQueue.length) {
            this.evaluateOutcome();
            return;
        }

        this.currentStep = nextStep;
        this.renderQueue();
        const cmd = this.commandQueue[nextStep];
        const result = this.applyCommand(cmd);

        if (!result.success) {
            this.handleCollision(result.reason);
            return;
        }

        if (this.currentStep === this.commandQueue.length - 1) {
            setTimeout(() => this.evaluateOutcome(), 300);
        }
    }

    applyCommand(cmd) {
        const cmdUpper = cmd.toUpperCase();
        if (cmdUpper === 'FORWARD' || cmdUpper === 'MAJU') {
            const normAngle = ((this.currentAngle % 360) + 360) % 360;
            let nextX = this.currentX;
            let nextY = this.currentY;

            if (normAngle === 0) nextX += 1;          // East (Kanan)
            else if (normAngle === 90) nextY += 1;     // South (Bawah)
            else if (normAngle === 180) nextX -= 1;    // West (Kiri)
            else if (normAngle === 270) nextY -= 1;    // North (Atas)

            // 1. Boundary check
            if (nextX < 1 || nextX > this.gridSize || nextY < 1 || nextY > this.gridSize) {
                return { success: false, reason: 'boundary' };
            }

            // 2. Obstacle check
            const hitObstacle = this.obstacles.find(o => o.x === nextX && o.y === nextY);
            if (hitObstacle) {
                return { success: false, reason: 'obstacle', obstacle: hitObstacle };
            }

            this.currentX = nextX;
            this.currentY = nextY;
            if (typeof playStepSound === 'function') playStepSound();
            this.updateRobotUI(true);
            return { success: true };
        } else if (cmdUpper === 'TURN_RIGHT' || cmdUpper === 'BELOK_KANAN' || cmdUpper === 'RIGHT') {
            this.currentAngle += 90;
            if (typeof playTurnSound === 'function') playTurnSound();
            this.updateRobotUI(true);
            return { success: true };
        } else if (cmdUpper === 'TURN_LEFT' || cmdUpper === 'BELOK_KIRI' || cmdUpper === 'LEFT') {
            this.currentAngle -= 90;
            if (typeof playTurnSound === 'function') playTurnSound();
            this.updateRobotUI(true);
            return { success: true };
        }
        return { success: true };
    }

    handleCollision(reason) {
        if (typeof playErrorSound === 'function') playErrorSound();
        const robotToken = document.getElementById('robot-mascot');
        if (robotToken) {
            robotToken.classList.add('shake-anim');
            setTimeout(() => robotToken.classList.remove('shake-anim'), 500);
        }

        let diagMsg = 'Robot Kiko belum berhasil mencapai Bintang Emas.';
        if (reason === 'boundary') {
            diagMsg = 'Aduh! Robot Kiko menabrak tepi arena (keluar batas jalur)! Periksa arah hadap dan jumlah langkahmu.';
        } else if (reason === 'obstacle') {
            diagMsg = 'Ups! Robot Kiko menabrak rintangan karang/air! Coba arahkan robot berbelok melingkari rintangan.';
        }

        this.showRetryModal(diagMsg);
    }

    evaluateOutcome() {
        const reachedGoal = (this.currentX === this.targetX && this.currentY === this.targetY);

        if (reachedGoal) {
            if (typeof playSuccessSound === 'function') playSuccessSound();
            this.showVictoryModal();
            this.saveProgressToDB(true);
        } else {
            if (typeof playErrorSound === 'function') playErrorSound();
            const diagMsg = `Robot Kiko berhenti di koordinat (X: ${this.currentX}, Y: ${this.currentY}), sedangkan Bintang Emas ada di (X: ${this.targetX}, Y: ${this.targetY}).`;
            this.showRetryModal(diagMsg);
            this.saveProgressToDB(false);
        }
    }

    showVictoryModal() {
        this.updateMascotSpeech('success');
        const modal = document.getElementById('victory-modal') || document.getElementById('modal-cleared');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    showRetryModal(diagMsg) {
        this.updateMascotSpeech('failure', diagMsg);
        const msgEl = document.getElementById('retry-diagnostic-msg') || document.getElementById('fail-reason');
        if (msgEl && diagMsg) {
            msgEl.textContent = diagMsg;
        }
        const modal = document.getElementById('retry-modal') || document.getElementById('modal-failed');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    closeVictoryModal() {
        const modal = document.getElementById('victory-modal') || document.getElementById('modal-cleared');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
        this.resetPositionOnly();
    }

    closeRetryModal() {
        const modal = document.getElementById('retry-modal') || document.getElementById('modal-failed');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
        this.resetPositionOnly();
    }

    saveProgressToDB(isCorrect) {
        fetch(this.saveProgressUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                level_id: this.levelId,
                challenge_id: this.challengeId,
                is_correct: isCorrect,
                used_hint: this.usedHint,
                score: isCorrect ? this.xpReward : 0,
                commands: this.commandQueue
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log('Progress sync result:', data);
            if (data.success && isCorrect) {
                // Update header XP badge if present
                const headerXp = document.getElementById('header-xp');
                if (headerXp && data.new_xp) {
                    headerXp.innerHTML = `<span class="material-symbols-rounded">bolt</span> ${data.new_xp} XP`;
                }
            }
        })
        .catch(err => {
            console.warn('Progress sync network error:', err);
        });
    }
}
