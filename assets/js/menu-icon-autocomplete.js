(() => {
  const raw = window.CRB_HEROICONS || {};

  const toArray = (v) => {
    if (Array.isArray(v)) return v;
    if (!v) return [];
    // Falls PHP mal ein Objekt/Assoc-Array liefert:
    if (typeof v === "object") return Object.values(v).flat();
    // Falls String (z.B. CSV) kommt:
    if (typeof v === "string")
      return v
        .split(",")
        .map((s) => s.trim())
        .filter(Boolean);
    return [];
  };

  const outline = toArray(raw.outline);
  const solid = toArray(raw.solid);
  const mini = toArray(raw.mini);
  const micro = toArray(raw.micro);

  const icons = Array.from(
    new Set([...outline, ...solid, ...mini, ...micro])
  ).filter(Boolean);

  console.log("[CRB] heroicons counts", {
    outline: outline.length,
    solid: solid.length,
    mini: mini.length,
    micro: micro.length,
    total: icons.length,
  });

  if (!icons.length) {
    console.warn(
      "[CRB] No icons available -> check wp_localize_script data shape"
    );
    return;
  }

  // datalist einmal erstellen
  let dl = document.getElementById("crb-heroicons-datalist");
  if (!dl) {
    dl = document.createElement("datalist");
    dl.id = "crb-heroicons-datalist";
    icons.forEach((name) => {
      const opt = document.createElement("option");
      opt.value = name;
      dl.appendChild(opt);
    });
    document.body.appendChild(dl);
    console.log("[CRB] datalist created");
  }

  const selector = [
    '.acf-field[data-name="crb_menu_icon"] input[type="text"]',
    'input[name*="[crb_menu_icon]"]',
    'input[name*="crb_menu_icon"]',
  ].join(",");

  const attach = () => {
    document.querySelectorAll(selector).forEach((inp) => {
      inp.setAttribute("list", "crb-heroicons-datalist");
      inp.setAttribute("autocomplete", "off");
      if (!inp.getAttribute("placeholder"))
        inp.setAttribute("placeholder", "z.B. shopping-bag");
    });
  };

  attach();
  new MutationObserver(attach).observe(document.body, {
    childList: true,
    subtree: true,
  });
})();
