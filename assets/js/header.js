function crbHeader() {
  return {
    navOpen: false,
    searchOpen: false,
    scrolled: false,

    init() {
      const onScroll = () => (this.scrolled = (window.scrollY || 0) > 8);
      onScroll();
      window.addEventListener("scroll", onScroll, { passive: true });
    },

    openSearch() {
      this.searchOpen = true;
    },
    closeSearch() {
      this.searchOpen = false;
    },
  };
}

window.crbHeader = crbHeader;
