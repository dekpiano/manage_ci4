# Design Document: FET-Inspired Flexible Timetable Engine & Cross-Grade Excellence Blocks

**Date:** 2026-11-02  
**Status:** In Review  
**Target System:** SKJ Academic Management System (CodeIgniter 4 / Sneat Bootstrap 5)  
**Primary Theme Color:** `#15a362`  

---

## 1. Intent & The Why

### Background
The current academic scheduling system relies on a multi-attempt randomized greedy algorithm. While functional for basic assignments, it encounters bottlenecks (deadlocks) when subjected to complex high-school scheduling requirements—most notably:
1. **Cross-Grade Excellence Blocks (คาบเรียนสู่ความเป็นเลิศที่เรียนพร้อมกันหลายระดับชั้น):** Synchronized time slots across multiple grades (e.g., M.1–M.3 or M.4–M.6) where regular classes are suspended, and students attend elective/excellence tracks under multiple specialized teachers simultaneously.
2. **Pedagogical Constraints:** Avoiding consecutive teaching fatigue (Max Consecutive Hours $\le 3$), eliminating isolated free periods for teachers (Gap Control), and spacing multi-period subjects across the week (Min Days Between).

### The "Why"
Rather than relying on third-party desktop software or external binaries (such as running the standalone FET C++ program), the school requires a **100% native Web-based solution** embedded inside CodeIgniter 4. By taking the architectural concepts and heuristic algorithms from **FET (Free Evolutionary Timetabling by Liviu Lalescu)**, the system will achieve high flexibility, near 100% automatic completion, and complete data consistency within the school's existing databases.

---

## 2. Goals, Non-Goals, and Anti-Goals

### Goals
* **G1: Native FET Heuristic Recursive Swapping:** Implement a recursive depth-limited chain-swapping algorithm (depth 5–8) in PHP to resolve slot conflicts without wiping and restarting the entire schedule.
* **G2: Cross-Grade Excellence Block Manager:** Enable administrators to define, view, and assign synchronized blocks across multiple grade levels and classrooms, ensuring no regular subject encroaches upon these periods.
* **G3: Flexible Multi-Level Constraints (Hard vs. Soft):**
  * *Hard (100%):* No teacher double-booking, no room double-booking, no class double-booking, respect lunch/break periods, respect Master Locks & Excellence Blocks.
  * *Soft (< 100% with configurable penalty weights):*
    * `Min Days Between`: Multi-period subjects (e.g., 2+1 split) are placed on separate, non-adjacent days.
    * `Max Consecutive Hours`: Teachers teach at most 3 consecutive periods before a break.
    * `Max Daily Hours`: Daily load is distributed evenly across weekdays (max 4–5 periods/day).
    * `Teacher Gap Minimization`: Reduce scattered free periods within a teacher's workday.
* **G4: Sneat UI & Visual Progress:** Integrate intuitive constraint settings and a real-time progress monitor with detailed logs, styled with Sneat Admin, Boxicons, and the `#15a362` primary green palette.

### Non-Goals
* **NG1:** Running external binaries (like `fet-cl.exe` or C++ daemons) on the server.
* **NG2:** Altering the underlying structure of unrelated academic modules (e.g., student grading or registration).

### Anti-Goals
* **AG1:** Unresolvable infinite loops or timeouts during auto-generation (execution must have guaranteed upper bounds and fallback gracefully).
* **AG2:** Overwriting or ignoring user manual locks without explicit user confirmation.
* **AG3:** UI lockups, dark backdrop freeze, or broken modal transitions.

---

## 3. Approaches Considered

| Approach | Description | Pros | Cons | Verdict |
| :--- | :--- | :--- | :--- | :--- |
| **Approach 1: Native FET-Inspired Engine in CI4** | Implement FET's Activity-based data structures and Recursive Swapping algorithm natively in PHP/CI4. | Seamless web UX; zero server binary dependencies; 100% compatible with existing CI4 multi-database setup. | Requires careful algorithmic optimization in PHP. | **SELECTED BY USER** |
| **Approach 2: External FET Executable** | Export data to `.fet` XML, call `fet-cl` via shell `exec()`, import results. | Utilizes C++ speed directly. | Security risks with `exec()`; hosting environments often disallow binaries; maintenance overhead. | **REJECTED** |
| **Approach 3: Hybrid Web Engine + Export/Import** | Native engine plus optional file export to `.fet` for desktop inspection. | Maximum flexibility for desktop power users. | Added scope for XML parser while user explicitly specified not using external FET. | **REJECTED** |

