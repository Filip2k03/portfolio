<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stephan Filip | Full Stack Developer</title>

  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" as="style">
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" as="style">

  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Montserrat:wght@400;600&family=Share+Tech+Mono&display=swap"
    rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://unpkg.com/alpinejs" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>
  <!-- D3.js for the interactive skill graph -->
  <script src="https://d3js.org/d3.v7.min.js"></script>

  <style>
    :root {
      --dominant: #0f0617;
      --secondary: #00cfff;
      --accent: #00ffe7;
      --danger: #ff0057;
      --glass: rgba(24, 18, 38, 0.82);
      --glow: 0 0 24px var(--secondary), 0 0 48px var(--accent), 0 0 8px var(--danger);
      --btn-bg: linear-gradient(90deg, var(--secondary) 0%, var(--accent) 100%);
      --btn-text: var(--dominant);
      --btn-hover-bg: linear-gradient(90deg, var(--danger) 0%, var(--secondary) 100%);
      --btn-shadow: 0 0 32px var(--secondary)cc, 0 0 64px var(--accent)44;
      --btn-hover-shadow: 0 0 64px var(--danger), 0 0 128px var(--secondary);
      --nav-bg: rgba(15, 6, 23, 0.98);
      --nav-border: var(--secondary);
    }

    body {
      font-family: 'Orbitron', 'Montserrat', 'Share Tech Mono', monospace, sans-serif;
      background: linear-gradient(135deg, var(--dominant) 0%, #1a0933 100%);
      color: #ffe600; 
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
      cursor: none; 
    }

    body.light-theme {
      --dominant: #f0f6ff;
      --secondary: #66ccff;
      --accent: #33e7ff;
      --danger: #e73357;
      --glass: rgba(255, 255, 255, 0.9);
      --glow: 0 0 12px var(--secondary), 0 0 24px var(--accent), 0 0 4px var(--danger);
      --btn-bg: linear-gradient(90deg, var(--secondary) 0%, var(--accent) 100%);
      --btn-text: var(--dominant);
      --btn-hover-bg: linear-gradient(90deg, var(--danger) 0%, var(--secondary) 100%);
      --btn-shadow: 0 0 16px var(--secondary)cc, 0 0 32px var(--accent)44;
      --btn-hover-shadow: 0 0 32px var(--danger), 0 0 64px var(--secondary);
      color: #333;
      background: linear-gradient(135deg, #e0e0e0 0%, #f0f0f0 100%);
    }

    /* Scroll Progress Bar */
    #scroll-progress {
      position: fixed;
      top: 0;
      left: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--secondary), var(--accent), var(--danger));
      width: 0%;
      z-index: 9999;
      box-shadow: 0 0 10px var(--accent), 0 0 20px var(--danger);
      transition: width 0.1s ease-out;
    }

    /* Matrix Rain Canvas */
    #matrix-canvas {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
      opacity: 0.15;
      pointer-events: none;
    }
    body.light-theme #matrix-canvas {
      opacity: 0.05;
    }

    .about-cyber-bg::after {
      content: '';
      position: absolute;
      inset: 0;
      background: url('https://assets.codepen.io/1468070/glitch-crack.svg');
      background-size: cover;
      opacity: 0.18;
      pointer-events: none;
      z-index: 2;
    }

    .glass {
      background: var(--glass) !important;
      backdrop-filter: blur(16px);
      border: 2px solid rgba(255, 255, 255, 0.10);
      box-shadow: 0 12px 48px 0 var(--accent)44, 0 0 0 2px #ffe60033 inset;
      opacity: 1;
      transition: opacity 0.3s;
    }

    body.light-theme .glass {
      box-shadow: 0 12px 48px 0 var(--accent)44, 0 0 0 2px #33333333 inset;
      border: 2px solid rgba(0, 0, 0, 0.10);
    }

    @keyframes glass-flicker {
      0%, 100% { opacity: 1; }
      48% { opacity: 0.92; }
      52% { opacity: 0.85; }
    }

    .glass,
    .robotic-panel {
      animation: glass-flicker 2.5s infinite;
    }

    .glitch {
      position: relative;
      color: var(--secondary);
    }

    .glitch::before,
    .glitch::after {
      content: attr(data-text);
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      overflow: hidden;
      color: var(--accent);
      z-index: 2;
      opacity: 0.7;
      pointer-events: none;
    }

    .glitch::before {
      left: 2px;
      text-shadow: -2px 0 var(--danger);
      animation: glitch1 2s infinite linear alternate-reverse;
    }

    .glitch::after {
      left: -2px;
      text-shadow: 2px 0 var(--accent);
      animation: glitch2 2s infinite linear alternate;
    }

    @keyframes glitch1 {
      0% { clip-path: inset(0 0 80% 0); }
      100% { clip-path: inset(80% 0 0 0); }
    }

    @keyframes glitch2 {
      0% { clip-path: inset(80% 0 0 0); }
      100% { clip-path: inset(0 0 80% 0); }
    }

    .project-card.glitch-on-hover:hover .project-title::before,
    .project-card.glitch-on-hover:hover .project-title::after {
      animation: glitch1 0.7s infinite linear alternate-reverse;
    }

    .project-card.glitch-on-hover:hover .project-title::after {
      animation: glitch2 0.7s infinite linear alternate;
    }

    .glow {
      box-shadow: var(--glow);
      text-shadow: 0 0 12px #ffe600, 0 0 24px var(--accent), 0 0 4px var(--danger);
      font-family: 'Orbitron', 'Montserrat', sans-serif;
      letter-spacing: 0.12em;
      color: #ffe600;
    }

    body.light-theme .glow {
      text-shadow: 0 0 6px var(--secondary), 0 0 12px var(--accent), 0 0 2px var(--danger);
      color: var(--dominant);
    }

    .neon-border {
      border: 2.5px solid var(--accent);
      box-shadow: 0 0 16px var(--accent), 0 0 32px var(--secondary), 0 0 8px var(--danger);
      border-radius: 1.5rem;
    }

    body.light-theme .neon-border {
      border: 2.5px solid var(--secondary);
      box-shadow: 0 0 8px var(--secondary), 0 0 16px var(--accent), 0 0 4px var(--danger);
    }

    .font-led {
      font-family: 'Share Tech Mono', 'Orbitron', monospace, sans-serif;
      letter-spacing: 0.18em;
      color: var(--accent);
      text-shadow:
        0 0 12px var(--accent),
        0 0 24px var(--accent),
        0 0 48px var(--accent),
        0 0 2px #ffe600;
      background: linear-gradient(90deg, var(--accent) 0%, #ffe600 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: led-flicker 2s infinite alternate;
    }

    body.light-theme .font-led {
      text-shadow:
        0 0 6px var(--secondary),
        0 0 12px var(--secondary),
        0 0 24px var(--secondary),
        0 0 1px var(--danger);
      background: linear-gradient(90deg, var(--secondary) 0%, var(--danger) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    @keyframes led-flicker {
      0%, 100% { opacity: 1; }
      45% { opacity: 0.8; }
      50% { opacity: 0.6; }
      55% { opacity: 0.8; }
    }

    .robotic-panel {
      border: 3px solid var(--accent);
      border-radius: 2.5rem;
      background: linear-gradient(135deg, #1a0933 80%, var(--dominant) 100%);
      box-shadow:
        0 0 48px var(--accent)cc,
        0 0 96px #ffe60044,
        0 0 0 6px var(--dominant) inset;
      position: relative;
      overflow: hidden;
    }

    body.light-theme .robotic-panel {
      border: 3px solid var(--secondary);
      background: linear-gradient(135deg, #e0e0e0 80%, #f0f0f0 100%);
      box-shadow:
        0 0 24px var(--secondary)cc,
        0 0 48px var(--danger)44,
        0 0 0 3px var(--dominant) inset;
    }

    .robotic-panel::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 2.5rem;
      pointer-events: none;
      box-shadow: 0 0 120px 20px var(--accent)44, 0 0 0 4px #ffe60022 inset;
      z-index: 1;
    }

    body.light-theme .robotic-panel::before {
      box-shadow: 0 0 60px 10px var(--secondary)44, 0 0 0 2px var(--danger)22 inset;
    }

    .futuristic-btn,
    #theme-toggle-btn,
    #scrollTopBtn,
    #chatbot-toggle,
    #sound-toggle-btn {
      font-family: 'Orbitron', 'Share Tech Mono', monospace, sans-serif;
      letter-spacing: 0.12em;
      background: var(--btn-bg) !important;
      color: var(--btn-text) !important;
      border: none !important;
      box-shadow: var(--btn-shadow) !important;
      transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
      text-transform: uppercase;
      font-weight: bold;
    }

    .futuristic-btn:hover,
    #theme-toggle-btn:hover,
    #scrollTopBtn:hover,
    #chatbot-toggle:hover,
    #sound-toggle-btn:hover {
      background: var(--btn-hover-bg) !important;
      box-shadow: var(--btn-hover-shadow) !important;
      transform: scale(1.12) translateY(-4px) rotate(-2deg);
      color: var(--danger) !important;
    }

    .futuristic-btn[data-filter].active {
      background: linear-gradient(90deg, var(--danger) 0%, var(--accent) 100%) !important;
      box-shadow: 0 0 24px var(--accent), 0 0 48px var(--danger) !important;
      color: var(--btn-text) !important;
      transform: scale(1.05);
    }

    .futuristic-link {
      color: var(--danger);
      text-decoration: underline wavy 2px;
      transition: color 0.2s;
      font-family: 'Orbitron', 'Montserrat', sans-serif;
      font-weight: bold;
    }

    .futuristic-link:hover {
      color: var(--accent);
      text-shadow: 0 0 8px #ffe600, 0 0 16px var(--accent);
    }

    body.light-theme .futuristic-link {
      color: var(--secondary);
    }

    body.light-theme .futuristic-link:hover {
      color: var(--danger);
      text-shadow: 0 0 4px var(--accent), 0 0 8px var(--secondary);
    }

    ::selection {
      background: #ffe60044;
    }

    .circuit-bg {
      position: absolute;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      opacity: 0.18;
      background: url('https://assets.codepen.io/1468070/cyberpunk-circuit.svg');
      background-size: cover;
      background-repeat: no-repeat;
      mix-blend-mode: lighten;
      animation: circuit-move 40s linear infinite alternate;
      filter: contrast(1.2) brightness(1.1) blur(0.5px);
    }

    body.light-theme .circuit-bg {
      filter: contrast(0.8) brightness(0.9) blur(0.5px) grayscale(0.5);
      mix-blend-mode: multiply;
    }

    @keyframes circuit-move {
      0% { background-position: 0 0; }
      100% { background-position: 200px 200px; }
    }

    .cyberpunk-robot {
      filter: drop-shadow(0 0 24px #ffe600) drop-shadow(0 0 48px var(--accent)) drop-shadow(0 0 8px var(--danger));
      animation: robot-flicker 2.5s infinite alternate;
    }

    body.light-theme .cyberpunk-robot {
      filter: drop-shadow(0 0 12px var(--secondary)) drop-shadow(0 0 24px var(--accent)) drop-shadow(0 0 4px var(--danger));
    }

    @keyframes robot-flicker {
      0%, 100% { opacity: 1; }
      40% { opacity: 0.85; }
      50% { opacity: 0.7; }
      60% { opacity: 0.85; }
    }

    .about-cyber-bg {
      background: linear-gradient(120deg, var(--dominant) 70%, var(--danger) 100%);
      border: 2px solid #ffe600;
      box-shadow: 0 0 32px var(--danger)88, 0 0 64px var(--accent)44;
      position: relative;
      overflow: hidden;
    }

    body.light-theme .about-cyber-bg {
      background: linear-gradient(120deg, var(--dominant) 70%, var(--danger) 100%);
      border: 2px solid var(--secondary);
      box-shadow: 0 0 16px var(--danger)88, 0 0 32px var(--secondary)44;
    }

    .about-cyber-bg::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url('https://assets.codepen.io/1468070/cyberpunk-circuit.svg');
      background-size: cover;
      background-repeat: no-repeat;
      opacity: 0.13;
      z-index: 0;
      pointer-events: none;
      filter: blur(1px) brightness(1.2);
    }

    body.light-theme .about-cyber-bg::before {
      filter: blur(0.5px) brightness(1.1) grayscale(0.2);
    }

    .about-cyber-bg>* {
      position: relative;
      z-index: 1;
    }

    @keyframes flicker-subtle {
      0%, 100% { opacity: 1; }
      5% { opacity: 0.95; }
      10% { opacity: 1; }
      15% { opacity: 0.9; }
      20% { opacity: 1; }
      25% { opacity: 0.95; }
      30% { opacity: 1; }
      35% { opacity: 0.9; }
      40% { opacity: 1; }
      45% { opacity: 0.98; }
      50% { opacity: 0.9; }
      55% { opacity: 0.97; }
      60% { opacity: 1; }
    }

    .flicker {
      animation: flicker-subtle 4s infinite step-end;
    }

    .certificates-carousel-container { position: relative; }
    .certificates-carousel {
        display: flex;
        overflow-x: scroll;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .certificates-carousel::-webkit-scrollbar { display: none; }
    
    .carousel-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.6);
        color: #FFD166;
        padding: 0.75rem 0.5rem;
        border-radius: 9999px;
        cursor: pointer;
        z-index: 10;
        opacity: 0.7;
        transition: opacity 0.3s, background 0.2s, color 0.2s;
        box-shadow: 0 0 10px rgba(255, 209, 102, 0.5);
    }
    .carousel-button:hover {
        opacity: 1;
        box-shadow: 0 0 15px rgba(255, 209, 102, 0.8);
        background: var(--btn-hover-bg);
        color: var(--btn-text);
    }
    .carousel-button.left { left: 0.5rem; }
    .carousel-button.right { right: 0.5rem; }

    body.light-theme .carousel-button {
      background: rgba(255, 255, 255, 0.6);
      color: #7952B3;
      box-shadow: 0 0 10px rgba(121, 82, 179, 0.5);
    }
    body.light-theme .carousel-button:hover {
      box-shadow: 0 0 15px rgba(121, 82, 179, 0.8);
    }

    #chatbot-input:disabled {
        background-color: #311c3b77;
        cursor: not-allowed;
        border-color: #FFD16655;
    }

    #skill-graph-container {
      width: 100%;
      height: 500px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 2rem;
      position: relative;
    }

    #skill-dna-svg {
        width: 100%;
        height: 100%;
        max-width: 800px;
        max-height: 600px;
        overflow: visible;
    }

    .dna-helix {
        fill: none;
        stroke: var(--secondary);
        stroke-width: 2px;
        stroke-dasharray: 1000;
        stroke-dashoffset: 1000;
        filter: drop-shadow(0 0 5px var(--secondary));
    }

    .dna-node-group {
        opacity: 0;
        transform: scale(0.5);
        transition: opacity 0.3s, transform 0.3s;
        cursor: pointer;
    }

    .dna-node-circle {
        stroke: #fff;
        stroke-width: 1.5px;
        filter: drop-shadow(0 0 3px);
        transition: r 0.2s, stroke-width 0.2s, filter 0.2s;
    }

    .dna-node-text {
        font-family: 'Share Tech Mono', monospace;
        font-size: 10px;
        fill: #fff;
        pointer-events: none;
        text-shadow: 0 0 4px rgba(0, 0, 0, 0.8);
    }

    .dna-node-group.highlight .dna-node-circle {
        r: 10px;
        stroke-width: 4px;
        stroke: var(--danger);
        filter: drop-shadow(0 0 8px var(--danger));
    }
    .dna-node-group.highlight .dna-node-text {
        font-size: 14px;
        fill: var(--danger);
        text-shadow: 0 0 8px var(--danger);
    }

    .project-card {
      position: relative;
      overflow: hidden;
    }

    .hologram-preview {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(0.8) rotateX(0deg) rotateY(0deg);
      width: 100%;
      height: 100%;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease-out, transform 0.3s ease-out;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 255, 231, 0.6);
    }

    .project-card:hover .hologram-preview {
      opacity: 1;
      transform: translate(-50%, -50%) scale(1) rotateX(5deg) rotateY(-5deg);
    }

    .hologram-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(1.2) contrast(1.1) saturate(1.2);
    }

    .hologram-scanline {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(rgba(0, 255, 231, 0.3) 0%, transparent 50%, rgba(0, 255, 231, 0.3) 100%);
      animation: scanline-move 2s infinite linear;
      mix-blend-mode: overlay;
      opacity: 0.8;
    }

    @keyframes scanline-move {
      0% { transform: translateY(-100%); }
      100% { transform: translateY(100%); }
    }

    #sound-toggle-btn {
      position: fixed;
      top: 1.5rem;
      right: 6rem;
      z-index: 50;
      border-radius: 9999px;
      padding: 0.75rem;
      font-size: 1.25rem;
    }

    .current-focus-item {
        background-color: #210B2C;
        border-left: 4px solid var(--secondary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .current-focus-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
    }
    body.light-theme .current-focus-item {
        background-color: #e0e0e0;
        border-left-color: var(--secondary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    body.light-theme .current-focus-item:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    #hero-terminal-input {
        background: transparent;
        border: none;
        outline: none;
        width: 100%;
        color: inherit;
        font-family: 'Share Tech Mono', monospace;
        font-size: inherit;
        text-align: center;
        caret-color: #ffe600;
    }
    #hero-terminal-input::placeholder {
        color: rgba(255, 230, 0, 0.5);
    }

    .section-scan-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 255, 231, 0.1) 0%, rgba(0, 255, 231, 0.5) 50%, rgba(0, 255, 231, 0.1) 100%);
        opacity: 0;
        pointer-events: none;
        z-index: 10;
        transform: scaleY(0);
        transform-origin: top;
    }

    .hologram-profile-container {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 2rem auto;
        perspective: 1000px;
        pointer-events: auto;
    }

    .hologram-profile-cube {
        position: relative;
        width: 100%;
        height: 100%;
        transform-style: preserve-3d;
        transform: rotateX(15deg) rotateY(-15deg);
        transition: transform 0.1s ease-out;
    }

    .hologram-profile-face {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 2px solid var(--accent);
        background: rgba(0, 255, 231, 0.1);
        box-shadow: 0 0 15px var(--accent), inset 0 0 10px var(--accent);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .hologram-profile-face.front  { transform: rotateY(0deg) translateZ(50px); }
    .hologram-profile-face.back   { transform: rotateY(180deg) translateZ(50px); }
    .hologram-profile-face.right  { transform: rotateY(90deg) translateZ(50px); }
    .hologram-profile-face.left   { transform: rotateY(-90deg) translateZ(50px); }
    .hologram-profile-face.top    { transform: rotateX(90deg) translateZ(50px); }
    .hologram-profile-face.bottom { transform: rotateX(-90deg) translateZ(50px); }

    .hologram-profile-avatar {
        width: 80%;
        height: 80%;
        object-fit: cover;
        border-radius: 50%;
        filter: brightness(1.1) contrast(1.1) saturate(1.1) drop-shadow(0 0 10px var(--secondary));
        position: relative;
        z-index: 2;
    }

    .hologram-indicator {
        position: absolute;
        width: 8px;
        height: 8px;
        background-color: var(--danger);
        border-radius: 50%;
        box-shadow: 0 0 8px var(--danger);
        animation: blink 1.5s infinite alternate;
        z-index: 3;
    }
    .hologram-indicator.top-left { top: 5px; left: 5px; }
    .hologram-indicator.top-right { top: 5px; right: 5px; }
    .hologram-indicator.bottom-left { bottom: 5px; left: 5px; }
    .hologram-indicator.bottom-right { bottom: 5px; right: 5px; }

    .hologram-data-line {
        position: absolute;
        background: linear-gradient(to right, transparent, var(--secondary), transparent);
        height: 2px;
        animation: data-flow 3s infinite linear;
        z-index: 1;
    }
    .hologram-data-line.line-1 { top: 20%; left: 0; width: 100%; animation-delay: 0s; }
    .hologram-data-line.line-2 { top: 40%; left: 0; width: 100%; animation-delay: 1s; }
    .hologram-data-line.line-3 { top: 60%; left: 0; width: 100%; animation-delay: 2s; }

    /* Make HUD elements draggable */
    .hud-element {
        position: fixed;
        font-family: 'Share Tech Mono', monospace;
        font-size: 0.8rem;
        color: var(--accent);
        text-shadow: 0 0 5px var(--accent);
        z-index: 40;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(0, 255, 231, 0.3);
        background: rgba(15, 6, 23, 0.6);
        box-shadow: 0 0 10px rgba(0, 255, 231, 0.4);
        pointer-events: auto; 
        cursor: grab;
    }
    .hud-element:active { cursor: grabbing; }
    .hud-top-left { top: 1rem; left: 1rem; }
    .hud-top-right { top: 1rem; right: 1rem; text-align: right; }

    #visitor-tracker {
        position: fixed;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        width: 280px;
        padding: 1rem;
        background: var(--glass);
        border: 2px solid var(--secondary);
        border-radius: 1rem;
        box-shadow: var(--glow);
        font-family: 'Share Tech Mono', monospace;
        font-size: 0.9rem;
        color: var(--accent);
        z-index: 40;
        text-align: center;
        pointer-events: auto;
        cursor: grab;
    }
    #visitor-tracker:active { cursor: grabbing; }
    #visitor-tracker .scan-line-pulse {
        display: block;
        height: 2px;
        background: linear-gradient(to right, transparent, var(--danger), transparent);
        animation: scan-pulse 2s infinite linear;
        margin-top: 0.5rem;
    }

    .custom-cursor {
        position: fixed;
        top: 0;
        left: 0;
        width: 16px;
        height: 16px;
        background-color: var(--accent);
        border-radius: 50%;
        pointer-events: none;
        z-index: 9999;
        transform: translate(-50%, -50%);
        box-shadow: 0 0 10px var(--accent), 0 0 20px rgba(0, 255, 231, 0.5);
        transition: transform 0.05s linear;
    }

    .spotlight-effect {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        pointer-events: none;
        z-index: 9998;
        background: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(255, 255, 255, 0.05) 0%, transparent 20%);
        mix-blend-mode: overlay;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    body:not(.light-theme) .spotlight-effect { opacity: 1; }
    body.light-theme .spotlight-effect { opacity: 0; }

    #section-tooltip {
        position: fixed;
        top: 1rem;
        left: 50%;
        transform: translateX(-50%);
        background: var(--glass);
        border: 1px solid var(--secondary);
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-family: 'Share Tech Mono', monospace;
        font-size: 0.9rem;
        color: var(--accent);
        text-shadow: 0 0 5px var(--accent);
        box-shadow: 0 0 10px rgba(0, 255, 231, 0.4);
        z-index: 50;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        pointer-events: none;
    }

    #mini-nav {
        position: fixed;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 50;
        padding: 1rem 0.5rem;
        background: rgba(15, 6, 23, 0.6);
        border-radius: 0.5rem;
        border: 1px solid rgba(0, 255, 231, 0.3);
        box-shadow: 0 0 10px rgba(0, 255, 231, 0.4);
    }
    .mini-nav-dot {
        width: 12px;
        height: 12px;
        background-color: rgba(0, 207, 255, 0.4);
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.2s, box-shadow 0.2s, transform 0.2s;
    }
    .mini-nav-dot.active {
        background-color: var(--accent);
        box-shadow: 0 0 8px var(--accent), 0 0 16px rgba(0, 255, 231, 0.6);
        transform: scale(1.2);
    }
    .mini-nav-dot:hover:not(.active) {
        background-color: var(--secondary);
        box-shadow: 0 0 5px var(--secondary);
        transform: scale(1.1);
    }

    #live-demo-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease-in-out;
    }
    #live-demo-modal-overlay.visible {
        opacity: 1;
        pointer-events: auto;
    }

    #live-demo-modal-content {
        position: relative;
        width: 90%;
        height: 85%;
        background: var(--dominant);
        border: 2px solid var(--accent);
        box-shadow: 0 0 40px var(--accent)aa, 0 0 80px var(--secondary)88;
        border-radius: 1rem;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    #live-demo-iframe {
        flex-grow: 1;
        width: 100%;
        border: none;
        background-color: #000;
    }

    #live-demo-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--danger);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem;
        cursor: pointer;
        z-index: 1001;
        box-shadow: 0 0 15px var(--danger);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    /* 📱 STRICT MOBILE RESPONSIVE TWEAKS FOR < 480px */
    @media (max-width: 480px) {
        .glass, .robotic-panel {
            padding: 1.5rem !important; 
            border-radius: 1rem !important;
        }
        
        h2 { font-size: 2.75rem !important; line-height: 1.1 !important; }
        h3 { font-size: 1.75rem !important; }
        h4 { font-size: 1.3rem !important; }
        
        #hero-terminal-input { font-size: 1.2rem !important; }
        .futuristic-btn { padding: 0.6rem 1rem !important; font-size: 0.85rem !important; }
        
        /* DNA Graph sizing for mobile */
        #skill-graph-container { height: 350px !important; }
        
        /* Clean up HUDs & Controls so screen isn't cluttered */
        .hud-element { font-size: 0.55rem; padding: 0.25rem 0.5rem; }
        #hud-1 { top: 0.5rem; left: 0.5rem; }
        #hud-2 { top: 0.5rem; right: 0.5rem; }
        
        /* Shrink toggles and move down slightly to avoid notch/time area */
        #theme-toggle-btn { top: 3.5rem !important; right: 0.5rem !important; padding: 0.5rem !important; font-size: 1rem !important; }
        #sound-toggle-btn { top: 3.5rem !important; right: 3.5rem !important; padding: 0.5rem !important; font-size: 1rem !important; }
        
        #visitor-tracker { 
            bottom: 5.5rem !important; /* Stack above the chatbot widget */
            width: calc(100% - 2rem) !important; 
            max-width: 320px;
            font-size: 0.75rem; 
            padding: 0.75rem !important; 
        }
        
        #chatbot-widget { right: 16px !important; bottom: 16px !important; }
        #chatbot-window { width: calc(100vw - 32px); max-width: 320px; right: 0; }
        
        /* Terminal Boot Screen */
        #terminal-display { font-size: 1.2rem !important; padding: 1.5rem !important; width: 90% !important; min-width: auto !important; }
        #boot-progress-container { width: 90% !important; }

        /* Shrink the Hologram on mobile */
        .hologram-profile-container { transform: scale(0.7); margin: 0 auto; }

        #mini-nav { display: none; }
        .neon-divider { width: 80px; }

        /* Clean Github Stats Stacking */
        #github-stats-container {
            flex-direction: column;
            text-align: center;
        }
        #github-stats-container > div:first-child { flex-direction: column; gap: 1rem; }
        
        /* Section padding */
        section { padding-top: 3rem !important; padding-bottom: 3rem !important; }
    }
  </style>
