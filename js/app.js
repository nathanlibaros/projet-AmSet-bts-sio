/* État de l'écran. Tout passe par render() : aucun rechargement de page. */

const state = {
  employees: EMPLOYEES.slice(),
  site: "",
  query: "",
  skills: [],
  sortKey: "nom",
  sortDir: 1,
  selectedId: null,
  mode: "detail"
};

const el = {
  site: document.getElementById("filter-site"),
  query: document.getElementById("filter-q"),
  skills: document.getElementById("filter-skills"),
  count: document.getElementById("result-count"),
  head: document.getElementById("grid-head"),
  body: document.getElementById("grid-body"),
  panel: document.getElementById("panel"),
  newBtn: document.getElementById("btn-new")
};

function escapeHtml(value) {
  return String(value).replace(/[&<>"]/g, function (c) {
    return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c];
  });
}

function initials(employee) {
  return (employee.prenom[0] + employee.nom[0]).toUpperCase();
}

/* ---------- Filtrage et tri ---------- */

function visibleEmployees() {
  const q = state.query.trim().toLowerCase();

  const rows = state.employees.filter(function (e) {
    const matchSite = !state.site || e.site === state.site;
    const matchQuery = !q || (e.nom + " " + e.prenom).toLowerCase().includes(q);
    const matchSkills = state.skills.every(function (code) {
      return e.competences.includes(code);
    });
    return matchSite && matchQuery && matchSkills;
  });

  return rows.sort(function (a, b) {
    let result;
    if (state.sortKey === "skillCount") {
      result = a.competences.length - b.competences.length;
    } else {
      result = String(a[state.sortKey]).localeCompare(String(b[state.sortKey]), I18n.current);
    }
    return result * state.sortDir;
  });
}

/* ---------- Rendu ---------- */

function renderFilters() {
  const previous = el.site.value;
  el.site.innerHTML = '<option value="">' + I18n.t("filter.allSites") + "</option>" +
    SITES.map(function (s) { return '<option value="' + s + '">' + s + "</option>"; }).join("");
  el.site.value = previous;

  el.skills.innerHTML = SKILLS.map(function (code) {
    const on = state.skills.includes(code);
    return '<button type="button" class="chip" data-skill="' + code + '" aria-pressed="' + on + '">' +
      I18n.t("skill." + code) + "</button>";
  }).join("");
}

function renderList() {
  const rows = visibleEmployees();

  el.count.textContent = rows.length === 0
    ? I18n.t("list.count.zero")
    : rows.length === 1 ? I18n.t("list.count.one") : I18n.t("list.count.many", { n: rows.length });

  el.head.querySelectorAll("button[data-sort]").forEach(function (btn) {
    const active = btn.dataset.sort === state.sortKey;
    btn.dataset.arrow = active ? (state.sortDir > 0 ? "↑" : "↓") : "";
    btn.closest("th").setAttribute("aria-sort",
      active ? (state.sortDir > 0 ? "ascending" : "descending") : "none");
  });

  if (rows.length === 0) {
    el.body.innerHTML = '<tr><td class="empty" colspan="4">' + I18n.t("list.empty") + "</td></tr>";
    return;
  }

  el.body.innerHTML = rows.map(function (e) {
    const skills = e.competences.map(function (c) { return I18n.t("skill." + c); }).join(", ");
    return '<tr data-id="' + e.id + '" aria-selected="' + (e.id === state.selectedId) + '">' +
      "<td>" + escapeHtml(e.nom) + "</td>" +
      "<td>" + escapeHtml(e.prenom) + "</td>" +
      '<td class="muted">' + escapeHtml(e.site) + "</td>" +
      '<td class="muted">' + escapeHtml(skills) + "</td>" +
      "</tr>";
  }).join("");
}

function renderDetail() {
  const employee = state.employees.find(function (e) { return e.id === state.selectedId; });

  if (!employee) {
    el.panel.innerHTML = '<div class="card muted">' + I18n.t("detail.empty") + "</div>";
    return;
  }

  const tags = employee.competences.map(function (c) {
    return '<span class="tag">' + I18n.t("skill." + c) + "</span>";
  }).join("");

  el.panel.innerHTML =
    '<div class="card">' +
      '<div class="card-head">' +
        '<span class="avatar">' + initials(employee) + "</span>" +
        "<div><p>" + I18n.t("civility." + employee.civilite) + " " +
          escapeHtml(employee.prenom + " " + employee.nom) + "</p>" +
          "<span>" + escapeHtml(employee.site) + "</span></div>" +
      "</div>" +
      "<dl>" +
        "<dt>" + I18n.t("detail.email") + "</dt><dd>" + escapeHtml(employee.email) + "</dd>" +
        "<dt>" + I18n.t("detail.phone") + "</dt><dd>" + escapeHtml(employee.telephone) + "</dd>" +
        "<dt>" + I18n.t("detail.address") + "</dt><dd>" + escapeHtml(employee.adresse) + "<br>" +
          escapeHtml(employee.codePostal + " " + employee.ville) + "</dd>" +
        "<dt>" + I18n.t("detail.skills") + "</dt><dd>" + tags + "</dd>" +
      "</dl>" +
      '<div class="form-actions"><button type="button" class="btn">' +
        I18n.t("action.edit") + "</button></div>" +
    "</div>";
}