---

## 4. Architectural Design & Core Components

```
+-----------------------------------------------------------------------------------+
|                           Sneat UI Admin Dashboard                                |
|  - Timetable Process Main (Preflight & AI Runner)                                 |
|  - Cross-Grade Excellence Block Manager (NEW)                                     |
|  - FET Constraints Settings (Min Days Between, Max Consecutive, Gap Control)      |
+-----------------------------------------------------------------------------------+
                                        |
                                        v
+-----------------------------------------------------------------------------------+
|               ConAdminTimetable / TimetableSolverService                          |
|                                                                                   |
|  Phase 1: Preflight & Anchor Lock Placement                                       |
|    - Load Master Slots & Config Days/Periods                                      |
|    - Place Cross-Grade Excellence Blocks (Hard Lock across target grades)         |
|    - Place Explicit Subject Locks & Teacher Busy Constraints                      |
|                                                                                   |
|  Phase 2: Activity Breakdown & Ordering (Most Constrained First)                  |
|    - Split multi-hour assignments into Activities: e.g. 3 hrs -> [2, 1]           |
|    - Sort activities by heuristic difficulty (Hours DESC, Joint/Multi-Teacher)    |
|                                                                                   |
|  Phase 3: Recursive Swapping Engine (Depth 5-8)                                   |
|    - Try placing Activity in empty valid slot                                     |
|    - If blocked: Recursive chain displacement (move conflicting A -> slot B)      |
|                                                                                   |
|  Phase 4: Soft Constraint Scoring & Optimization                                  |
|    - Calculate penalty score (Min Days, Max Consecutive, Gaps)                    |
|    - Keep best iteration or apply local search optimization                       |
+-----------------------------------------------------------------------------------+
                                        |
                                        v
+-----------------------------------------------------------------------------------+
|                              Database Storage                                     |
|  - tb_timetable_assignments (Existing)                                            |
|  - tb_timetable_data (Existing - generated schedule slots)                        |
|  - tb_timetable_excellence_blocks (NEW - Cross-grade definitions)                  |
|  - tb_timetable_constraints / tb_timetable_config_* (Existing/Extended)           |
+-----------------------------------------------------------------------------------+
```

---

## 5. Detailed Component Specifications

### 5.1 Cross-Grade Excellence Blocks (คาบเรียนสู่ความเป็นเลิศ)
* **Table Schema: `tb_timetable_excellence_blocks`**
  * `block_id` (INT PK AI)
  * `block_name` (VARCHAR 150 - e.g., "ความเป็นเลิศ ม.ต้น (ม.1-3)", "ความเป็นเลิศ ม.ปลาย (ม.4-6)")
  * `target_grades` (VARCHAR 100 - comma-separated, e.g. "ม.1,ม.2,ม.3" or specific classes)
  * `day` (VARCHAR 10 - e.g. "THU")
  * `start_period` (INT - e.g. 7)
  * `period_count` (INT - e.g. 2)
  * `teacher_ids` (TEXT NULL - comma-separated list of personnel IDs involved in teaching excellence courses during this block)
  * `term` (VARCHAR 5), `year` (VARCHAR 5)
  * `created_at` (TIMESTAMP)
* **Schedule Representation & Integration:**
  * **Teacher Timetable (`IndividualTimetable.php`):** The teachers listed in `teacher_ids` are marked busy during `[day, start_period .. start_period + count - 1]`. On their personal schedule, the system displays the Excellence Block title.
  * **Student Class Timetable (`ViewClassTimetable.php`):** All classrooms matching `target_grades` automatically display the synchronized Excellence Block card spanning the assigned periods. Regular subject assignments are strictly blocked from scheduling into these slots.
  * **Data Storage (`tb_timetable_data`):** Stored with a special system assignment identifier (`is_locked = 1`, `block_id` reference) so that both PDF exports, online viewers, and room/teacher checks recognize the reservation natively.

