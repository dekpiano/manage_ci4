---
name: sneat-ui-ux-crafting
description: >-
  Use this skill when designing, building, or styling views, dashboards, tables, forms,
  and UI/UX components using the Sneat Bootstrap 5 template, Boxicons, and school theme guidelines.
---

# Sneat UI/UX Crafting & Modern Academic Dashboard Design

Standard operating procedures and design tokens for crafting accessible, high-contrast, and visually stunning web interfaces tailored for school administrators, teachers, and personnel.

---

## 1. 🎨 Theme Design Tokens & Color Standards

| Token | Hex / Value | Usage |
| :--- | :--- | :--- |
| **Primary Theme Green** | `#15a362` | Main buttons, active links, primary borders, progress bars |
| **Dark Emerald** | `#0d6d41` | Gradient end, text headers on light backgrounds |
| **Light Green / Soft Tint** | `#e8f5e9` | Table footer highlights, badge backgrounds, hover cards |
| **Header Accent Green** | `#ABDD93` | Sticky table header background |
| **Dark Header Text** | `#1b3815` | Text on `#ABDD93` headers for maximum contrast |
| **Solid White** | `#ffffff` | Text on green gradient headers, card backgrounds |

---

## 2. 👁️ Contrast & Accessibility Rules (Crucial!)

1. **High Contrast on Colored Backgrounds:**
   - **NEVER** use `text-white-50`, `opacity-75`, or semi-transparent white on `#15a362` backgrounds. Semi-transparent white blends with green and becomes unreadable.
   - **ALWAYS** force solid white text with full opacity:
     ```css
     .hero-header h1, .hero-header h2, .hero-header h3, .hero-header h4, .hero-header p {
         color: #ffffff !important;
         opacity: 1 !important;
         text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
     }
     ```
   - For badges inside green hero headers, use solid white backgrounds with dark green text:
     ```css
     .hero-header .hero-badge {
         background-color: #ffffff !important;
         color: #0d6d41 !important;
         font-weight: 700 !important;
     }
     ```
2. **Elderly & Multi-Device Accessibility:**
   - Use clear font sizes (minimum `0.85rem` for table cells, `1.25rem` for cards, `1.5rem`+ for heroes).
   - Thai typography: Use `K2D` or `Sarabun` with comfortable line heights.

---

## 3. 📊 Standard UI Component Patterns

### A. Hero Header Pattern
```html
<div class="hero-header fade-in-up">
    <div class="row align-items-center">
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; background: rgba(255, 255, 255, 0.22); border: 2px solid rgba(255, 255, 255, 0.5);">
                    <i class='bx bx-bar-chart-alt-2 fs-2 text-white'></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1 text-white">หัวข้อหน้าจอ</h4>
                    <p class="mb-0 text-white small">คำอธิบายรายละเอียด</p>
                </div>
            </div>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <span class="badge hero-badge fs-7 p-2 px-3 rounded-pill shadow-sm">
                <i class='bx bx-calendar me-1'></i> ปีการศึกษา 2568
            </span>
        </div>
    </div>
</div>
```

### B. KPI Summary Cards (Row of 4 Cards)
- Card 1: Total population / Students (Primary blue/green badge)
- Card 2: Excellence / Success Rate (Success green badge + progress bar)
- Card 3: Average GPA / Metric (Info blue/cyan badge)
- Card 4: Action Required / Follow-ups (Danger/Warning red/orange badge)

### C. 2D Sticky Tables (Sticky Header & Sticky Footer)
- Wrap in `.table-sticky-container` with `max-height: 72vh; overflow: auto;`.
- First header row: `top: 0; z-index: 25;`
- Second header row: `top: 41px; z-index: 25;`
- Footer row (`<tfoot>`): `bottom: 0; z-index: 20; background: #e8f5e9 !important; border-top: 2px solid #15a362;`

### D. Real-Time Quick Search
- Input with search icon, clear button (`#btnClearSearch`), and counter badge (`#filteredCountBadge`).
- Real-time instant filtering via DataTables API `table.search(val).draw()`.

### E. SweetAlert2 Standard
- Always ensure `z-index: 9999 !important;` so alerts sit above all modals and preloader overlays.

---

## 4. 🖨️ Print Media Standardization (`@media print`)
- Hide navbar, sidebar, hero headers, action buttons, search bars:
  `display: none !important;`
- Reset table container overflow:
  `max-height: none !important; overflow: visible !important;`
- Set table borders to clean 0.5pt solid black and text to pure black `#000000`.