function renderForm() {
  const siteOptions = SITES.map(function (s) {
    return '<option value="' + s + '">' + s + "</option>";
  }).join("");

  const skillChips = SKILLS.map(function (code) {
    return '<button type="button" class="chip" data-form-skill="' + code + '" aria-pressed="false">' +
      I18n.t("skill." + code) + "</button>";
  }).join("");

  el.panel.innerHTML =
    '<form class="card form-grid" id="employee-form">' +
      "<strong>" + I18n.t("form.title") + "</strong>" +
      '<label class="field"><span>' + I18n.t("form.civility") + "</span>" +
        '<select name="civilite"><option value="mme">' + I18n.t("civility.mme") +
        '</option><option value="m">' + I18n.t("civility.m") + "</option></select></label>" +
      '<label class="field"><span>' + I18n.t("form.lastName") + '</span><input name="nom"></label>' +
      '<label class="field"><span>' + I18n.t("form.firstName") + '</span><input name="prenom"></label>' +
      '<label class="field"><span>' + I18n.t("form.email") + '</span><input name="email" type="email"></label>' +
      '<label class="field"><span>' + I18n.t("form.phone") + '</span><input name="telephone"></label>' +
      '<label class="field"><span>' + I18n.t("form.address") + '</span><input name="adresse"></label>' +
      '<label class="field"><span>' + I18n.t("form.postalCode") + '</span><input name="codePostal"></label>' +
      '<label class="field"><span>' + I18n.t("form.city") + '</span><input name="ville"></label>' +
      '<label class="field"><span>' + I18n.t("form.site") + '</span><select name="site">' + siteOptions + "</select></label>" +
      '<fieldset class="chips"><legend>' + I18n.t("form.skills") + "</legend><div>" + skillChips + "</div></fieldset>" +
      '<p class="error" id="form-error" hidden></p>' +
      '<div class="form-actions">' +
        '<button type="submit" class="btn btn-primary">' + I18n.t("action.save") + "</button>" +
        '<button type="button" class="btn btn-ghost" data-cancel>' + I18n.t("action.cancel") + "</button>" +
      "</div>" +
    "</form>";
}

function render() {
  renderFilters();
  renderList();
  if (state.mode === "form") { renderForm(); } else { renderDetail(); }
}

/* ---------- Événements ---------- */

el.site.addEventListener("change", function () {
  state.site = el.site.value;
  renderList();
});

el.query.addEventListener("input", function () {
  state.query = el.query.value;
  renderList();
});

el.skills.addEventListener("click", function (event) {
  const chip = event.target.closest("[data-skill]");
  if (!chip) return;
  const code = chip.dataset.skill;
  const index = state.skills.indexOf(code);
  if (index === -1) { state.skills.push(code); } else { state.skills.splice(index, 1); }
  renderFilters();
  renderList();
});

el.head.addEventListener("click", function (event) {
  const btn = event.target.closest("button[data-sort]");
  if (!btn) return;
  const key = btn.dataset.sort;
  state.sortDir = state.sortKey === key ? -state.sortDir : 1;
  state.sortKey = key;
  renderList();
});

el.body.addEventListener("click", function (event) {
  const row = event.target.closest("tr[data-id]");
  if (!row) return;
  state.selectedId = Number(row.dataset.id);
  state.mode = "detail";
  renderList();
  renderDetail();
});

el.newBtn.addEventListener("click", function () {
  state.mode = "form";
  renderForm();
});

el.panel.addEventListener("click", function (event) {
  const chip = event.target.closest("[data-form-skill]");
  if (chip) {
    chip.setAttribute("aria-pressed", chip.getAttribute("aria-pressed") === "true" ? "false" : "true");
    return;
  }
  if (event.target.closest("[data-cancel]")) {
    state.mode = "detail";
    renderDetail();
  }
});

el.panel.addEventListener("submit", function (event) {
  event.preventDefault();
  const form = event.target;
  const error = document.getElementById("form-error");

  if (!form.nom.value.trim() || !form.prenom.value.trim()) {
    error.textContent = I18n.t("form.required");
    error.hidden = false;
    return;
  }

  const skills = Array.prototype.slice
    .call(form.querySelectorAll('[data-form-skill][aria-pressed="true"]'))
    .map(function (chip) { return chip.dataset.formSkill; });

  const created = {
    id: Date.now(),
    civilite: form.civilite.value,
    nom: form.nom.value.trim(),
    prenom: form.prenom.value.trim(),
    email: form.email.value.trim(),
    telephone: form.telephone.value.trim(),
    adresse: form.adresse.value.trim(),
    codePostal: form.codePostal.value.trim(),
    ville: form.ville.value.trim(),
    site: form.site.value,
    competences: skills
  };

  state.employees.push(created);
  state.selectedId = created.id;
  state.mode = "detail";
  render();
});

document.querySelectorAll("[data-lang]").forEach(function (btn) {
  btn.addEventListener("click", function () {
    I18n.use(btn.dataset.lang);
    syncLangButtons();
    render();
  });
});

function syncLangButtons() {
  document.querySelectorAll("[data-lang]").forEach(function (btn) {
    btn.setAttribute("aria-pressed", btn.dataset.lang === I18n.current);
  });
}

/* ---------- Démarrage ---------- */

I18n.restore();
syncLangButtons();
state.selectedId = state.employees[0].id;
render();
