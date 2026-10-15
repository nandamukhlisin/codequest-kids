---
name: Playful Tactile EdTech
colors:
  surface: '#faf8ff'
  surface-dim: '#ced9ff'
  surface-bright: '#faf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f3ff'
  surface-container: '#eaedff'
  surface-container-high: '#e2e7ff'
  surface-container-highest: '#dae2ff'
  on-surface: '#0d1a39'
  on-surface-variant: '#434654'
  inverse-surface: '#232f4f'
  inverse-on-surface: '#eef0ff'
  outline: '#737686'
  outline-variant: '#c3c5d7'
  surface-tint: '#1b53d6'
  primary: '#003aa7'
  on-primary: '#ffffff'
  primary-container: '#1550d3'
  on-primary-container: '#c8d3ff'
  inverse-primary: '#b5c4ff'
  secondary: '#755b00'
  on-secondary: '#ffffff'
  secondary-container: '#fdd259'
  on-secondary-container: '#735a00'
  tertiary: '#004f3a'
  on-tertiary: '#ffffff'
  tertiary-container: '#00694f'
  on-tertiary-container: '#81e8c2'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dce1ff'
  primary-fixed-dim: '#b5c4ff'
  on-primary-fixed: '#00164d'
  on-primary-fixed-variant: '#003cad'
  secondary-fixed: '#ffe08f'
  secondary-fixed-dim: '#ebc24a'
  on-secondary-fixed: '#241a00'
  on-secondary-fixed-variant: '#584400'
  tertiary-fixed: '#8ff6cf'
  tertiary-fixed-dim: '#72d9b4'
  on-tertiary-fixed: '#002116'
  on-tertiary-fixed-variant: '#00513c'
  background: '#faf8ff'
  on-background: '#0d1a39'
  surface-variant: '#dae2ff'
  canvas-bg: '#F5F7FF'
  surface-white: '#FFFFFF'
  card-stroke: '#E1E7FC'
  primary-shade: '#335FE6'
  mint-shade: '#43B990'
  yellow-shade: '#E0B32E'
  coral-accent: '#FF8B75'
  coral-shade: '#E06852'
  soft-purple: '#A78BFA'
  purple-shade: '#8B67EB'
  locked-gray: '#D1D8E8'
  locked-text: '#8F9CB7'
typography:
  headline-xl:
    fontFamily: Quicksand
    fontSize: 44px
    fontWeight: '700'
    lineHeight: 52px
  headline-xl-mobile:
    fontFamily: Quicksand
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
  headline-lg:
    fontFamily: Quicksand
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
  headline-lg-mobile:
    fontFamily: Quicksand
    fontSize: 26px
    fontWeight: '700'
    lineHeight: 34px
  headline-md:
    fontFamily: Quicksand
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-sm:
    fontFamily: Quicksand
    fontSize: 20px
    fontWeight: '700'
    lineHeight: 28px
  body-lg:
    fontFamily: Nunito Sans
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 28px
  body-md:
    fontFamily: Nunito Sans
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-sm:
    fontFamily: Nunito Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
  label-badge:
    fontFamily: Nunito Sans
    fontSize: 13px
    fontWeight: '800'
    lineHeight: 16px
  label-code-block:
    fontFamily: Space Grotesk
    fontSize: 16px
    fontWeight: '700'
    lineHeight: 20px
  label-caption:
    fontFamily: Nunito Sans
    fontSize: 12px
    fontWeight: '700'
    lineHeight: 16px
rounded:
  sm: 0.5rem
  DEFAULT: 1rem
  md: 1.5rem
  lg: 2rem
  xl: 3rem
  full: 9999px
spacing:
  gutter: 1.25rem
  gutter-mobile: 0.75rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.5rem
---

## Brand & Style

Designed for young learners and gamified educational journeys, this system blends tactile toy-like affordances with friendly clarity. The personality is optimistic, encouraging, and structured—transforming abstract computational logic into physical-like blocks that kids can manipulate with confidence.

The aesthetic fuses **Tactile / Skeuomorphic Micro-Affordances** with **Modern Rounded EdTech Minimalism**:
- **Tactile feedback:** Solid bottom lip shadows (`shadow-[0_2px_0_...]` and `shadow-[0_4px_0_...]`) mimic physical extruded push buttons, building instant spatial comprehension.
- **Friendly soft geometry:** High border radii (pill buttons, rounded tile boards) reduce cognitive friction and evoke toy blocks or modern handheld gaming devices.
- **Playful palette contrast:** Bright semantic action colors (emerald mint for progress, golden yellow for stars/rewards, deep royal blue for focus, and warm coral for alerts/resets) set against a soft periwinkle-tinted neutral canvas.

## Colors

The palette establishes an encouraging gamified environment where visual cues directly translate to game mechanics and computational logic.