</head>

<body>
  <!-- Feature 4: Scroll Progress Neon Bar -->
  <div id="scroll-progress"></div>

  <!-- Mobile Navigation Overlay -->
  <div class="mobile-nav-overlay hidden md:hidden" x-show="open" x-cloak></div>

  <!-- Feature 7: Enhanced Terminal Intro Boot Sequence -->
  <div id="terminal-intro"
    style="display:flex;position:fixed;z-index:9999;inset:0;align-items:center;justify-content:center;background:var(--dominant);flex-direction:column;">
    <div id="terminal-display"
      style="font-family:'Share Tech Mono',monospace;font-size:2rem;color:var(--accent);text-shadow:var(--glow);padding:2rem 3rem;border-radius:1.5rem;min-width:400px; text-align: left;">
      <span id="terminal-text"></span><span id="terminal-cursor" style="color:#ffe600;">█</span>
    </div>
    <div id="boot-progress-container" style="width: 400px; height: 10px; background: #311c3b; margin-top: 20px; border-radius: 5px; overflow: hidden; opacity: 0;">
      <div id="boot-progress-bar" style="width: 0%; height: 100%; background: var(--accent); box-shadow: 0 0 15px var(--accent);"></div>
    </div>
  </div>

  <!-- Theme Toggle Button -->
  <button id="theme-toggle-btn" class="fixed top-6 right-6 z-50 rounded-full p-3 text-xl focus:outline-none" aria-label="Toggle theme (light/dark)">
    <i class="fa-solid fa-moon"></i>
  </button>
  <!-- Sound Toggle Button -->
  <button id="sound-toggle-btn" class="fixed top-6 right-24 z-50 rounded-full p-3 text-xl focus:outline-none" aria-label="Toggle sound">
    <i class="fa-solid fa-volume-high"></i>
  </button>

  <!-- Custom Cursor -->
  <div class="custom-cursor"></div>
  <!-- Spotlight Effect -->
  <div class="spotlight-effect"></div>

  <!-- Feature 3: Draggable Floating Neon HUD Elements -->
  <div class="hud-element hud-top-left" id="hud-1">
      <span id="hud-time"></span><br>
      <span id="hud-weather"></span>
  </div>
  <div class="hud-element hud-top-right" id="hud-2">
      <span id="hud-battery"></span> <i class="fa-solid fa-battery-full"></i><br>
      <span id="hud-status"></span>
  </div>

  <!-- Circuit Background Overlay -->
  <div class="circuit-bg"></div>

  <!-- Robot Companion (Hidden on mobile) -->
  <div id="robot-container" class="hidden sm:block fixed left-4 bottom-10 z-40 pointer-events-none select-none"
    style="width:120px;height:120px;">
    <svg class="cyberpunk-robot" viewBox="0 0 120 120" width="80" height="80" fill="none"
      xmlns="http://www.w3.org/2000/svg">
      <defs>
        <filter id="cyber-glow">
          <feGaussianBlur stdDeviation="3" result="blur" />
          <feMerge>
            <feMergeNode in="blur" />
            <feMergeNode in="SourceGraphic" />
          </feMerge>
        </filter>
      </defs>
      <rect x="30" y="40" width="60" height="40" rx="16" fill="#1a0933" stroke="#ffe600" stroke-width="4"
        filter="url(#cyber-glow)" />
      <rect x="45" y="55" width="10" height="10" rx="3" fill="var(--accent)" filter="url(#cyber-glow)" />
      <rect x="65" y="55" width="10" height="10" rx="3" fill="var(--danger)" filter="url(#cyber-glow)" />
      <rect x="55" y="75" width="10" height="4" rx="2" fill="#ffe600" opacity="0.8" />
      <rect x="58" y="28" width="4" height="18" rx="2" fill="#ffe600" />
      <circle cx="60" cy="28" r="5" fill="var(--accent)" stroke="#ffe600" stroke-width="2" />
      <circle cx="38" cy="80" r="3" fill="var(--danger)" />
      <circle cx="82" cy="80" r="3" fill="var(--accent)" />
      <ellipse cx="60" cy="50" rx="18" ry="6" fill="#fff" opacity="0.08" />
      <path d="M40 60 Q35 70 50 80" stroke="var(--danger)" stroke-width="2" fill="none" filter="url(#cyber-glow)" />
      <path d="M80 60 Q85 70 70 80" stroke="var(--accent)" stroke-width="2" fill="none" filter="url(#cyber-glow)" />
      <polygon points="60,40 62,38 64,40 62,42" fill="var(--danger)" opacity="0.7" />
      <polygon points="50,60 52,58 54,60 52,62" fill="#ffe600" opacity="0.7" />
      <polygon points="70,60 72,58 74,60 72,62" fill="var(--accent)" opacity="0.7" />
    </svg>
  </div>

  <!-- Floating Section Tooltip -->
  <div id="section-tooltip" class="font-led"></div>

  <!-- Mini-Navigation Dots -->
  <div id="mini-nav"></div>

  <!-- Hero Section -->
  <section class="relative text-center py-20 px-4 md:py-44 overflow-hidden min-h-screen flex flex-col justify-center items-center" id="hero-section">
    <!-- Feature 1: Matrix Rain Canvas -->
    <canvas id="matrix-canvas"></canvas>
    
    <div class="absolute inset-0 pointer-events-none z-0">
      <div class="w-48 h-48 md:w-72 md:h-72 bg-[var(--accent)] rounded-full blur-3xl absolute top-0 left-1/2 -translate-x-1/2 opacity-20"></div>
      <div class="w-32 h-32 md:w-40 md:h-40 bg-[#FFD166] rounded-full blur-2xl absolute bottom-0 right-1/4 opacity-25"></div>
    </div>
    <div class="relative z-10 w-full">
      <h2 class="text-5xl sm:text-7xl md:text-8xl font-led mb-4 md:mb-6 tracking-widest">
        Hi, I'm Stephan Filip<br>
      </h2>
      <div class="neon-divider">|</div>
      <!-- Feature 6: Expanded Interactive Terminal Input -->
      <span id="typed-role" class="block text-xl sm:text-3xl md:text-4xl mt-4 max-w-[90%] mx-auto">
        <input type="text" id="hero-terminal-input" placeholder="Type 'help'..." />
      </span>
      <div class="mt-8 md:mt-12 flex flex-col md:flex-row justify-center items-center gap-4 md:gap-6">
        <a href="#projects" class="futuristic-btn px-8 py-4 md:px-10 md:py-5 text-lg md:text-2xl" id="hero-btn-projects">See Projects</a>
        <a href="resume.pdf" download
          class="px-8 py-4 md:px-10 md:py-5 border-2 border-[#FFD166] text-[#FFD166] rounded-full font-led hover:bg-[#FFD16622] transition text-lg md:text-2xl" id="hero-btn-resume">Download Resume</a>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="container mx-auto px-4 py-16 md:py-20">
    <div class="section-scan-overlay"></div>
    <div class="glass robotic-panel about-cyber-bg rounded-3xl p-6 md:p-10 shadow-xl max-w-3xl mx-auto text-center md:text-left">
      <h3 class="text-3xl md:text-4xl font-led mb-6 glitch" data-text="About Me">About Me</h3>
      <!-- Hologram Profile -->
      <div class="hologram-profile-container">
          <div class="hologram-profile-cube">
              <div class="hologram-profile-face front">
                  <img src="assets/schools/pf.jpg" onerror="this.src='https://placehold.co/200x200/1a0933/00ffe7?text=SF'" alt="Your Avatar" class="hologram-profile-avatar">
                  <div class="hologram-data-line line-1"></div>
                  <div class="hologram-data-line line-2"></div>
                  <div class="hologram-data-line line-3"></div>
              </div>
              <div class="hologram-profile-face back"></div>
              <div class="hologram-profile-face right"></div>
              <div class="hologram-profile-face left"></div>
              <div class="hologram-profile-face top"></div>
              <div class="hologram-profile-face bottom"></div>
          </div>
          <div class="hologram-indicator top-left"></div>
          <div class="hologram-indicator top-right"></div>
          <div class="hologram-indicator bottom-left"></div>
          <div class="hologram-indicator bottom-right"></div>
      </div>
      <p class="text-[#ffe600] text-lg md:text-xl leading-relaxed font-led mt-6 md:mt-0">
        <span class="text-[#ffe600]">I am a dedicated Full Stack Developer with a passion for creating immersive and visually striking web experiences. My journey in tech is driven by a love for blending futuristic UI, circuit chaos, and neon tech into functional and elegant solutions.</span><br><br>
        <span class="text-[#ffe600]">I'm the founder of <a href="https://payvia.shop" class="futuristic-link">PayVia</a> — a tech company building innovative POS systems and e-commerce platforms, extending digital solutions to businesses in Myanmar and beyond.</span><br><br>
        <span class="text-[#ffe600]">My expertise spans across both front-end and back-end technologies, allowing me to craft seamless, end-to-end applications. I thrive on challenges and constantly seek to expand my knowledge, currently exploring cutting-edge technologies and refining performance optimizations.</span>
      </p>
    </div>
  </section>

  <!-- Skills Section -->
  <section id="skills" class="py-16 md:py-20 bg-[#2E1F3C] px-4">
    <div class="section-scan-overlay"></div>
    <div class="container mx-auto">
      <div class="glass robotic-panel rounded-2xl p-6 md:p-10 shadow-2xl max-w-6xl mx-auto">
        <h3 class="text-3xl md:text-4xl font-bold text-[#FFD166] mb-8 glow font-orbitron text-center">Tech Stack</h3>
        <div class="flex flex-wrap justify-center gap-3 md:gap-4 mb-8">
          <button class="futuristic-btn px-4 py-2 md:px-6 md:text-base text-xs active" data-filter="all">All</button>
          <button class="futuristic-btn px-4 py-2 md:px-6 md:text-base text-xs" data-filter="frontend">Frontend</button>
          <button class="futuristic-btn px-4 py-2 md:px-6 md:text-base text-xs" data-filter="backend">Backend</button>
          <button class="futuristic-btn px-4 py-2 md:px-6 md:text-base text-xs" data-filter="database">Database</button>
          <button class="futuristic-btn px-4 py-2 md:px-6 md:text-base text-xs" data-filter="mobile">Mobile</button>
          <button class="futuristic-btn px-4 py-2 md:px-6 md:text-base text-xs" data-filter="cloud">Cloud/API</button>
        </div>

        <!-- DNA-style Skill Visualizer Container -->
        <div id="skill-graph-container" class="w-full overflow-hidden">
            <svg id="skill-dna-svg" viewBox="0 0 800 500" class="w-full h-full"></svg>
        </div>

      </div>
    </div>
  </section>

  <!-- Projects Section -->
  <section id="projects" class="py-16 md:py-20 container mx-auto px-4">
    <div class="section-scan-overlay"></div>
    <h3 class="text-3xl md:text-4xl font-led mb-10 text-center">Projects</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">
      
      <!-- Project Card: Shine Dana -->
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 md:p-8 shadow-2xl hover:-translate-y-2 hover:shadow-[0_0_32px_#FFD16688] duration-300 flex flex-col items-start">
        <h4 class="project-title text-xl md:text-2xl font-semibold text-[#FFD166] mb-2 font-orbitron" data-text="Shine Dana">Shine Dana</h4>
        <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat">A modern corporate portal providing digital solutions and streamlined services for the Shine Dana enterprise.</p>
        <div class="flex flex-wrap gap-3 md:gap-4 mt-auto w-full">
          <a href="https://www.shinedana.com" target="_blank" class="futuristic-link text-sm md:text-base">Visit Site <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
          <button class="futuristic-btn px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm ml-auto" data-project-url="https://www.shinedana.com">Run Live</button>
        </div>
        <div class="hologram-preview">
          <img src="https://placehold.co/400x250/1a0933/00ffe7?text=Shine+Dana+Preview" alt="Shine Dana Project Preview">
          <div class="hologram-scanline"></div>
        </div>
      </div>

      <!-- Project Card: Digital Marketplace MM -->
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 md:p-8 shadow-2xl hover:-translate-y-2 hover:shadow-[0_0_32px_#FFD16688] duration-300 flex flex-col items-start">
        <h4 class="project-title text-xl md:text-2xl font-semibold text-[#FFD166] mb-2 font-orbitron" data-text="Digital Marketplace MM">Digital Marketplace MM</h4>
        <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat">A robust multi-vendor e-commerce platform tailored specifically for the Myanmar digital market ecosystem.</p>
        <div class="flex flex-wrap gap-3 md:gap-4 mt-auto w-full">
          <a href="https://digitalmarketplacemm.com" target="_blank" class="futuristic-link text-sm md:text-base">Visit Site <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
          <button class="futuristic-btn px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm ml-auto" data-project-url="https://digitalmarketplacemm.com">Run Live</button>
        </div>
        <div class="hologram-preview">
          <img src="https://placehold.co/400x250/1a0933/00ffe7?text=Digital+Marketplace+MM" alt="Digital Marketplace MM Project Preview">
          <div class="hologram-scanline"></div>
        </div>
      </div>

      <!-- Project Card: DecaVerse -->
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 md:p-8 shadow-2xl hover:-translate-y-2 hover:shadow-[0_0_32px_#FFD16688] duration-300 flex flex-col items-start">
        <h4 class="project-title text-xl md:text-2xl font-semibold text-[#FFD166] mb-2 font-orbitron" data-text="DecaVerse">DecaVerse</h4>
        <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat">A modern Next.js platform for interactive web games with AI recommendations and scalable architecture.</p>
        <div class="flex flex-col gap-2 mt-auto w-full">
          <div class="flex justify-between items-center">
            <a href="https://deca-verse.vercel.app/" target="_blank" class="futuristic-link text-sm">Live Demo <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
            <button class="futuristic-btn px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm" data-project-url="https://deca-verse.vercel.app/">Run Live</button>
          </div>
          <a href="case-studies/decaverse.html" class="futuristic-link text-sm">View Case Study <i class="fa-solid fa-book-open ml-1"></i></a>
        </div>
        <div class="hologram-preview">
          <img src="https://placehold.co/400x250/1a0933/00ffe7?text=DecaVerse+Preview" alt="DecaVerse Project Preview">
          <div class="hologram-scanline"></div>
        </div>
      </div>

      <!-- Project Card: Find iPhone Myanmar -->
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 md:p-8 shadow-2xl hover:-translate-y-2 hover:shadow-[0_0_32px_#FFD16688] duration-300 flex flex-col items-start">
        <h4 class="project-title text-xl md:text-2xl font-semibold text-[#FFD166] mb-2 font-orbitron" data-text="Find iPhone MM">Find iPhone MM</h4>
        <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat">Stolen phone tracking site with OTP verification and admin dashboard.</p>
        <div class="flex flex-col gap-2 mt-auto w-full">
          <div class="flex justify-between items-center">
            <a href="https://findiphonemyanmar.com" target="_blank" class="futuristic-link text-sm">Live Site <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
            <button class="futuristic-btn px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm" data-project-url="https://findiphonemyanmar.com">Run Live</button>
          </div>
          <a href="case-studies/find-iphone-myanmar.html" class="futuristic-link text-sm">View Case Study <i class="fa-solid fa-book-open ml-1"></i></a>
        </div>
        <div class="hologram-preview">
          <img src="https://placehold.co/400x250/1a0933/00ffe7?text=Find+iPhone+Preview" alt="Find iPhone Myanmar Project Preview">
          <div class="hologram-scanline"></div>
        </div>
      </div>

      <!-- Project Card: PayVia -->
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 md:p-8 shadow-2xl hover:-translate-y-2 hover:shadow-[0_0_32px_#FFD16688] duration-300 flex flex-col items-start">
        <h4 class="project-title text-xl md:text-2xl font-semibold text-[#FFD166] mb-2 font-orbitron" data-text="PayVia">PayVia</h4>
        <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat">POS systems and ecommerce for Myanmar businesses. Built with Laravel and Vue.</p>
        <div class="flex flex-col gap-2 mt-auto w-full">
          <div class="flex justify-between items-center">
            <a href="https://payvia.shop" target="_blank" class="futuristic-link text-sm">Visit Site <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
            <button class="futuristic-btn px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm" data-project-url="https://payvia.shop">Run Live</button>
          </div>
          <a href="case-studies/payvia.html" class="futuristic-link text-sm">View Case Study <i class="fa-solid fa-book-open ml-1"></i></a>
        </div>
        <div class="hologram-preview">
          <img src="https://placehold.co/400x250/1a0933/00ffe7?text=PayVia+Preview" alt="PayVia Project Preview">
          <div class="hologram-scanline"></div>
        </div>
      </div>

      <!-- Project Card: MBLogistics Express -->
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 md:p-8 shadow-2xl hover:-translate-y-2 hover:shadow-[0_0_32px_#FFD16688] duration-300 flex flex-col items-start">
        <h4 class="project-title text-xl md:text-2xl font-semibold text-[#FFD166] mb-2 font-orbitron" data-text="MBLogistics">MBLogistics</h4>
        <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat">Modern logistics management platform for Myanmar couriers.</p>
        <div class="flex flex-col gap-2 mt-auto w-full">
          <div class="flex justify-between items-center">
            <a href="https://mblogistics.express" target="_blank" class="futuristic-link text-sm">Live Demo <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
            <button class="futuristic-btn px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm" data-project-url="https://mblogistics.express">Run Live</button>
          </div>
          <a href="case-studies/mblogistics-express.html" class="futuristic-link text-sm">View Case Study <i class="fa-solid fa-book-open ml-1"></i></a>
        </div>
        <div class="hologram-preview">
          <img src="https://placehold.co/400x250/1a0933/00ffe7?text=MBLogistics+Preview" alt="MBLogistics Express Project Preview">
          <div class="hologram-scanline"></div>
        </div>
      </div>
      
      <!-- Project Card: Ai.whisperX.site -->
       <div class="project-card glitch-on-hover glass rounded-2xl p-6 md:p-8 shadow-2xl hover:-translate-y-2 hover:shadow-[0_0_32px_#FFD16688] duration-300 flex flex-col items-start lg:col-span-3 lg:max-w-md mx-auto w-full">
        <h4 class="project-title text-xl md:text-2xl font-semibold text-[#FFD166] mb-2 font-orbitron" data-text="Ai.whisperX.site">Ai.whisperX.site</h4>
        <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat">Innovation AI for humanized content, assignments, diagrams, code generation, and debugging.</p>
        <div class="flex flex-col gap-2 mt-auto w-full">
          <div class="flex justify-between items-center">
            <a href="https://ai.whisperx.site" target="_blank" class="futuristic-link text-sm">Live Demo <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
            <button class="futuristic-btn px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm" data-project-url="https://ai.whisperx.site">Run Live</button>
          </div>
          <a href="case-studies/ai.whisperx.html" class="futuristic-link text-sm">View Case Study <i class="fa-solid fa-book-open ml-1"></i></a>
        </div>
        <div class="hologram-preview">
          <img src="https://placehold.co/400x250/1a0933/00ffe7?text=ai.WhisperX.site+Preview" alt="ai.WhisperX.site Project Preview">
          <div class="hologram-scanline"></div>
        </div>
      </div>
    </div>

    <!-- Feature 2: Real-time Github Stats Integration -->
    <h4 class="text-2xl md:text-3xl font-led mt-16 mb-8 text-center">GitHub Live Data</h4>
    <div id="github-stats-container" class="max-w-4xl mx-auto glass rounded-2xl p-6 shadow-2xl flex flex-col md:flex-row items-center justify-between mb-16 border-2 border-accent transition-all duration-300">
        <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6 mb-6 md:mb-0 text-center md:text-left">
            <img id="gh-avatar" src="https://placehold.co/80x80/1a0933/00ffe7?text=GH" class="w-20 h-20 md:w-24 md:h-24 rounded-full border-2 border-secondary shadow-[0_0_15px_#00cfff]">
            <div>
                <h5 class="text-xl md:text-2xl font-orbitron text-white glitch" data-text="Filip2k03">Filip2k03</h5>
                <p id="gh-bio" class="text-xs md:text-sm font-montserrat text-gray-400 mt-2 md:mt-0">Loading developer profile...</p>
            </div>
        </div>
        <div class="flex flex-wrap justify-center gap-4 md:gap-6 text-center font-share">
            <div class="glass p-3 rounded-lg bg-opacity-50 min-w-[80px]">
                <p class="text-accent text-2xl md:text-3xl font-bold" id="gh-repos">--</p>
                <p class="text-[0.65rem] md:text-xs text-gray-400 uppercase tracking-widest mt-1">Repos</p>
            </div>
            <div class="glass p-3 rounded-lg bg-opacity-50 min-w-[80px]">
                <p class="text-accent text-2xl md:text-3xl font-bold" id="gh-followers">--</p>
                <p class="text-[0.65rem] md:text-xs text-gray-400 uppercase tracking-widest mt-1">Followers</p>
            </div>
            <div class="glass p-3 rounded-lg bg-opacity-50 min-w-[80px]">
                <p class="text-accent text-2xl md:text-3xl font-bold" id="gh-following">--</p>
                <p class="text-[0.65rem] md:text-xs text-gray-400 uppercase tracking-widest mt-1">Following</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 shadow-2xl flex flex-col items-start hover:-translate-y-2 duration-300">
        <h5 class="project-title text-lg md:text-xl font-semibold text-[#BC96E6] mb-2 font-orbitron" data-text="Student Management Django">Student Management Django</h5>
        <a href="https://github.com/Filip2k03/student_management-with-django/" target="_blank" class="futuristic-link mt-auto text-sm">
          <i class="fa-brands fa-github mr-2"></i>View on GitHub
        </a>
      </div>
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 shadow-2xl flex flex-col items-start hover:-translate-y-2 duration-300">
        <h5 class="project-title text-lg md:text-xl font-semibold text-[#BC96E6] mb-2 font-orbitron" data-text="WhisperX Frontend">WhisperX Frontend</h5>
        <a href="https://github.com/Filip2k03/whisperx-frontend" target="_blank" class="futuristic-link mt-auto text-sm">
          <i class="fa-brands fa-github mr-2"></i>View on GitHub
        </a>
      </div>
      <div class="project-card glitch-on-hover glass rounded-2xl p-6 shadow-2xl flex flex-col items-start hover:-translate-y-2 duration-300">
        <h5 class="project-title text-lg md:text-xl font-semibold text-[#BC96E6] mb-2 font-orbitron" data-text="Tele AI Poster">Tele AI Poster</h5>
        <a href="https://github.com/Filip2k03/tele_ai_poster" target="_blank" class="futuristic-link mt-auto text-sm">
          <i class="fa-brands fa-github mr-2"></i>View on GitHub
        </a>
      </div>
    </div>
  </section>

  <!-- Current Focus Section -->
  <section id="current-focus" class="py-16 md:py-20 px-4 bg-[#1a0933]">
    <div class="section-scan-overlay"></div>
    <div class="container mx-auto">
      <div class="glass robotic-panel rounded-3xl p-6 md:p-10 shadow-xl max-w-3xl mx-auto">
        <h3 class="text-3xl md:text-4xl font-bold text-[#FFD166] mb-6 glow font-orbitron text-center">Current Focus</h3>
        <div id="current-focus-updates" class="space-y-6 text-[#BC96E6] font-montserrat text-sm md:text-lg">
          <p class="text-center">Loading current milestones...</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Experience Section -->
  <section id="experience" class="py-16 md:py-20 px-4">
    <div class="section-scan-overlay"></div>
    <div class="container mx-auto">
      <div class="glass rounded-3xl p-6 md:p-10 shadow-xl max-w-3xl mx-auto">
        <h3 class="text-3xl md:text-4xl font-bold text-[#FFD166] mb-8 glow font-orbitron text-center md:text-left">Work Experience</h3>
        <div class="space-y-8">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between border-l-2 border-accent pl-4 md:border-none md:pl-0">
            <div>
              <h4 class="text-xl md:text-2xl font-semibold text-[#BC96E6] font-orbitron">Myanmar Web Eng</h4>
              <p class="text-base md:text-lg text-[#FFD166] font-montserrat">OJT (Internship)</p>
            </div>
            <div class="text-left md:text-right mt-1 md:mt-0 text-[#BC96E6] font-montserrat text-sm md:text-base opacity-80">
              Oct 2024 – Jan 2025 <span class="text-[#FFD166] hidden md:inline">(3 months)</span>
            </div>
          </div>
          <div class="flex flex-col md:flex-row md:items-center md:justify-between border-l-2 border-accent pl-4 md:border-none md:pl-0">
            <div>
              <h4 class="text-xl md:text-2xl font-semibold text-[#BC96E6] font-orbitron">MIT</h4>
              <p class="text-base md:text-lg text-[#FFD166] font-montserrat">Web Developer</p>
            </div>
            <div class="text-left md:text-right mt-1 md:mt-0 text-[#BC96E6] font-montserrat text-sm md:text-base opacity-80">
              Mar 2025 – May 2025 <span class="text-[#FFD166] hidden md:inline">(2 months)</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Education Section -->
  <section id="education" class="py-16 md:py-20 px-4 bg-[#2E1F3C]">
    <div class="section-scan-overlay"></div>
    <div class="container mx-auto">
      <div class="glass rounded-3xl p-6 md:p-10 shadow-xl max-w-3xl mx-auto">
        <h3 class="text-3xl md:text-4xl font-bold text-[#FFD166] mb-8 glow font-orbitron text-center md:text-left">Education</h3>
        <div class="space-y-8">
          <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="http://www.mstinstitute.net/" target="_blank" class="flex-shrink-0">
              <img src="assets/schools/mst.png" onerror="this.src='https://placehold.co/80x80/311C3B/FFD166?text=MST'" alt="MST University logo"
                class="w-16 h-16 md:w-20 md:h-20 object-contain rounded-xl border-2 border-[#FFD166] bg-[#311C3B] p-2" />
            </a>
            <div>
              <h4 class="text-xl md:text-2xl font-semibold text-[#BC96E6] font-orbitron">MST University</h4>
              <p class="text-base md:text-lg text-[#FFD166] font-montserrat">NCC Level 4 & Level 5</p>
              <p class="text-[#BC96E6] font-montserrat text-sm">2024/2025 – <span class="text-[#FFD166]">Present</span></p>
            </div>
          </div>
          <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="https://cosmoseven.com/" target="_blank" class="flex-shrink-0">
              <img src="assets/schools/cosmo.png" onerror="this.src='https://placehold.co/80x80/311C3B/FFD166?text=Cosmo'" alt="Cosmo Seven School logo"
                class="w-16 h-16 md:w-20 md:h-20 object-contain rounded-xl border-2 border-[#FFD166] bg-[#311C3B] p-2" />
            </a>
            <div>
              <h4 class="text-xl md:text-2xl font-semibold text-[#BC96E6] font-orbitron">Cosmo Seven Web Eng.</h4>
              <p class="text-base md:text-lg text-[#FFD166] font-montserrat">Sep 2024 – Feb 2025</p>
              <ul class="list-disc ml-5 text-[#BC96E6] font-montserrat text-sm mt-2 space-y-1 opacity-90">
                <li><span class="text-[#FFD166]">Mod 1:</span> PHP, WordPress, HTML/CSS, JS</li>
                <li><span class="text-[#FFD166]">Mod 2:</span> Python, Django, Flask, REST API</li>
                <li><span class="text-[#FFD166]">Mod 3:</span> React, Vue, Vite, Expo, Mobile App</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Certificates Section -->
  <section id="certificates" class="py-16 md:py-20 px-4">
    <div class="section-scan-overlay"></div>
    <div class="container mx-auto">
      <div class="glass rounded-3xl p-6 md:p-10 shadow-xl max-w-4xl mx-auto">
        <h3 class="text-3xl md:text-4xl font-bold text-[#FFD166] mb-8 glow font-orbitron text-center">Certificates</h3>
        <div class="certificates-carousel-container relative">
            <div id="certificates-carousel" class="certificates-carousel flex space-x-4 md:space-x-6 pb-4">
                <div class="flex-shrink-0 w-48 md:w-56">
                    <img src="https://placehold.co/224x160/311C3B/FFD166?text=AWS" alt="Certificate 1"
                        class="rounded-xl shadow-lg border-2 border-[#FFD166] w-full h-32 md:h-40 object-cover bg-[#311C3B]" />
                    <p class="mt-2 text-center text-[#BC96E6] font-montserrat text-xs md:text-sm font-semibold">AWS Solutions Architect</p>
                </div>
                <div class="flex-shrink-0 w-48 md:w-56">
                    <img src="https://placehold.co/224x160/311C3B/FFD166?text=React" alt="Certificate 2"
                        class="rounded-xl shadow-lg border-2 border-[#FFD166] w-full h-32 md:h-40 object-cover bg-[#311C3B]" />
                    <p class="mt-2 text-center text-[#BC96E6] font-montserrat text-xs md:text-sm font-semibold">Advanced React Patterns</p>
                </div>
                <div class="flex-shrink-0 w-48 md:w-56">
                    <img src="https://placehold.co/224x160/311C3B/FFD166?text=Django" alt="Certificate 3"
                        class="rounded-xl shadow-lg border-2 border-[#FFD166] w-full h-32 md:h-40 object-cover bg-[#311C3B]" />
                    <p class="mt-2 text-center text-[#BC96E6] font-montserrat text-xs md:text-sm font-semibold">Django REST API Mastery</p>
                </div>
                <div class="flex-shrink-0 w-48 md:w-56">
                    <img src="https://placehold.co/224x160/311C3B/FFD166?text=Vue" alt="Certificate 4"
                        class="rounded-xl shadow-lg border-2 border-[#FFD166] w-full h-32 md:h-40 object-cover bg-[#311C3B]" />
                    <p class="mt-2 text-center text-[#BC96E6] font-montserrat text-xs md:text-sm font-semibold">Vue.js & Vite Scaling</p>
                </div>
                <div class="flex-shrink-0 w-48 md:w-56">
                    <img src="https://placehold.co/224x160/311C3B/FFD166?text=CyberSec" alt="Certificate 5"
                        class="rounded-xl shadow-lg border-2 border-[#FFD166] w-full h-32 md:h-40 object-cover bg-[#311C3B]" />
                    <p class="mt-2 text-center text-[#BC96E6] font-montserrat text-xs md:text-sm font-semibold">Web App Security</p>
                </div>
            </div>
            <button class="carousel-button left" id="cert-prev-btn" aria-label="Previous certificate"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="carousel-button right" id="cert-next-btn" aria-label="Next certificate"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section id="testimonials" class="py-16 md:py-20 px-4 bg-[#2E1F3C]">
    <div class="section-scan-overlay"></div>
    <div class="container mx-auto text-center">
      <div class="glass rounded-3xl p-6 md:p-10 shadow-xl max-w-4xl mx-auto">
        <h3 class="text-3xl md:text-4xl font-bold text-[#FFD166] mb-8 glow font-orbitron">Client Feedback</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
          <div class="glass rounded-2xl p-5 md:p-6 shadow-lg text-left">
            <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat italic">"Stephan delivered an outstanding corporate platform for Shine Dana. His attention to detail and ability to integrate complex features seamlessly was truly impressive."</p>
            <p class="text-[#FFD166] font-orbitron text-sm font-semibold">- Anya Petrova, Tech Director</p>
          </div>
          <div class="glass rounded-2xl p-5 md:p-6 shadow-lg text-left">
            <p class="text-[#BC96E6] text-sm md:text-base mb-4 font-montserrat italic">"Filip's expertise in both front-end and back-end development made him an invaluable asset to our project. He's a problem-solver with a keen eye for robust architecture."</p>
            <p class="text-[#FFD166] font-orbitron text-sm font-semibold">- Jax Miller, Lead Developer</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-16 md:py-20 px-4 bg-[#2E1F3C]">
    <div class="section-scan-overlay"></div>
    <div class="container mx-auto text-center">
      <div class="glass rounded-3xl p-6 md:p-10 shadow-xl max-w-lg mx-auto">
        <h3 class="text-3xl md:text-4xl font-bold text-[#FFD166] mb-4 glow font-orbitron">Let's Connect</h3>
        <p class="text-[#BC96E6] mb-8 text-sm md:text-lg font-montserrat">Send me a message and let’s build something great.</p>
        <form action="mailto:stephanfilip7@gmail.com" method="POST" enctype="text/plain" class="space-y-4">
          <input type="text" name="name" placeholder="Your Name" required
            class="w-full px-4 py-3 rounded-xl bg-[#210B2C] text-white border-2 border-[#FFD166] focus:outline-none focus:ring-2 focus:ring-[#FFD166] transition font-montserrat text-sm md:text-base">
          <input type="email" name="email" placeholder="Your Email" required
            class="w-full px-4 py-3 rounded-xl bg-[#210B2C] text-white border-2 border-[#FFD166] focus:outline-none focus:ring-2 focus:ring-[#FFD166] transition font-montserrat text-sm md:text-base">
          <textarea name="message" placeholder="Your Message" required rows="4"
            class="w-full px-4 py-3 rounded-xl bg-[#210B2C] text-white border-2 border-[#FFD166] focus:outline-none focus:ring-2 focus:ring-[#FFD166] transition font-montserrat text-sm md:text-base"></textarea>
          <button type="submit" class="futuristic-btn w-full py-3 text-lg md:text-xl">Send</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Chatbot Widget -->
  <div id="chatbot-widget" class="fixed right-4 bottom-4 md:right-6 md:bottom-6 z-[100]">
    <button id="chatbot-toggle" aria-label="Toggle chatbot"
      class="bg-[#FFD166] text-[#210B2C] rounded-full shadow-lg p-3 md:p-4 text-xl md:text-2xl hover:scale-110 transition focus:outline-none">
      <i class="fa-solid fa-robot"></i>
    </button>
    <div id="chatbot-window" class="hidden glass rounded-2xl shadow-2xl p-4 w-[calc(100vw-32px)] max-w-sm right-0 absolute bottom-14 md:bottom-16"
      style="margin-bottom:12px;">
      <div class="font-led text-base md:text-lg mb-2">🤖 Assistant API</div>
      <div id="chatbot-messages"
        class="h-40 overflow-y-auto text-[#BC96E6] text-sm md:text-base font-montserrat mb-3 bg-[#210B2C]/60 rounded-lg p-2"></div>
      <form id="chatbot-form" autocomplete="off" class="flex flex-col gap-2">
        <textarea id="chatbot-input" rows="1" placeholder="Type your message..." required
          class="rounded-lg px-3 py-2 bg-[#311C3B] border-2 border-[#FFD166] text-white focus:outline-none resize-none text-sm"></textarea>
        <button type="submit" class="futuristic-btn py-2 text-sm">Send</button>
      </form>
      <button id="clear-chatbot-btn" class="futuristic-btn w-full py-2 text-sm mt-2">Clear Chat</button>
    </div>
  </div>

  <!-- Scroll to Top Button -->
  <button id="scrollTopBtn" aria-label="Scroll to top"
    class="hidden fixed bottom-20 right-4 md:bottom-24 md:right-6 z-50 bg-[#FFD166] text-[#210B2C] rounded-full shadow-lg p-3 text-xl hover:scale-110 transition focus:outline-none">
    <i class="fa-solid fa-arrow-up"></i>
  </button>

  <!-- Satellite Scanner / Visitor Tracker -->
  <div id="visitor-tracker" class="block" id="hud-3">
      <p class="tracking-widest">🛰 NET_LINK</p>
      <div class="scan-line-pulse"></div>
      <p class="mt-2 text-left opacity-80">📍 LOC: <span id="tracker-location" class="text-white font-bold"></span></p>
      <p class="text-left opacity-80">🧾 SES: <span id="tracker-user-id" class="text-white font-bold"></span></p>
      <p class="text-left opacity-80">📡 HLTH: <span id="tracker-signal" class="text-white font-bold"></span>%</p>
  </div>

  <!-- Feature 5: Cyberpunk Flash/Easter Egg Overlay -->
  <div id="cyber-flash-overlay" class="fixed inset-0 bg-red-600 z-[99999] opacity-0 pointer-events-none mix-blend-color-burn transition-opacity duration-100 hidden flex items-center justify-center">
      <h1 class="text-white font-led text-6xl md:text-9xl tracking-widest font-bold">OVERRIDE</h1>
  </div>

  <!-- Footer -->
  <footer
    class="relative flex flex-col md:flex-row items-center justify-between py-6 px-4 md:px-6 bg-[#210B2C] text-[#BC96E6] text-sm md:text-lg glass font-montserrat mt-10">
    <div id="footer-ufo-shooter" class="mb-4 md:mb-0 md:mr-4">
      <svg id="footer-ufo-svg" width="70" height="60" viewBox="0 0 90 80" fill="none" style="cursor:pointer;" class="md:w-[90px] md:h-[80px]">
        <ellipse cx="45" cy="50" rx="30" ry="12" fill="#1a0933" stroke="var(--secondary)" stroke-width="4" />
        <ellipse cx="45" cy="50" rx="24" ry="8" fill="var(--accent)33" />
        <ellipse cx="45" cy="42" rx="12" ry="6" fill="var(--accent)" stroke="#FFD166" stroke-width="2" />
        <rect id="ufo-beam" x="35" y="62" width="20" height="30" rx="10" fill="var(--accent)" opacity="0" />
      </svg>
    </div>
    <div id="shooting-star"
      style="position:absolute;top:10px;left:-60px;width:60px;height:8px;z-index:10;pointer-events:none;">
      <svg width="60" height="8">
        <ellipse cx="30" cy="4" rx="20" ry="3" fill="#ffe600" opacity="0.7" />
        <ellipse cx="50" cy="4" rx="8" ry="2" fill="var(--accent)" opacity="0.7" />
      </svg>
    </div>
    <span class="block text-center" id="footer-copyright-text">&copy; 2026 Stephan Filip — Full Stack Developer | <a
        href="https://payvia.shop" class="futuristic-link">PayVia</a></span>
  </footer>
  <div id="ufo-shot-msg"
    style="display:none;position:fixed;left:10px;bottom:110px;z-index:101;font-family:'Orbitron','Share Tech Mono',monospace;font-size:1.5rem;font-weight:bold;color:var(--accent);text-shadow:0 0 12px var(--secondary),0 0 24px var(--accent),0 0 8px var(--danger);pointer-events:none;white-space:nowrap; md:font-size:2rem; md:left:110px;">
    <span id="ufo-shot-text"></span>
  </div>

  <!-- Audio Elements (Hidden) -->
  <audio id="audio-click" src="https://www.soundjay.com/buttons/button-2.mp3" preload="auto"></audio>
  <audio id="audio-chatbot" src="https://www.soundjay.com/communication/beep-07.mp3" preload="auto"></audio>
  <audio id="audio-ufo" src="https://www.soundjay.com/mechanical/mechanical_keyboard_click_01.mp3" preload="auto"></audio>

  <!-- Live Demo Modal Structure -->
  <div id="live-demo-modal-overlay">
      <button id="live-demo-close-btn" aria-label="Close live demo">X</button>
      <div id="live-demo-modal-content">
          <iframe id="live-demo-iframe" src="" frameborder="0"></iframe>
      </div>
  </div>


  <script>
    const TERMINAL_TEXT_ID = 'terminal-text';
    const TERMINAL_CURSOR_ID = 'terminal-cursor';
    const TERMINAL_DISPLAY_ID = 'terminal-display';
    const THEME_TOGGLE_BTN_ID = 'theme-toggle-btn';
    const SOUND_TOGGLE_BTN_ID = 'sound-toggle-btn';
    const CHATBOT_MESSAGES_ID = 'chatbot-messages';
    const CHATBOT_FORM_ID = 'chatbot-form';
    const CHATBOT_INPUT_ID = 'chatbot-input';
    const CLEAR_CHATBOT_BTN_ID = 'clear-chatbot-btn';
    const SKILL_GRAPH_CONTAINER_ID = 'skill-graph-container'; 
    const PROJECTS_SECTION_ID = 'projects';
    const HERO_BTN_PROJECTS_ID = 'hero-btn-projects';
    const HERO_BTN_RESUME_ID = 'hero-btn-resume';
    const CERTIFICATES_CAROUSEL_ID = 'certificates-carousel';
    const CERT_PREV_BTN_ID = 'cert-prev-btn';
    const CERT_NEXT_BTN_ID = 'cert-next-btn';
    const CURRENT_FOCUS_UPDATES_ID = 'current-focus-updates';
    const FOOTER_COPYRIGHT_TEXT_ID = 'footer-copyright-text';
    const HERO_TERMINAL_INPUT_ID = 'hero-terminal-input'; 
    const HOLOGRAM_PROFILE_CUBE_ID = 'hologram-profile-cube'; 
    const ABOUT_SECTION_ID = 'about'; 
    const HUD_TIME_ID = 'hud-time';
    const HUD_WEATHER_ID = 'hud-weather';
    const HUD_BATTERY_ID = 'hud-battery';
    const HUD_STATUS_ID = 'hud-status';
    const HUD_USER_ID_ID = 'hud-user-id';
    const TRACKER_LOCATION_ID = 'tracker-location';
    const TRACKER_USER_ID_ID = 'tracker-user-id';
    const TRACKER_SIGNAL_ID = 'tracker-signal';
    const CUSTOM_CURSOR_SELECTOR = '.custom-cursor'; 
    const SPOTLIGHT_EFFECT_SELECTOR = '.spotlight-effect'; 
    const SECTION_TOOLTIP_ID = 'section-tooltip'; 
    const MINI_NAV_ID = 'mini-nav'; 
    const LIVE_DEMO_BUTTON_SELECTOR = '.project-card .futuristic-btn[data-project-url]'; 
    const LIVE_DEMO_MODAL_OVERLAY_ID = 'live-demo-modal-overlay';
    const LIVE_DEMO_IFRAME_ID = 'live-demo-iframe';
    const LIVE_DEMO_CLOSE_BTN_ID = 'live-demo-close-btn';

    const terminalLines = [
      "Initializing core architecture...",
      "Loading framework assets...",
      "System ready for deployment.",
      "Access granted."
    ];
    let termIdx = 0, termCharIdx = 0;
    let terminalFinishedTyping = false; 

    const roles = [
      "Full Stack Developer",
      "React & Django Specialist",
      "E-commerce Architect",
      "UI/UX Enthusiast"
    ];
    let currentRoleIndex = 0;

    const aiAnswers = {
      "hello": "Hello there! How can I assist you with Stephan's portfolio?",
      "hi": "Greetings! What brings you to this platform today?",
      "how are you": "Operating at peak efficiency. How may I be of service to you?",
      "skills": "Stephan possesses a wide array of skills, including: Full Stack Development (React, Django, Laravel), UI/UX design, Database Management (MySQL, MongoDB), and Cloud Services. Explore the interactive graph below!",
      "projects": "You can explore recent deployments in the 'Projects' section, showcasing enterprise and e-commerce applications.",
      "contact": "You can reach Stephan via phone (+959954480806), Telegram (@stephanfilip), Facebook, WhatsApp, GitHub, LinkedIn, or Upwork.",
      "bye": "Farewell! May your code compile on the first try.",
      "thank you": "You're most welcome! Is there anything else I can assist you with?",
      "who are you": "I am Stephan's Assistant API, integrated to help you navigate and find information seamlessly.",
      "what is your name": "I am the Portfolio Assistant API.",
      "name": "I am the Portfolio Assistant API.",
      "help": "Available commands: 'skills', 'projects', 'contact', 'about', 'clear', 'theme', 'sound', 'access log', 'download credentials'. You can also ask general questions!",
      "about": "Stephan is a dedicated Full Stack Developer and founder of PayVia, passionate about robust architecture and scalable web solutions."
    };

    const rareMsgs = [
      "SYSTEM DEPLOYMENT SUCCESS",
      "HIRE ME FOR YOUR NEXT PROJECT",
      "NO GLITCHES FOUND",
      "OPTIMIZED FOR PERFORMANCE",
      "FULL STACK ENGINEERING",
      "REACT + DJANGO = ⚡",
      "SCALABLE ARCHITECTURE",
      "CLEAN CODE ARCHITECT",
      "HELLO, WORLD!",
      "STEPHAN IS ONLINE"
    ];

    const currentFocusUpdates = [
      { date: "Current", title: "Optimizing Enterprise Architecture for Shine Dana", description: "Currently focusing on scaling corporate portal solutions, improving load times, and establishing secure, efficient data pipelines for large-scale enterprise needs." },
      { date: "Recent", title: "Building Digital Marketplace MM", description: "Developing a robust multi-vendor ecosystem. Implementing advanced state management in React alongside highly normalized relational databases to ensure seamless transactions." },
      { date: "Ongoing", title: "Mastering Cloud Infrastructure", description: "Deep diving into AWS and scalable deployment pipelines. Creating CI/CD automated processes to enhance project delivery speed without compromising security." },
      { date: "Ongoing", title: "AI Model Integrations", description: "Exploring real-world applications of large language models (LLMs) via APIs, integrating smart features like AI chatbots and predictive text into production e-commerce applications." }
    ];

    const skillGraphData = {
        nodes: [
            { id: "HTML/CSS", group: "frontend", proficiency: 90 },
            { id: "JS/React", group: "frontend", proficiency: 85 },
            { id: "Tailwind", group: "frontend", proficiency: 95 },
            { id: "Laravel", group: "backend", proficiency: 80 },
            { id: "Django", group: "backend", proficiency: 85 },
            { id: "MySQL", group: "database", proficiency: 90 },
            { id: "REST API", group: "cloud", proficiency: 95 },
            { id: "AWS", group: "cloud", proficiency: 75 },
            { id: "C#", group: "backend", proficiency: 60 },
            { id: "Expo", group: "mobile", proficiency: 70 },
            { id: "Android", group: "mobile", proficiency: 65 },
            { id: "Kotlin", group: "mobile", proficiency: 60 },
            { id: "XML", group: "mobile", proficiency: 70 },
            { id: "Vue", group: "frontend", proficiency: 75 },
            { id: "Next.js", group: "frontend", proficiency: 80 }
        ]
    };

    const colorScale = d3.scaleOrdinal(d3.schemeCategory10)
        .domain(["frontend", "backend", "database", "cloud", "mobile"]);

    // --- Sound Manager ---
    const SoundManager = {
        isMuted: localStorage.getItem('isMuted') === 'true',
        hasInteracted: false, 
        sounds: {
            click: null, 
            chatbot: null, 
            ufo: null, 
            terminalType: null, 
            terminalError: null 
        },
        init() {
            this.sounds.click = document.getElementById('audio-click');
            this.sounds.chatbot = document.getElementById('audio-chatbot');
            this.sounds.ufo = document.getElementById('audio-ufo');
            this.sounds.terminalType = new Audio('https://www.soundjay.com/typewriter/typewriter-1.mp3');
            this.sounds.terminalError = new Audio('https://www.soundjay.com/misc/fail-buzzer-02.mp3');

            if (this.sounds.terminalType) this.sounds.terminalType.volume = 0.3;
            if (this.sounds.terminalError) this.sounds.terminalError.volume = 0.5;

            this.updateToggleButton();
            document.addEventListener('click', this.firstInteractionHandler.bind(this), { once: true });
            document.addEventListener('keydown', this.firstInteractionHandler.bind(this), { once: true });
            document.addEventListener('touchstart', this.firstInteractionHandler.bind(this), { once: true });
        },
        firstInteractionHandler() {
            this.hasInteracted = true;
            Object.values(this.sounds).forEach(audio => {
                if (audio) {
                    audio.volume = 0; 
                    audio.play().catch(e => console.warn("Silent play failed:", e));
                    audio.volume = 1; 
                }
            });
        },
        play(soundName) {
            if (this.hasInteracted && !this.isMuted && this.sounds[soundName]) {
                this.sounds[soundName].currentTime = 0; 
                this.sounds[soundName].play().catch(e => console.error("Sound play failed:", e));
            }
        },
        toggleMute() {
            this.isMuted = !this.isMuted;
            localStorage.setItem('isMuted', this.isMuted);
            this.updateToggleButton();
            if (!this.isMuted) {
                this.play('click'); 
            }
        },
        updateToggleButton() {
            const toggleButton = document.getElementById(SOUND_TOGGLE_BTN_ID);
            if (!toggleButton) return;
            const icon = toggleButton.querySelector('i');
            if (!icon) return;
            if (this.isMuted) {
                icon.classList.remove('fa-volume-high');
                icon.classList.add('fa-volume-xmark');
            } else {
                icon.classList.remove('fa-volume-xmark');
                icon.classList.add('fa-volume-high');
            }
        }
    };

    // --- Feature 1: Matrix Rain Background Functionality ---
    let matrixInterval;
    function setupMatrixRain() {
      const canvas = document.getElementById('matrix-canvas');
      const ctx = canvas.getContext('2d');
      
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%^&*()_+=";
      const fontSize = window.innerWidth < 480 ? 10 : 16;
      const columns = canvas.width / fontSize;
      const drops = [];
      
      for(let x = 0; x < columns; x++) drops[x] = 1; 
      
      function draw() {
        ctx.fillStyle = "rgba(15, 6, 23, 0.05)";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        ctx.fillStyle = "#00ffe7"; 
        ctx.font = fontSize + "px 'Share Tech Mono'";
        
        for(let i = 0; i < drops.length; i++) {
          const text = chars.charAt(Math.floor(Math.random() * chars.length));
          ctx.fillText(text, i * fontSize, drops[i] * fontSize);
          
          if(drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
            drops[i] = 0;
          }
          drops[i]++;
        }
      }
      
      matrixInterval = setInterval(draw, 33);

      window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
      });
    }

    // --- Feature 2: Fetch Live GitHub Data ---
    async function fetchGitHubStats() {
        try {
            const response = await fetch('https://api.github.com/users/Filip2k03');
            if (response.ok) {
                const data = await response.json();
                document.getElementById('gh-avatar').src = data.avatar_url;
                document.getElementById('gh-bio').textContent = data.bio || "Full Stack Web Developer";
                
                gsap.to(document.getElementById('gh-repos'), { innerHTML: data.public_repos, duration: 2, snap: { innerHTML: 1 } });
                gsap.to(document.getElementById('gh-followers'), { innerHTML: data.followers, duration: 2, snap: { innerHTML: 1 } });
                gsap.to(document.getElementById('gh-following'), { innerHTML: data.following, duration: 2, snap: { innerHTML: 1 } });
            } else {
                document.getElementById('gh-bio').textContent = "Failed to load GitHub stats (Rate Limited).";
            }
        } catch(e) {
            console.error('Error fetching GH stats', e);
        }
    }

    // --- Feature 3: Draggable HUD Elements (Touch support included) ---
    function makeDraggable(elementId) {
        const elmnt = document.getElementById(elementId);
        if(!elmnt) return;
        
        let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        
        elmnt.onmousedown = dragMouseDown;
        elmnt.ontouchstart = dragTouchStart;

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            document.onmousemove = elementDrag;
        }
        
        function dragTouchStart(e) {
            e = e || window.event;
            const touch = e.targetTouches[0];
            pos3 = touch.clientX;
            pos4 = touch.clientY;
            document.ontouchend = closeDragElement;
            document.ontouchmove = elementDragTouch;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            updatePos();
        }
        
        function elementDragTouch(e) {
            e = e || window.event;
            const touch = e.targetTouches[0];
            pos1 = pos3 - touch.clientX;
            pos2 = pos4 - touch.clientY;
            pos3 = touch.clientX;
            pos4 = touch.clientY;
            updatePos();
        }
        
        function updatePos() {
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            elmnt.style.right = 'auto'; 
            elmnt.style.bottom = 'auto';
        }

        function closeDragElement() {
            document.onmouseup = null;
            document.onmousemove = null;
            document.ontouchend = null;
            document.ontouchmove = null;
        }
    }

    // --- Feature 4: Scroll Progress Bar ---
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.getElementById("scroll-progress").style.width = scrolled + "%";
    });

    // --- Feature 5: Keyboard Easter Egg ("CYBER") ---
    let keySequence = "";
    document.addEventListener('keydown', (e) => {
        keySequence += e.key.toLowerCase();
        if (keySequence.length > 5) {
            keySequence = keySequence.slice(-5);
        }
        if (keySequence === "cyber") {
            const overlay = document.getElementById('cyber-flash-overlay');
            overlay.classList.remove('hidden');
            SoundManager.play('terminalError');
            
            gsap.to(overlay, {opacity: 0.8, duration: 0.1, yoyo: true, repeat: 5, onComplete: () => {
                overlay.classList.add('hidden');
                keySequence = "";
            }});
        }
    });

    function botSay(msg) {
      document.getElementById(CHATBOT_MESSAGES_ID).innerHTML += `<div class="mb-1"><b>Bot:</b> ${msg}</div>`;
      document.getElementById(CHATBOT_MESSAGES_ID).scrollTop = document.getElementById(CHATBOT_MESSAGES_ID).scrollHeight;
      SoundManager.play('chatbot'); 
    }

    function userSay(msg) {
      document.getElementById(CHATBOT_MESSAGES_ID).innerHTML += `<div class="mb-1 text-right"><b>You:</b> ${msg}</div>`;
      document.getElementById(CHATBOT_MESSAGES_ID).scrollTop = document.getElementById(CHATBOT_MESSAGES_ID).scrollHeight;
    }

    // --- 7. Terminal Intro with System Boot Progress ---
    function typeTerminal() {
      gsap.to("#boot-progress-container", {opacity: 1, duration: 0.5});
      gsap.to("#boot-progress-bar", {width: "100%", duration: 2.5, ease: "power2.inOut"});

      if (termIdx < terminalLines.length) {
        if (termCharIdx < terminalLines[termIdx].length) {
          document.getElementById(TERMINAL_TEXT_ID).textContent += terminalLines[termIdx][termCharIdx++];
          setTimeout(typeTerminal, 38);
        } else {
          document.getElementById(TERMINAL_TEXT_ID).textContent += "\n";
          termCharIdx = 0;
          termIdx++;
          setTimeout(typeTerminal, 400);
        }
      } else {
        terminalFinishedTyping = true; 
        setTimeout(() => {
          document.getElementById('terminal-intro').style.transition = "opacity 0.6s";
          document.getElementById('terminal-intro').style.opacity = 0;
          setTimeout(() => document.getElementById('terminal-intro').remove(), 600);
        }, 600);
      }
    }

    function randomTerminalFact() {
      if (terminalFinishedTyping) {
        const factMsgs = [
          "SYSTEM ONLINE. ALL SENSORS GREEN.",
          "DATA STREAM OPTIMIZED.",
          "ENVIRONMENT INITIALIZED.",
          "YOUR PRESENCE IS ACKNOWLEDGED.",
          "ACCESS GRANTED."
        ];
        const randomMsg = factMsgs[Math.floor(Math.random() * factMsgs.length)];
        const terminalTextElement = document.getElementById(TERMINAL_TEXT_ID);
        if(terminalTextElement) {
            terminalTextElement.textContent = ""; 
            let charIndex = 0;
            function typeRandomMessage() {
            if (charIndex < randomMsg.length) {
                terminalTextElement.textContent += randomMsg[charIndex++];
                setTimeout(typeRandomMessage, 30); 
            }
            }
            typeRandomMessage();
        }
      }
    }

    const robot = document.getElementById('robot-container');
    let ticking = false;
    function animateRobot() {
      const amplitude = window.innerWidth < 480 ? 20 : 40;
      const period = 600;
      const y = amplitude * Math.sin(window.scrollY / period * 2 * Math.PI);
      gsap.to(robot, { y, duration: 0.6, ease: "power2.out" });
      ticking = false;
    }

    function showOptions() {
      botSay(
        `How would you like to contact me?<br>
        <button class="futuristic-btn my-1 px-3 py-1 text-xs" onclick="showPhone(); SoundManager.play('click');">Phone</button>
        <button class="futuristic-btn my-1 px-3 py-1 text-xs" onclick="showtg(); SoundManager.play('click');">Telegram</button>
        <button class="futuristic-btn my-1 px-3 py-1 text-xs" onclick="showfb(); SoundManager.play('click');">Facebook</button>
        <button class="futuristic-btn my-1 px-3 py-1 text-xs" onclick="showwa(); SoundManager.play('click');">WhatsApp</button>
        <button class="futuristic-btn my-1 px-3 py-1 text-xs" onclick="showgh(); SoundManager.play('click');">GitHub</button>
        <button class="futuristic-btn my-1 px-3 py-1 text-xs" onclick="showli(); SoundManager.play('click');">LinkedIn</button>
        <button class="futuristic-btn my-1 px-3 py-1 text-xs" onclick="showup(); SoundManager.play('click');">Upwork</button>
        `
      );
    }

    function clearChatbotHistory() {
      document.getElementById(CHATBOT_MESSAGES_ID).innerHTML = '';
      botSay("Chat history cleared. How can I assist you now?");
      showOptions();
      SoundManager.play('click'); 
    }

    const heroTerminalInput = document.getElementById(HERO_TERMINAL_INPUT_ID);
    let currentInputText = "";
    let inputTypingTimeout;
    let isTypingRole = true;

    function typeRoleIntoInput() {
        if (!heroTerminalInput || !isTypingRole) return; 

        if (currentRoleIndex >= roles.length) {
            currentRoleIndex = 0; 
        }
        const targetText = roles[currentRoleIndex];
        let charIndex = 0;

        function typeChar() {
            if (!isTypingRole || !heroTerminalInput) return; 
            if (charIndex < targetText.length) {
                currentInputText = targetText.substring(0, charIndex + 1);
                heroTerminalInput.value = currentInputText;
                charIndex++;
                inputTypingTimeout = setTimeout(typeChar, 70); 
            } else {
                inputTypingTimeout = setTimeout(eraseText, 1500); 
            }
        }

        function eraseText() {
            if (!isTypingRole || !heroTerminalInput) return; 
            if (charIndex > 0) {
                currentInputText = targetText.substring(0, charIndex - 1);
                heroTerminalInput.value = currentInputText;
                charIndex--;
                inputTypingTimeout = setTimeout(eraseText, 30); 
            } else {
                currentRoleIndex++; 
                inputTypingTimeout = setTimeout(typeChar, 500); 
            }
        }

        typeChar();
    }

    function simulateLogAccess() {
        isTypingRole = false; 
        clearTimeout(inputTypingTimeout); 
        const logLines = [
            "ACCESSING_LOGS...",
            "INITIATING_DECRYPTION_PROTOCOL...",
            "AUTHENTICATION_SUCCESSFUL.",
            "LOG_ENTRY_001: SYSTEM_BOOT",
            "LOG_ENTRY_002: NET_INTEGRITY_OK",
            "LOG_ENTRY_003: FILIP_LOGIN_SUCCESS",
            "LOG_ACCESS_COMPLETE."
        ];
        let currentLogLine = 0;
        let charIndex = 0;
        if (heroTerminalInput) heroTerminalInput.value = ""; 
        SoundManager.play('ufo'); 

        function typeLogLine() {
            if (!heroTerminalInput) return; 
            if (currentLogLine < logLines.length) {
                if (charIndex < logLines[currentLogLine].length) {
                    heroTerminalInput.value += logLines[currentLogLine][charIndex++];
                    setTimeout(typeLogLine, 30); 
                } else {
                    heroTerminalInput.value += "\n";
                    charIndex = 0;
                    currentLogLine++;
                    setTimeout(typeLogLine, 250); 
                }
            } else {
                setTimeout(() => {
                    if (heroTerminalInput) heroTerminalInput.value = ""; 
                    isTypingRole = true; 
                    typeRoleIntoInput(); 
                }, 1500); 
            }
        }
        typeLogLine();
    }

    function handleHeroCommand(command) {
        if (!heroTerminalInput) return;

        command = command.toLowerCase().trim();
        let response = "";
        isTypingRole = false; 
        clearTimeout(inputTypingTimeout); 

        switch(command) {
            case 'help':
                response = "Commands: 'about', 'skills', 'projects', 'contact', 'matrix', 'date', 'clear'.";
                break;
            case 'about':
                response = "Stephan is a Full Stack Developer passionate about robust backend solutions.";
                gsap.to(window, { duration: 0.8, scrollTo: { y: `#${ABOUT_SECTION_ID}` }, ease: "power2.inOut" });
                break;
            case 'skills':
                response = "Check the 'Skills' section for an interactive graph of my tech stack!";
                gsap.to(window, { duration: 0.8, scrollTo: { y: "#skills" }, ease: "power2.inOut" });
                break;
            case 'projects':
                response = "Explore my work in the 'Projects' section.";
                gsap.to(window, { duration: 0.8, scrollTo: { y: "#projects" }, ease: "power2.inOut" });
                break;
            case 'contact':
                response = "Find my contact details in the 'Contact' section or use the chatbot!";
                gsap.to(window, { duration: 0.8, scrollTo: { y: "#contact" }, ease: "power2.inOut" });
                break;
            case 'hire':
                response = "Excellent choice! Let's connect. See the 'Contact' section.";
                gsap.to(window, { duration: 0.8, scrollTo: { y: "#contact" }, ease: "power2.inOut" });
                break;
            case 'matrix':
                const mCanvas = document.getElementById('matrix-canvas');
                if(mCanvas.style.display === 'none'){
                    mCanvas.style.display = 'block';
                    response = "Matrix rain ACTIVATED.";
                } else {
                    mCanvas.style.display = 'none';
                    response = "Matrix rain DEACTIVATED.";
                }
                break;
            case 'date':
                response = "Sys Date: " + new Date().toDateString();
                break;
            case 'clear':
                heroTerminalInput.value = "";
                isTypingRole = true;
                typeRoleIntoInput();
                return;
            case 'sudo':
                response = "ERROR: ACCESS DENIED. You do not have root privileges.";
                SoundManager.play('terminalError');
                break;
            case 'access log':
                simulateLogAccess(); 
                return; 
            default:
                response = `Command '${command}' not recognized. Type 'help' for options.`;
                SoundManager.play('terminalError'); 
        }

        heroTerminalInput.value = response;
        setTimeout(() => {
            if (heroTerminalInput) heroTerminalInput.value = ""; 
            isTypingRole = true; 
            typeRoleIntoInput(); 
        }, 2500); 
        SoundManager.play('chatbot'); 
    }

    const ufoShotMsg = document.getElementById('ufo-shot-msg');
    const ufoShotText = document.getElementById('ufo-shot-text');
    const ufoBeamSVG = document.getElementById('ufo-beam');

    function autoShootUFO() {
      if (!ufoShotMsg || !ufoShotText || !ufoBeamSVG) return; 

      const msg = rareMsgs[Math.floor(Math.random() * rareMsgs.length)];
      ufoShotText.textContent = msg;
      ufoShotMsg.style.display = 'block';
      
      // Ensure UFO text isn't offscreen on mobile
      const startLeft = window.innerWidth < 480 ? 20 : 110;
      ufoShotMsg.style.left = startLeft + 'px';
      ufoShotMsg.style.opacity = '1';
      
      SoundManager.play('ufo'); 
      let pos = startLeft, opacity = 1;

      gsap.to(ufoBeamSVG, { opacity: 0.7, duration: 0.4, yoyo: true, repeat: 1, onComplete: () => {
        gsap.to(ufoBeamSVG, { opacity: 0, duration: 0.4 });
      }});

      function animateShot() {
        pos += window.innerWidth < 480 ? 12 : 24; // slower on mobile
        opacity -= window.innerWidth < 480 ? 0.05 : 0.03;
        ufoShotMsg.style.left = pos + 'px';
        ufoShotMsg.style.opacity = opacity;
        if (pos < window.innerWidth - 100 && opacity > 0) {
          requestAnimationFrame(animateShot);
        } else {
          ufoShotMsg.style.display = 'none';
        }
      }
      animateShot();
    }

    const scrollTopBtn = document.getElementById('scrollTopBtn');
    const hero = document.querySelector('section.relative.text-center');
    const heroBg1 = hero.querySelector('.bg-\\[var\\(--accent\\)\\]');
    const heroBg2 = hero.querySelector('.bg-\\[\\#FFD166\\]');

    function animateShootingStar() {
      const star = document.getElementById('shooting-star');
      if (!star) return; 

      gsap.set(star, { left: '-60px', opacity: 1 });
      gsap.to(star, { left: '100vw', duration: window.innerWidth < 480 ? 2 : 3.5, ease: "power1.in", opacity: 0, onComplete: () => {
        gsap.set(star, { left: '-60px', opacity: 0 });
      }});
    }

    function toggleTheme() {
        document.body.classList.toggle('light-theme');
        saveThemePreference(document.body.classList.contains('light-theme') ? 'light' : 'dark');
        const icon = document.getElementById(THEME_TOGGLE_BTN_ID);
        if (icon) { 
            const iElement = icon.querySelector('i');
            if (iElement) {
                if (document.body.classList.contains('light-theme')) {
                    iElement.classList.remove('fa-moon');
                    iElement.classList.add('fa-sun');
                } else {
                    iElement.classList.remove('fa-sun');
                    iElement.classList.add('fa-moon');
                }
            }
        }
        SoundManager.play('click'); 
    }

    function saveThemePreference(theme) {
        localStorage.setItem('theme', theme);
    }

    function loadThemePreference() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-theme');
        }
    }

    function createDnaSkillVisualizer(data) {
        const container = document.getElementById(SKILL_GRAPH_CONTAINER_ID);
        if (!container) return;

        const width = 800; 
        const height = 500; 
        const svg = d3.select("#skill-dna-svg")
            .attr("viewBox", `0 0 ${width} ${height}`)
            .attr("preserveAspectRatio", "xMidYMid meet");

        svg.selectAll("*").remove();

        const helixRadius = 120; // Slightly wider
        const helixPitch = 0.05; 
        const helixLength = height - 100; 
        const startY = 50;
        const endY = height - 50;

        const lineGenerator = d3.line()
            .x(d => d.x)
            .y(d => d.y)
            .curve(d3.curveCardinal); 

        const helixPoints1 = [];
        const helixPoints2 = [];
        for (let y = startY; y <= endY; y += 1) {
            const angle = y * helixPitch;
            helixPoints1.push({ x: width / 2 + helixRadius * Math.cos(angle), y: y });
            helixPoints2.push({ x: width / 2 + helixRadius * Math.cos(angle + Math.PI), y: y });
        }

        const helix1 = svg.append("path").attr("class", "dna-helix").attr("d", lineGenerator(helixPoints1));
        const helix2 = svg.append("path").attr("class", "dna-helix").attr("d", lineGenerator(helixPoints2));

        const pathLength1 = helix1.node().getTotalLength();
        const pathLength2 = helix2.node().getTotalLength();

        helix1.attr("stroke-dasharray", pathLength1 + " " + pathLength1).attr("stroke-dashoffset", pathLength1);
        helix2.attr("stroke-dasharray", pathLength2 + " " + pathLength2).attr("stroke-dashoffset", pathLength2);

        gsap.to(helix1.node(), { strokeDashoffset: 0, duration: 2, ease: "power2.out" });
        gsap.to(helix2.node(), { strokeDashoffset: 0, duration: 2, ease: "power2.out", delay: 0.5 });

        const nodesData = data.nodes.map((d, i) => {
            const yPos = startY + (i / (data.nodes.length - 1)) * helixLength;
            const angle = yPos * helixPitch;
            return {
                ...d,
                x: width / 2 + helixRadius * Math.cos(angle + (i % 2 === 0 ? 0 : Math.PI)),
                y: yPos
            };
        });

        const nodeGroups = svg.selectAll(".dna-node-group")
            .data(nodesData)
            .enter().append("g")
            .attr("class", "dna-node-group")
            .attr("transform", d => `translate(${d.x},${d.y})`);

        nodeGroups.append("circle")
            .attr("class", "dna-node-circle")
            .attr("r", d => 5 + d.proficiency / 15) 
            .attr("fill", d => colorScale(d.group));

        nodeGroups.append("text")
            .attr("class", "dna-node-text")
            .attr("dy", "0.35em")
            .attr("x", d => d.x > width / 2 ? 15 : -15) 
            .attr("text-anchor", d => d.x > width / 2 ? "start" : "end")
            .style("font-size", "14px") // bigger text for mobile readability
            .text(d => d.id);

        gsap.to(nodeGroups.nodes(), {
            opacity: 1, scale: 1, duration: 0.5, stagger: 0.1, ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: `#${SKILL_GRAPH_CONTAINER_ID}`, start: "top center", toggleActions: "play reverse play reverse", once: true 
            }
        });

        nodeGroups.on("mouseover", function(event, d) { d3.select(this).classed("highlight", true); })
        .on("mouseout", function(event, d) { d3.select(this).classed("highlight", false); });

        window.filterDnaSkills = function(category) {
            const allNodeGroups = svg.selectAll(".dna-node-group");
            allNodeGroups.each(function(d) {
                const nodeGroup = d3.select(this);
                if (category === 'all' || d.group === category) {
                    nodeGroup.transition().duration(300).style("opacity", 1).attr("display", null); 
                } else {
                    nodeGroup.transition().duration(300).style("opacity", 0.2).attr("display", "none"); 
                }
            });
        };
    }

    function filterSkills(category) {
        window.filterDnaSkills(category); 
    }

    function scrollCertificates(direction) {
      const carousel = document.getElementById(CERTIFICATES_CAROUSEL_ID);
      if (!carousel) return;
      const scrollAmount = window.innerWidth < 480 ? 200 : 280; 
      carousel.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
      SoundManager.play('click'); 
    }

    function fetchLatestUpdates() {
      const updatesContainer = document.getElementById(CURRENT_FOCUS_UPDATES_ID);
      if (!updatesContainer) return;
      let html = '';
      currentFocusUpdates.forEach(update => {
        html += `
          <div class="current-focus-item p-4 rounded-lg border-l-4 border-[var(--secondary)] shadow-md">
            <p class="text-xs md:text-sm text-[#FFD166] font-orbitron">${update.date}</p>
            <h4 class="text-lg md:text-xl font-semibold text-[var(--accent)] mb-1">${update.title}</h4>
            <p class="text-sm md:text-base">${update.description}</p>
          </div>
        `;
      });
      updatesContainer.innerHTML = html;
    }

    function animateHeroButtons() {
      const btnProjects = document.getElementById(HERO_BTN_PROJECTS_ID);
      const btnResume = document.getElementById(HERO_BTN_RESUME_ID);
      if (!btnProjects || !btnResume) return; 

      const createHoverAnimation = (element) => {
        gsap.to(element, { scale: 1.08, y: -4, rotate: -1, background: "var(--btn-hover-bg)", boxShadow: "var(--btn-hover-shadow)", color: "var(--danger)", duration: 0.2, ease: "power2.out", overwrite: true });
      };
      const reverseHoverAnimation = (element) => {
        gsap.to(element, { scale: 1, y: 0, rotate: 0, background: "var(--btn-bg)", boxShadow: "var(--btn-shadow)", color: "var(--btn-text)", duration: 0.2, ease: "power2.out", overwrite: true });
      };

      btnProjects.addEventListener('mouseenter', () => createHoverAnimation(btnProjects));
      btnProjects.addEventListener('mouseleave', () => reverseHoverAnimation(btnProjects));
      btnResume.addEventListener('mouseenter', () => {
        gsap.to(btnResume, { scale: 1.05, y: -2, background: "rgba(255,209,102,0.133)", boxShadow: "0 0 16px rgba(255,209,102,0.5)", color: "var(--accent)", duration: 0.2, ease: "power2.out", overwrite: true });
      });
      btnResume.addEventListener('mouseleave', () => {
        gsap.to(btnResume, { scale: 1, y: 0, background: "transparent", boxShadow: "none", color: "#FFD166", duration: 0.2, ease: "power2.out", overwrite: true });
      });
    }

    function applyFlickerToGlowElements() {
        document.querySelectorAll('.glow').forEach(element => { element.classList.add('flicker'); });
    }

    function scrambleFooterText() {
        const textElement = document.getElementById(FOOTER_COPYRIGHT_TEXT_ID);
        if (!textElement) return;

        const originalText = textElement.textContent;
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+';
        let iterations = 0;
        const totalIterations = originalText.length * 2; 

        const scrambleInterval = setInterval(() => {
            textElement.textContent = originalText.split('').map((char, index) => {
                if (index < iterations / 2) return originalText[index];
                return chars[Math.floor(Math.random() * chars.length)];
            }).join('');

            if (iterations >= totalIterations) {
                clearInterval(scrambleInterval);
                textElement.textContent = originalText; 
            }
            iterations += 1;
        }, 50); 
        setTimeout(() => { setInterval(scrambleFooterText, 30000); }, 10000); 
    }

    function setupSectionScanlines() {
        const sections = document.querySelectorAll('section');
        sections.forEach(section => {
            if (section.id === 'hero-section') return;
            const overlay = section.querySelector('.section-scan-overlay');
            if (overlay) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            gsap.fromTo(overlay,
                                { scaleY: 0, opacity: 0, transformOrigin: 'top' },
                                { scaleY: 1, opacity: 1, duration: 0.5, ease: "power2.out",
                                  onComplete: () => { gsap.to(overlay, { scaleY: 0, opacity: 0, duration: 0.5, ease: "power2.in", delay: 0.5 }); }
                                }
                            );
                        }
                    });
                }, { threshold: 0.3 }); 
                observer.observe(section);
            }
        });
    }

    function setupHologramProfile() {
        const aboutSection = document.getElementById(ABOUT_SECTION_ID);
        const hologramCube = document.getElementById(HOLOGRAM_PROFILE_CUBE_ID);
        if (!aboutSection || !hologramCube) return;

        aboutSection.addEventListener('mousemove', (e) => {
            const { left, top, width, height } = aboutSection.getBoundingClientRect();
            const x = (e.clientX - left) / width; 
            const y = (e.clientY - top) / height; 
            const rotateX = (y - 0.5) * 20; 
            const rotateY = (x - 0.5) * -20; 
            gsap.to(hologramCube, { rotationX: rotateX, rotationY: rotateY, duration: 0.5, ease: "power1.out" });
        });

        aboutSection.addEventListener('mouseleave', () => {
            gsap.to(hologramCube, { rotationX: 15, rotationY: -15, duration: 0.8, ease: "elastic.out(1, 0.5)" });
        });
    }

    function updateHudElements() {
        const hudTime = document.getElementById(HUD_TIME_ID);
        const hudWeather = document.getElementById(HUD_WEATHER_ID);
        const hudBattery = document.getElementById(HUD_BATTERY_ID);
        const hudStatus = document.getElementById(HUD_STATUS_ID);
        const hudUserId = document.getElementById(HUD_USER_ID_ID);

        if (!hudTime || !hudWeather || !hudBattery || !hudStatus || !hudUserId) return; 

        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
        hudTime.textContent = `TIME: ${timeString}`;
        hudWeather.textContent = `WTHR: CLEAR // 24C`; 
        hudBattery.textContent = `PWR: ${Math.floor(Math.random() * 5) + 95}%`; 
        hudStatus.textContent = `STS: OPTIMAL`; 
        hudUserId.textContent = `USR: ADMIN // SEC-${Math.floor(Math.random() * 99) + 1}`; 
    }

    function setupVisitorTracker() {
        const trackerLocation = document.getElementById(TRACKER_LOCATION_ID);
        const trackerUserId = document.getElementById(TRACKER_USER_ID_ID);
        const trackerSignal = document.getElementById(TRACKER_SIGNAL_ID);

        if (!trackerLocation || !trackerUserId || !trackerSignal) return; 

        trackerLocation.textContent = "GLOBAL_NODE"; 
        trackerUserId.textContent = `UNIT-${Math.floor(Math.random() * 99999).toString().padStart(5, '0')}`; 
        trackerSignal.textContent = `${Math.floor(Math.random() * 15) + 85}`; 

        setInterval(() => {
            trackerSignal.textContent = `${Math.floor(Math.random() * 15) + 85}`;
        }, 3000); 
    }

    function setupCustomCursorAndSpotlight() {
        const customCursor = document.querySelector(CUSTOM_CURSOR_SELECTOR);
        const spotlightEffect = document.querySelector(SPOTLIGHT_EFFECT_SELECTOR);
        if (!customCursor || !spotlightEffect) return;

        document.addEventListener('mousemove', (e) => {
            gsap.to(customCursor, { x: e.clientX, y: e.clientY, duration: 0.05, ease: "none" });
            spotlightEffect.style.setProperty('--mouse-x', `${e.clientX}px`);
            spotlightEffect.style.setProperty('--mouse-y', `${e.clientY}px`);
        });
    }

    const sections = [
        { id: 'hero-section', name: 'HOME' },
        { id: 'about', name: 'ABOUT' },
        { id: 'skills', name: 'SKILLS' },
        { id: 'projects', name: 'PROJECTS' },
        { id: 'current-focus', name: 'FOCUS' },
        { id: 'experience', name: 'EXPERIENCE' },
        { id: 'education', name: 'EDUCATION' },
        { id: 'certificates', name: 'CERTIFICATES' },
        { id: 'testimonials', name: 'FEEDBACK' },
        { id: 'contact', name: 'CONTACT' }
    ];
    let activeSectionId = 'hero-section'; 

    function updateSectionTooltip(sectionName) {
        const tooltip = document.getElementById(SECTION_TOOLTIP_ID);
        if (tooltip) {
            tooltip.textContent = `> You are now in: ${sectionName}`;
            gsap.to(tooltip, { opacity: 1, duration: 0.3 });
        }
    }

    function setupScrollSpyAndMiniNav() {
        const sectionElements = sections.map(s => document.getElementById(s.id)).filter(Boolean);
        const sectionTooltip = document.getElementById(SECTION_TOOLTIP_ID);
        const miniNav = document.getElementById(MINI_NAV_ID);

        if (!miniNav) return;

        sections.forEach((section, index) => {
            const dot = document.createElement('div');
            dot.classList.add('mini-nav-dot');
            dot.dataset.sectionId = section.id;
            dot.title = section.name; 
            dot.addEventListener('click', () => {
                gsap.to(window, { duration: 0.8, scrollTo: { y: `#${section.id}` }, ease: "power2.inOut" });
                SoundManager.play('click');
            });
            miniNav.appendChild(dot);
        });

        const miniNavDots = document.querySelectorAll('.mini-nav-dot');
        const observerOptions = { root: null, rootMargin: '0px', threshold: 0.3 };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    activeSectionId = entry.target.id;
                    const activeSection = sections.find(s => s.id === activeSectionId);
                    if (activeSection) {
                        updateSectionTooltip(activeSection.name);
                        miniNavDots.forEach(dot => {
                            if (dot.dataset.sectionId === activeSectionId) {
                                dot.classList.add('active');
                            } else {
                                dot.classList.remove('active');
                            }
                        });
                    }
                }
            });
        }, observerOptions);

        sectionElements.forEach(section => observer.observe(section));

        let scrollTimeout;
        window.addEventListener('scroll', () => {
            if (sectionTooltip) gsap.to(sectionTooltip, { opacity: 1, duration: 0.1 }); 
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                if (sectionTooltip) gsap.to(sectionTooltip, { opacity: 0, duration: 0.5 }); 
            }, 1000); 
        });
    }

    function setupKeyboardNavigation() {
        document.addEventListener('keydown', (event) => {
            if (event.target.tagName.toLowerCase() === 'input' || event.target.tagName.toLowerCase() === 'textarea') return;
            const key = event.key;
            const sectionIndex = parseInt(key) - 1; 

            if (sectionIndex >= 0 && sectionIndex < sections.length) {
                const targetSectionId = sections[sectionIndex].id;
                gsap.to(window, { duration: 0.8, scrollTo: { y: `#${targetSectionId}` }, ease: "power2.inOut" });
                SoundManager.play('click');
                event.preventDefault(); 
            }
        });
    }

    function setupLiveDemoModal() {
        const modalOverlay = document.getElementById(LIVE_DEMO_MODAL_OVERLAY_ID);
        const iframe = document.getElementById(LIVE_DEMO_IFRAME_ID);
        const closeBtn = document.getElementById(LIVE_DEMO_CLOSE_BTN_ID);
        const runLiveButtons = document.querySelectorAll(LIVE_DEMO_BUTTON_SELECTOR);

        if (!modalOverlay || !iframe || !closeBtn || runLiveButtons.length === 0) return;

        runLiveButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const url = event.target.dataset.projectUrl;
                if (url) {
                    iframe.src = url;
                    modalOverlay.classList.add('visible');
                    document.body.style.overflow = 'hidden'; // Stop background scrolling
                    SoundManager.play('click'); 
                }
            });
        });

        closeBtn.addEventListener('click', () => {
            modalOverlay.classList.remove('visible');
            iframe.src = ''; 
            document.body.style.overflow = 'auto';
            SoundManager.play('click'); 
        });

        modalOverlay.addEventListener('click', (event) => {
            if (event.target === modalOverlay) {
                modalOverlay.classList.remove('visible');
                iframe.src = ''; 
                document.body.style.overflow = 'auto';
                SoundManager.play('click');
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modalOverlay.classList.contains('visible')) {
                modalOverlay.classList.remove('visible');
                iframe.src = '';
                document.body.style.overflow = 'auto';
                SoundManager.play('click');
            }
        });
    }

    window.addEventListener('DOMContentLoaded', function () {
      typeTerminal();
      loadThemePreference(); 
      SoundManager.init(); 
      
      setupMatrixRain(); 
      fetchGitHubStats(); 
      
      makeDraggable('hud-1');
      makeDraggable('hud-2');
      makeDraggable('hud-3'); 

      setInterval(() => {
        const termCursor = document.getElementById(TERMINAL_CURSOR_ID);
        if (termCursor) termCursor.style.opacity = termCursor.style.opacity === "0" ? "1" : "0";
      }, 400);

      const terminalDisplay = document.getElementById(TERMINAL_DISPLAY_ID);
      if (terminalDisplay) terminalDisplay.addEventListener('click', randomTerminalFact);
      
      gsap.from("section", { duration: 1.3, opacity: 0, stagger: 0.4, delay: window.innerWidth < 480 ? 1.5 : 2.8 });
      gsap.from(".glass", { duration: 1.2, opacity: 0, y: window.innerWidth < 480 ? 20 : 40, stagger: 0.3, delay: window.innerWidth < 480 ? 1.8 : 3 });

      const robotContainer = document.getElementById('robot-container');
      if (robotContainer) {
        window.addEventListener('scroll', () => {
          if (!ticking) { window.requestAnimationFrame(animateRobot); ticking = true; }
        });
        gsap.fromTo(robotContainer, { y: 60, opacity: 0 }, { y: 0, opacity: 1, duration: 1.2, ease: "power3.out", delay: 1 });
      }

      const chatbotToggle = document.getElementById('chatbot-toggle');
      const chatbotWindow = document.getElementById('chatbot-window');
      const mobileNavOverlay = document.querySelector('.mobile-nav-overlay');

      if (chatbotToggle && chatbotWindow && mobileNavOverlay) {
        chatbotToggle.addEventListener('click', () => {
          chatbotWindow.classList.toggle('hidden');
          if (!chatbotWindow.classList.contains('hidden') && window.innerWidth <= 768) {
              mobileNavOverlay.classList.remove('hidden');
          } else {
              mobileNavOverlay.classList.add('hidden');
          }
          SoundManager.play('click'); 
        });

        mobileNavOverlay.addEventListener('click', (event) => {
          if (event.target === mobileNavOverlay && !chatbotWindow.classList.contains('hidden')) { 
              chatbotWindow.classList.add('hidden');
              mobileNavOverlay.classList.add('hidden');
          }
        });

        document.getElementById(CHATBOT_FORM_ID).addEventListener('submit', function (e) {
          e.preventDefault();
          const val = document.getElementById(CHATBOT_INPUT_ID).value.trim();
          if (!val) return;
          userSay(val);

          const lower = val.toLowerCase();
          let found = false;
          for (const key in aiAnswers) {
            if (lower.includes(key)) {
              botSay(aiAnswers[key]); found = true; break;
            }
          }
          if (found) { document.getElementById(CHATBOT_INPUT_ID).value = ""; return; }

          const phonePattern = /^[\d\s\-\+\(\)]{7,20}$/;
          if (phonePattern.test(val) || (lower.includes("phone number") || lower.includes("contact number"))) {
            botSay("Thank you! I've noted your contact request. Stephan will reach out soon.");
            document.getElementById(CHATBOT_INPUT_ID).value = "";
            document.getElementById(CHATBOT_INPUT_ID).disabled = true;
            setTimeout(() => {
              document.getElementById(CHATBOT_INPUT_ID).disabled = false;
              document.getElementById(CHATBOT_INPUT_ID).value = "";
            }, 3000); 
          } else {
            botSay("I'm sorry, I didn't understand that. Please enter a valid phone number, ask about my skills, projects, or use the buttons below.");
          }
        });
        document.getElementById(CLEAR_CHATBOT_BTN_ID).addEventListener('click', clearChatbotHistory);
        botSay("Hi there! I'm Stephan's AI assistant. How can I help you today? You can ask me about his **skills**, **projects**, or **contact** information.");
        showOptions();
      }

      if (heroTerminalInput) { 
        typeRoleIntoInput(); 
        heroTerminalInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); 
                handleHeroCommand(this.value);
            }
        });
      }

      setInterval(autoShootUFO, 12000);

      if (scrollTopBtn) { 
        window.addEventListener('scroll', () => {
          if (window.scrollY > 300) {
            scrollTopBtn.classList.remove('hidden');
          } else {
            scrollTopBtn.classList.add('hidden');
          }
        });
        scrollTopBtn.addEventListener('click', () => {
          gsap.to(window, { duration: 0.8, scrollTo: { y: 0 }, ease: "power2.inOut" });
          SoundManager.play('click'); 
        });
      }

      if (hero && heroBg1 && heroBg2) { 
        hero.addEventListener('mousemove', e => {
          const { left, top, width, height } = hero.getBoundingClientRect();
          const x = (e.clientX - left) / width - 0.5;
          const y = (e.clientY - top) / height - 0.5;
          gsap.to(heroBg1, { x: x * 40, y: y * 40, duration: 0.5, ease: "power2.out" });
          gsap.to(heroBg2, { x: -x * 30, y: -y * 30, duration: 0.5, ease: "power2.out" });
        });
      }

      setInterval(animateShootingStar, 15000);

      const themeToggleBtn = document.getElementById(THEME_TOGGLE_BTN_ID);
      if (themeToggleBtn) themeToggleBtn.addEventListener('click', toggleTheme);

      const soundToggleBtn = document.getElementById(SOUND_TOGGLE_BTN_ID);
      if (soundToggleBtn) soundToggleBtn.addEventListener('click', () => SoundManager.toggleMute());

      createDnaSkillVisualizer(skillGraphData);

      document.querySelectorAll('.futuristic-btn[data-filter]').forEach(button => {
        button.addEventListener('click', (event) => {
          document.querySelectorAll('.futuristic-btn[data-filter]').forEach(btn => btn.classList.remove('active'));
          event.target.classList.add('active'); 
          filterSkills(event.target.dataset.filter);
          SoundManager.play('click'); 
        });
      });

      const certPrevBtn = document.getElementById(CERT_PREV_BTN_ID);
      const certNextBtn = document.getElementById(CERT_NEXT_BTN_ID);
      if (certPrevBtn) certPrevBtn.addEventListener('click', () => scrollCertificates(-1));
      if (certNextBtn) certNextBtn.addEventListener('click', () => scrollCertificates(1));

      fetchLatestUpdates();
      animateHeroButtons();
      applyFlickerToGlowElements();
      scrambleFooterText();
      setupSectionScanlines();
      setupHologramProfile();

      setInterval(updateHudElements, 1000);
      updateHudElements(); 

      setupVisitorTracker();
      setupCustomCursorAndSpotlight();
      setupScrollSpyAndMiniNav();
      setupKeyboardNavigation(); 
      setupLiveDemoModal();

      window.scrollTo(0, 0);
    });

    window.showPhone = function () { botSay('My phone: <b>+959954480806</b><br>Telegram: <b>@stephanfilip</b>'); };
    window.showtg = function () { botSay('My Telegram: <b>@stephanfilip</b><br><a href="https://t.me/stephanfilip" target="_blank" class="futuristic-link">Open Telegram</a>'); };
    window.showfb = function () { botSay('My Facebook: <b>facebook.com/stephanfilip7</b><br><a href="https://facebook.com/stephanfilip7" target="_blank" class="futuristic-link">Open Facebook</a>'); };
    window.showwa = function () { botSay('My WhatsApp: <b>+959954480806</b><br><a href="https://wa.me/959954480806" target="_blank" class="futuristic-link">Open WhatsApp</a>'); };
    window.showgh = function () { botSay('My GitHub: <b>github.com/Filip2k03</b><br><a href="https://github.com/Filip2k03" target="_blank" class="futuristic-link">Open GitHub</a>'); };
    window.showli = function () { botSay('My LinkedIn: <b>linkedin.com/in/stephanfilip7</b><br><a href="https://www.linkedin.com/in/stephanfilip7" target="_blank" class="futuristic-link">Open LinkedIn</a>'); };
    window.showup = function () { botSay('My Upwork: <b>upwork.com/freelancers/~01b7c4e3e5e7b8b6c6</b><br><a href="https://www.upwork.com/freelancers/~01b7c4e3e5e7b8b6c6" target="_blank" class="futuristic-link">Open Upwork</a>'); };
  </script>
</body>

</html>