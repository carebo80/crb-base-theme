<?php if (!defined('ABSPATH')) exit; ?>

<button
  class="icon-btn"
  x-data="crbThemeSwitcher()"
  x-init="init()"
  @click="cycle()"
  :aria-label="label"
  :title="label">

  <span x-show="mode==='system'" style="display:none">
    <?php echo crb_heroicon('computer-desktop', 'outline'); ?>
  </span>

  <span x-show="mode==='light'" style="display:none">
    <?php echo crb_heroicon('sun', 'outline'); ?>
  </span>

  <span x-show="mode==='dark'" style="display:none">
    <?php echo crb_heroicon('moon', 'outline'); ?>
  </span>

</button>


<script>
  function crbThemeSwitcher() {
    const KEY = 'theme';
    const MODES = ['system', 'light', 'dark'];
    const mql = window.matchMedia('(prefers-color-scheme: dark)');

    return {
      mode: localStorage.getItem(KEY) || (document.documentElement.dataset.theme || 'system'),
      label: 'Theme: System',

      init() {
        this.apply(this.mode);
        mql.addEventListener?.('change', () => {
          if ((localStorage.getItem(KEY) || 'system') === 'system') this.apply('system');
        });
      },

      apply(m) {
        const dark = (m === 'dark') || (m === 'system' && mql.matches);
        document.documentElement.classList.toggle('dark', dark);
        document.documentElement.dataset.theme = m;
        this.mode = m;
        this.label = m === 'system' ? 'Theme: System' : (m === 'light' ? 'Theme: Hell' : 'Theme: Dunkel');
      },

      cycle() {
        const idx = MODES.indexOf(this.mode);
        const next = MODES[(idx + 1) % MODES.length];
        localStorage.setItem(KEY, next);
        this.apply(next);
      }
    };
  }
</script>
