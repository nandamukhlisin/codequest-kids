/**
 * CodeQuest Kids — Global Application JS
 * Sound Effects, Modals, Audio Narrator, and Navigation
 */

let sfxEnabled = true;
let audioCtx = null;

function getAudioContext() {
    if (!audioCtx) {
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        if (AudioContext) {
            audioCtx = new AudioContext();
        }
    }
    if (audioCtx && audioCtx.state === 'suspended') {
        audioCtx.resume();
    }
    return audioCtx;
}

function playTone(freq, type = 'sine', duration = 0.15) {
    if (!sfxEnabled) return;
    try {
        const ctx = getAudioContext();
        if (!ctx) return;
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = type;
        osc.frequency.setValueAtTime(freq, ctx.currentTime);
        gain.gain.setValueAtTime(0.12, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + duration);
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + duration);
    } catch (e) {
        // Fallback silently if audio not allowed yet
    }
}

function playClickSound() {
    playTone(600, 'triangle', 0.08);
}

function playStepSound() {
    playTone(420, 'sine', 0.12);
}

function playTurnSound() {
    playTone(520, 'triangle', 0.14);
}

function playSuccessSound() {
    if (!sfxEnabled) return;
    try {
        setTimeout(() => playTone(523.25, 'triangle', 0.18), 0);
        setTimeout(() => playTone(659.25, 'triangle', 0.18), 120);
        setTimeout(() => playTone(783.99, 'triangle', 0.22), 240);
        setTimeout(() => playTone(1046.50, 'triangle', 0.4), 380);
    } catch (e) {}
}

function playErrorSound() {
    if (!sfxEnabled) return;
    try {
        playTone(220, 'sawtooth', 0.22);
        setTimeout(() => playTone(174.61, 'sawtooth', 0.3), 180);
    } catch (e) {}
}

function toggleSFX() {
    sfxEnabled = !sfxEnabled;
    const sfxIcon = document.getElementById('sfx-icon');
    const sfxText = document.getElementById('sfx-text');
    if (sfxIcon) {
        sfxIcon.textContent = sfxEnabled ? 'volume_up' : 'volume_off';
    }
    if (sfxText) {
        sfxText.textContent = sfxEnabled ? 'SFX ON' : 'SFX OFF';
    }
    if (sfxEnabled) {
        playTone(650, 'sine', 0.15);
    }
}

/* ─── Modal Helpers ─────────────────────────────────────────── */
function openModal(modalId) {
    playClickSound();
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    playClickSound();
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

/* ─── Text to Speech Narrator ───────────────────────────────── */
let isSpeaking = false;
function speakText(text) {
    if (!('speechSynthesis' in window)) {
        alert("Browser tidak mendukung narasi suara.");
        return;
    }
    if (window.speechSynthesis.speaking) {
        window.speechSynthesis.cancel();
        isSpeaking = false;
        return;
    }
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'id-ID';
    utterance.rate = 0.95;
    utterance.pitch = 1.1; // Friendly higher pitch for robot/kid character
    utterance.onend = () => { isSpeaking = false; };
    utterance.onerror = () => { isSpeaking = false; };
    isSpeaking = true;
    window.speechSynthesis.speak(utterance);
}

/* ─── Mobile Navigation Toggle ──────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const mainNav = document.getElementById('main-nav');
    if (toggleBtn && mainNav) {
        toggleBtn.addEventListener('click', () => {
            const isVisible = mainNav.style.display === 'flex';
            mainNav.style.display = isVisible ? 'none' : 'flex';
            mainNav.style.position = isVisible ? '' : 'absolute';
            mainNav.style.top = isVisible ? '' : '4.5rem';
            mainNav.style.left = isVisible ? '' : '1rem';
            mainNav.style.right = isVisible ? '' : '1rem';
            mainNav.style.flexDirection = isVisible ? '' : 'column';
            mainNav.style.padding = isVisible ? '' : '1rem';
            mainNav.style.background = isVisible ? '' : 'var(--surface-white)';
            mainNav.style.borderRadius = isVisible ? '' : 'var(--radius-md)';
            mainNav.style.boxShadow = isVisible ? '' : 'var(--shadow-modal)';
        });
    }

    // Attach click sound to buttons
    document.querySelectorAll('.btn, .cmd-btn, .nav-link').forEach(el => {
        el.addEventListener('click', () => {
            playClickSound();
        });
    });
});
