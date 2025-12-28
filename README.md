# CRB Base Theme

Ein modernes, modulares WordPress-Theme auf Basis von **Tailwind CSS**, **Alpine.js** und **Heroicons**.
Entwickelt als saubere Grundlage für individuelle Kunden-Themes (Apotheke, KMU, Content-Sites).

> Fokus: Wartbarkeit, Customizer-Konfiguration, Dark/Light-Mode, komponentenbasierte Templates.

---

## ✨ Features

- 🧱 Komponentenbasierte Struktur (`template-parts/`)
- 🎨 Tailwind CSS (build → `assets/dist/main.css`)
- 🌗 Dark / Light / System Theme Switcher (Alpine.js)
- 🎛️ WordPress Customizer:
  - Hero (Bild, Höhe, Overlay, Titel, Text)
  - Primär- & Sekundärfarbe
  - Header / Navigation
  - Icon-Button Stil & Größe
- 🧭 Desktop & Mobile Navigation (Custom Walker)
- 🖼️ Heroicons (lokal eingebunden, SVG, `currentColor`)
- 🤝 Wiederverwendbare Module:
  - Hero
  - Features
  - Partner-Logos
  - Payment-Logos
- ⚙️ Keine externen UI-Frameworks (kein Bootstrap, kein UI-Overhead)

---

## 📁 Projektstruktur

````text
crb-base-theme/
├── assets/
│   ├── dist/                # kompiliertes CSS (Tailwind)
│   ├── js/                  # Alpine / Header JS
│   └── icons/heroicons/     # lokale Heroicons
│
├── inc/
│   ├── customizer.php       # alle Customizer Settings
│   └── icons.php            # crb_heroicon() + Icon-Liste
│
├── src/
│   └── Walkers/
│       └── NavWalker.php    # Custom Menu Walker
│
├── template-parts/
│   ├── hero.php
│   ├── features.php
│   ├── partners.php
│   ├── payments.php
│   └── ui/
│       └── theme-switcher.php
│
├── functions.php
├── style.css
├── tailwind.css
└── README.md

---

## 🎨 Styling & Design Tokens

Farben und UI-Tokens laufen über **CSS-Variablen**, gesetzt via Customizer:

```md
```css
:root {
  --c-primary
  --c-secondary
  --c-bg
  --c-surface
  --c-text
}
````