### Primary Role (Action & Navigation)
- **Primary (`#1550d3`) & Primary Fixed (`#dce1ff`):** Used for platform identity, navigational anchors, primary action states, and robot player markers.
- **Primary Shade (`#335FE6`) & Shadow Accent (`#003CAD`):** Provides the solid bottom edge for 3D tactile buttons.

### Gamified Secondary & Tertiary Roles
- **Secondary (`#ffd45a` / `#755b00`) & Yellow Shade (`#E0B32E`):** Represents stars, XP achievements, bonus rewards, and contextual hints.
- **Tertiary (`#008565` / `#43B990`):** Represents execution ("JALANKAN KODE"), forward movement commands (`MAJU`), and progress success tokens.

### Feedback & Status Accents
- **Coral (`#FF8B75` / `#E06852`):** Warning cues, reset triggers, turn left markers, and activity streaks.
- **Locked Tones (`#D1D8E8`, `#8F9CB7`):** Disabled states, grid coordinates, and inactive slots.
- **Canvas Base (`#F5F7FF`):** A soft, cool periwinkle background preventing ocular fatigue during prolonged screen usage.

## Typography

The typographic hierarchy balances child-friendly roundness with technical structure:
- **Headlines (Quicksand, Bold 700):** Rounded terminal geometry provides friendliness and prevents institutional rigidity. It anchors mission titles, popups, and stage titles.
- **Body & Badges (Nunito Sans, SemiBold 600 - ExtraBold 800):** Ensures high legibility at small sizes for instructions, robot dialogues, and counter badges.
- **Code & Coordinate Labels (Space Grotesk, Bold 700):** Delivers a monospace-like geometric aesthetic for X/Y grid coordinates, Python translation blocks, and numerical step trackers.

## Layout & Spacing

The layout employs a responsive 12-column grid system capped at a maximum width of `1400px` for desktop play stages:
- **Desktop (>= 1280px):** Split layout allocating `7 columns` to the interactive simulation board/telemetry stage and `5 columns` to the command palette and sequence tray.
- **Mobile & Tablet (< 1280px):** Single-column stacked order placing the contextual guidance first, followed by the active grid stage, and trailing with the command desk. Fixed bottom navigation bar (`64px` height) replaces header navigation.
- **Spacing Rhythm:** Built on an intentional 4px base multiplier. Internal card gaps use `space-xs` (4px) and `space-sm` (8px), card container padding adheres strictly to `space-md` (16px), while layout section gaps utilize `space-lg` (24px).

## Elevation & Depth

Visual hierarchy uses **Tactile Push Insets** instead of diffused photorealistic drop shadows:
- **Tactile Base Shadow (`0 2px 0 #D3DBF4`):** Applied to standard interactive cards, stat pills, and secondary controls.
- **High-Impact Action Push (`0 4px 0 #003CAD` / `0 4px 0 #43B990`):** Used on primary run buttons and mission progress chips. Interacting with these triggers an `active:translate-y-0.5` or `active:translate-y-1` shift to deliver immediate kinetic feedback.
- **Overlays & Modals:** Layered with a `backdrop-blur-sm` over `inverse-surface/60`, anchored by an extruded base shadow (`0 8px 0 rgba(38,50,82,0.2)`).

## Shapes

The design embraces generous, friendly radii to evoke physical gaming pieces:
- **Base Containers & Play Cards:** Use `rounded-DEFAULT` (1rem / 16px) with clean card-stroke borders (`#E1E7FC`).
- **Interactive Buttons & Badges:** Utilize `rounded-full` (9999px) for friendly tactile touch points.
- **Grid Tiles & Command Item Blocks:** Use `rounded-xl` (12px to 16px) with distinct bottom border trims (`border-b-2`).

## Components

### Buttons
- **Primary CTA ("JALANKAN KODE"):** Full-width pill button styled in `tertiary-container` with white bold text, a 4px solid bottom rim in `mint-shade`, and active downward translation.
- **Secondary Actions:** White or tinted soft pill buttons with `0 2px 0` solid rim shadows and icon pairings.

### Command Blocks & Sequence Items
- **Instruction Cards:** Horizontal stack elements with left-aligned order index badge, directional arrow, command name, and a discreet close button.
- **Color Coding:** Green tints for forward moves (`MAJU`), amber for clockwise turns (`BELOK KANAN`), and coral for counter-clockwise turns (`BELOK KIRI`).

### Interactive Grid Board
- 4x4 matrix of uniform square cells (`rounded-xl`) with coordinate watermarks in the bottom-right corner.
- Dynamic token element with continuous pulse and transition transform states when translating across steps.

### Metric Chips & Badges
- Compact pill-shaped containers with 16px inline Material Symbols and paired label/value metadata.

### Modals & Dialog Balloons
- Mascot speech cards featuring extruded speech arrows, soft container backgrounds, and highlight pill tags for key learning concepts.