### 5.2 Heuristic Recursive Swapping Engine & Deadlock Policy
* **Activity Object:**
  * `activity_id`: Unique identifier
  * `assign_id`: Reference to assignment
  * `duration`: Number of consecutive periods (1, 2, or 3)
  * `class_names`: Array of participating classrooms (single class or joint group)
  * `teacher_ids`: Array of teachers involved
  * `subject_code`: Subject code for learning group separation
  * `split_index`: Index of split (e.g., split 0 of 2)
* **Algorithm Execution & Deadlock Resolution:**
  1. `SortActivities()`: Place activities with the fewest valid available slots first (Most Constrained First).
  2. For each activity $A$:
     - Find valid available slots with 0 hard conflicts.
     - If an empty valid slot exists, place $A$.
     - If NO empty slot exists: execute `RecursiveSwap(activity, max_depth = 6)`:
       - Identify candidate slots currently occupied by activity $B$.
       - Temporarily evict $B$, place $A$.
       - Recursively attempt to find an alternate valid slot for $B$ (which may displace $C$).
       - If a chain displacement succeeds within `max_depth`, commit the moves; otherwise backtrack.
  3. **Deadlock Fallback Policy:**
     - If an activity cannot be placed after exhausting recursive swap chains, it is moved to the **Unplaced Pool** with detailed diagnostic reasons (e.g., "Blocked by Teacher X busy in Thu P3, Room Y busy").
     - The solver does not abort the entire schedule; it records the partial state, logs the exact conflict diagnosis, and allows the admin to review unplaced items or manually adjust them in `EditorMain.php`.

### 5.3 Soft Constraint Architecture: Two-Stage Decoupled Solver
To guarantee high performance in PHP without exponential slowdown ($O(B^D)$):
* **Stage 1 (Hard Feasibility via Recursive Swapping):** Focuses 100% on placing all activities with zero hard conflicts (no room/teacher/student collision, honoring Master Locks and Excellence Blocks).
* **Stage 2 (Local Search Hill-Climbing for Soft Penalties):**
  - Once a feasible or best-effort placement is achieved, run a fast post-processing local search.
  - Iteratively test 2-opt swaps between compatible slots of the same class.
  - Accept a swap if and only if hard feasibility remains 100% valid AND the soft penalty score improves:
    $$\Delta \text{Penalty} = W_{\text{consec}} \cdot \Delta P_{\text{consec}} + W_{\text{mindays}} \cdot \Delta P_{\text{mindays}} + W_{\text{gaps}} \cdot \Delta P_{\text{gaps}} < 0$$
  - Target Soft Penalties:
    * $P_{\text{consec}}$: Penalty for teacher teaching $>3$ consecutive periods.
    * $P_{\text{mindays}}$: Penalty when split parts of a subject are scheduled on the same day or consecutive days.
    * $P_{\text{gaps}}$: Penalty for isolated 1-period gaps in teacher timetables.

### 5.4 Execution Pipeline & Performance Safeguards
* **Execution Model:** AJAX POST with internal time-slicing guard.
  * Max execution budget: 45 seconds (preventing PHP script timeout).
  * Iteration limit: Configurable (default 15–20 optimization cycles).
* **Progress & Logging:** Returns structured JSON containing step-by-step logs, success percentage, placed vs. unplaced counts, and conflict breakdowns for rendering directly in the Sneat modal `#modalAIProcessing`.

---

## 6. What Is Left to the Builder
* Specific threshold values for soft penalty weights ($W_{\text{consec}} = 10, W_{\text{mindays}} = 8, W_{\text{gaps}} = 4$).
* Maximum recursion depth default (recommended default: 6).
* Exact UI layout for the Excellence Block modal and period selector in `ProcessMain.php` and `Settings.php`.

