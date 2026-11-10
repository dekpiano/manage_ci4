# FET-Inspired Flexible Timetable Engine & Cross-Grade Excellence Blocks Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement a native FET-inspired timetable solver with recursive chain swapping and a specialized Cross-Grade Excellence Block management system in CodeIgniter 4 for SKJ Academic System.

**Architecture:** A modular Two-Stage Decoupled Solver (`FetRecursiveSolver.php`) that anchors Hard Constraints (Master Locks & Synchronized Excellence Blocks) first, applies depth-limited recursive chain displacement (depth 6) to achieve 100% hard feasibility without deadlocks, and subsequently applies local search hill-climbing to optimize pedagogical soft constraints (Min Days Between, Max 3 Consecutive Hours, Teacher Gap Minimization). Accompanied by a Sneat-styled UI for managing Cross-Grade Excellence Blocks.

**Tech Stack:** PHP 8.1+, CodeIgniter 4, MySQL, Bootstrap 5 (Sneat Admin Template), Boxicons, jQuery/AJAX, SweetAlert2.

**Spec:** [docs/superpowers/specs/2026-11-02-fet-timetable-engine-design.md](file:///d:/SkjSystem/academic2025/docs/superpowers/specs/2026-11-02-fet-timetable-engine-design.md)

## Global Constraints
- Primary design color `#15a362` for primary buttons and status highlights.
- Contrast rule: White text on dark/green backgrounds must be `#ffffff !important` with `opacity: 1 !important`; no `text-white-50`.
- SweetAlert2 z-index: `z-index: 9999 !important`.
- Modal rule: Modals must be placed in `<?= $this->section('modals') ?>`, never in `section('content')`.
- Clean backdrop safeguard: Remove stale `.modal-backdrop` and remove `.modal-open` from `body`.
- Naming conventions: Controllers `Con...`, Models `Mod...`, Views match folder conventions.

## Review Focus
1. **Multi-teacher & Joint Subject Group Conflicts:** When an assignment has multiple comma-separated teacher IDs or is part of a joint group, recursive swaps must check availability across all involved teachers simultaneously.
2. **Excellence Block Range Overlaps:** If an excellence block covers periods 7-8 on Thursday, no regular subject split may cross or partially overlap into these periods.
3. **Infinite Recursion Protection:** Recursive swapping must strictly enforce `depth > max_depth` and track visited slot states in the active branch to prevent circular eviction loops.
4. **Time Budget Guard:** The solver must terminate gracefully before PHP max execution time (budget: 45 seconds), saving the best valid partial schedule and providing detailed diagnostic reasons for any unplaced items.
5. **Session & Multi-Database Integrity:** Personnel queries must use `$this->db_personnel`, academic curriculum queries `$this->db`, and timetable queries `$this->db_timetable`.

---

## Task Decomposition

### Task 1: Database Migration & Model for Cross-Grade Excellence Blocks
**Files:**
- Create/Execute: Schema setup in `app/Models/Admin/Academic/ModAdminTimetable.php` (table `tb_timetable_excellence_blocks`)
- Modify: `app/Models/Admin/Academic/ModAdminTimetable.php`

- [ ] Add `createExcellenceBlocksTable()` method in `ModAdminTimetable.php` to ensure `tb_timetable_excellence_blocks` table exists with fields: `block_id` (INT PK AI), `block_name` (VARCHAR 150), `target_grades` (VARCHAR 100), `day` (VARCHAR 10), `start_period` (INT), `period_count` (INT), `teacher_ids` (TEXT NULL), `term` (VARCHAR 5), `year` (VARCHAR 5), `created_at` (TIMESTAMP).
- [ ] Add CRUD model methods:
  - `getExcellenceBlocks($term, $year)`
  - `getExcellenceBlockById($blockId)`
  - `saveExcellenceBlock($data)`
  - `deleteExcellenceBlock($blockId)`
- [ ] Verify database table structure via CLI query.

---

### Task 2: Controller & Routes for Cross-Grade Excellence Blocks
**Files:**
- Modify: `app/Config/Routes.php`
- Modify: `app/Controllers/Admin/Academic/ConAdminTimetable.php`

- [ ] Add routes in `app/Config/Routes.php` under `admin/academic/timetable`:
  - `$routes->get('excellence-blocks', 'Admin\Academic\ConAdminTimetable::excellenceBlocks');`
  - `$routes->post('save-excellence-block', 'Admin\Academic\ConAdminTimetable::saveExcellenceBlock');`
  - `$routes->post('delete-excellence-block/(:num)', 'Admin\Academic\ConAdminTimetable::deleteExcellenceBlock/$1');`
- [ ] Implement `excellenceBlocks()` in `ConAdminTimetable.php` to fetch existing blocks, available teachers (`tb_personnel`), and active periods/days.
- [ ] Implement `saveExcellenceBlock()` with input validation (check period range, term/year, target grades) and return JSON.
- [ ] Implement `deleteExcellenceBlock($id)` with JSON response.

---

### Task 3: UI for Excellence Block Management (Sneat View)
**Files:**
- Create: `app/Views/admin/Academic/AdminTimetable/ExcellenceBlocks.php`
- Modify: `app/Views/admin/layout/_partials/sidebar.php`

- [ ] Create `ExcellenceBlocks.php` following Sneat Bootstrap 5 template with `#15a362` accents.
  - Card table displaying configured Excellence Blocks (Name, Target Grades, Day/Periods, Assigned Teachers count, Actions).
  - Add/Edit Modal inside `<?= $this->section('modals') ?>` with:
    - Block Name input (e.g. "กิจกรรมสู่ความเป็นเลิศ ม.ต้น")
    - Target Grades multi-select or checkbox pills (ม.1, ม.2, ม.3, ม.4, ม.5, ม.6)
    - Day select (MON, TUE, WED, THU, FRI)
    - Start Period & Period Count selector
    - Teacher Multi-select (with search/filter by personnel name)
  - SweetAlert2 notifications with `z-index: 9999 !important`.
  - Backdrop safeguard on modal hide.
- [ ] Add "บล็อกความเป็นเลิศข้ามชั้น" menu link in `app/Views/admin/layout/_partials/sidebar.php` under the timetable group.

---

### Task 4: Core FET Solver Service (`FetRecursiveSolver.php`)
**Files:**
- Create: `app/Libraries/Timetable/FetRecursiveSolver.php`

- [ ] **Data Model & Initialization:**
  - Define `Activity` class/struct: `id`, `assign_id`, `class_names`, `teacher_ids`, `subject_code`, `duration`, `split_index`.
  - Load grid dimensions (Active Days, Periods, Breaks).
  - Anchor Phase: Apply Master Slots, Excellence Blocks (locking target grades and marking teachers busy), and manual subject locks.
- [ ] **Heuristic Sorting (Most Constrained First):**
  - Score activities based on degree of constraint: Multi-classroom joint groups > Long durations (3 hrs > 2 hrs > 1 hr) > Teachers with restricted availability.
- [ ] **Recursive Swapping Engine:**
  - Implement `tryPlaceActivity($activity, $depth = 0, &$visited_chain = [])`:
    - Find available slots with zero hard conflicts.
    - If valid slot found, place and return true.
    - If no empty valid slot: iterate over candidate occupied slots.
    - For candidate slot with occupant $B$: temporarily displace $B$, place $A$, and recursively call `tryPlaceActivity($B, $depth + 1)`.
    - If recursion succeeds, commit chain.
    - If recursion fails or reaches `max_depth = 6`, backtrack and restore state.
- [ ] **Two-Stage Decoupling & Soft Constraints (Local Search Hill-Climbing):**
  - Implement soft penalty scoring:
    - $P_{\text{consec}}$: Consecutive hours $> 3$ for teachers.
    - $P_{\text{mindays}}$: Multi-part activities occurring on same/adjacent days.
    - $P_{\text{gaps}}$: Isolated teacher gaps.
  - Run 2-opt swaps between compatible slots of the same classroom to minimize total penalty without violating hard constraints.
- [ ] **Diagnostics & Fallback Pool:**
  - If any activity cannot be placed after chain exhaustion, collect diagnostic logs explaining the conflict (e.g., "Blocked on THU P7-8 due to Excellence Block, WED P3-4 due to Teacher X busy").

---

### Task 5: Integration with ConAdminTimetable `autoGenerate` & Process View
**Files:**
- Modify: `app/Controllers/Admin/Academic/ConAdminTimetable.php`
- Modify: `app/Views/admin/Academic/AdminTimetable/ProcessMain.php`

- [ ] In `ConAdminTimetable::autoGenerate`:
  - Initialize `FetRecursiveSolver` with assignments, constraints, master slots, and excellence blocks.
  - Execute solver with execution time guard (max 45 seconds).
  - Save placed slots to `tb_timetable_data` within a database transaction.
  - Record and return structured JSON response containing:
    - Status (`success` / `partial`)
    - Placed percentage and unplaced count
    - Step-by-step log lines
    - Conflict diagnostic breakdown for unplaced items
- [ ] In `ProcessMain.php`:
  - Add Preflight check row for "บล็อกความเป็นเลิศข้ามระดับชั้น" (showing number of active blocks).
  - Add configuration toggles for soft constraints (Min Days, Max 3 Consec Hours, Gap Control).
  - Render rich conflict diagnostic box if any unplaced activities remain.

---

### Task 6: View Integration in Student & Teacher Timetables
**Files:**
- Modify: `app/Views/admin/Academic/AdminTimetable/Partials/ViewClassTimetable.php`
- Modify: `app/Views/admin/Academic/AdminTimetable/IndividualTimetable.php`

- [ ] In `ViewClassTimetable.php`:
  - When rendering slots for a class in a target grade of an Excellence Block, display the synchronized block spanning across the periods with badge "กิจกรรมสู่ความเป็นเลิศ".
- [ ] In `IndividualTimetable.php`:
  - For teachers in `teacher_ids` of the block, display the Excellence course card with room/subject name during those periods.

---

### Task 7: Comprehensive Verification & Stress Testing
**Files:**
- Test via execution script or test controller endpoint.

- [ ] Verify Excellence Blocks creation and saving.
- [ ] Run `autoGenerate` test on real school dataset (term 1/2568 or 2/2567).
- [ ] Verify that no regular subject is placed in the Excellence Block time windows for target grades.
- [ ] Verify that recursive swapping resolves tight teacher schedules.
- [ ] Verify that UI modals open, save, and close cleanly without modal-backdrop freezing.

