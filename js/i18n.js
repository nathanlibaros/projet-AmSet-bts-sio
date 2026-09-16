/* Petit moteur de traduction.
   t("col.lastName") renvoie le libellé dans la langue courante.
   Les éléments HTML porteurs de data-i18n sont traduits automatiquement. */

const I18n = {
  current: "fr",
  fallback: "fr",

  available() {
    return Object.keys(window.I18N);
  },

  use(lang) {
    if (!window.I18N[lang]) return;
    this.current = lang;
    document.documentElement.lang = lang;
    localStorage.setItem("amset.lang", lang);
    this.applyToDom();
  },

  restore() {
    const saved = localStorage.getItem("amset.lang");
    const browser = (navigator.language || "").slice(0, 2);
    this.use(window.I18N[saved] ? saved : (window.I18N[browser] ? browser : this.fallback));
  },

  t(key, params) {
    const dict = window.I18N[this.current] || {};
    let text = dict[key] || window.I18N[this.fallback][key] || key;
    if (params) {
      Object.keys(params).forEach(function (p) {
        text = text.replace("{" + p + "}", params[p]);
      });
    }
    return text;
  },

  applyToDom() {
    const self = this;
    document.querySelectorAll("[data-i18n]").forEach(function (el) {
      el.textContent = self.t(el.dataset.i18n);
    });
  }
};
