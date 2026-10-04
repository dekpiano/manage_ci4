---
name: ci4-fullstack-mastery
description: >-
  Use this skill when developing, refactoring, or debugging CodeIgniter 4 (CI4) backend features,
  database queries across multiple databases, controllers, models, and API endpoints for the SKJ Academic System.
---

# CodeIgniter 4 (CI4) Fullstack Mastery

Comprehensive engineering standards and workflow procedures for developing robust, high-performance, and clean backend code in CodeIgniter 4 within the SKJ Academic System.

---

## 1. Multi-Database Architecture

The system connects to multiple databases:
1. **Academic DB (`skjacth_academic` / default `db`):**
   - Tables: `tb_register`, `tb_students`, `tb_subjects`, `tb_schoolyear`, `tb_register_onoff`, etc.
2. **Personnel DB (`skjacth_personnel`):**
   - Table: `tb_personnel` (Columns: `pers_id`, `pers_prefix`, `pers_firstname`, `pers_lastname`, `pers_learning`, `pers_status`, etc.)
3. **General School DB (`skjacth_skj` / `$this->DBSkj`):**
   - Tables: `tb_learning`, etc.

### Cross-Database Querying Rules:
- Always prefix tables explicitly when doing cross-database JOINs:
  ```php
  $builder = $this->db->table('skjacth_academic.tb_register');
  $builder->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = skjacth_academic.tb_register.TeacherID');
  $builder->join('skjacth_academic.tb_subjects', 'skjacth_academic.tb_subjects.SubjectID = skjacth_academic.tb_register.SubjectID');
  ```
- Always filter active students:
  ```php
  $builder->where('skjacth_academic.tb_students.StudentBehavior', 'ปกติ');
  // Or: ->where('tb_students.StudentStatus', '1/ปกติ');
  ```
- Optimize aggregates with `COUNT(DISTINCT StudentID)` when calculating headcount vs `COUNT(StudentID)` for course enrollments.

---

## 2. Controller & Business Logic Standards

1. **Input Handling & Security:**
   - Retrieve GET params with type safety and fallback:
     ```php
     $keyYear = urldecode($this->request->getGet('KeyYear') ?? '');
     if (empty($keyYear) || $keyYear === '0') {
         $keyYear = get_selected_year();
     }
     ```
   - Protect POST routes with CSRF:
     `<?= csrf_field() ?>` in forms.
2. **Aggregations & Statistical Calculations:**
   - Perform weighted GPA and grade distribution calculations cleanly:
     - Numeric grades: `0, 1, 1.5, 2, 2.5, 3, 3.5, 4`
     - Non-numeric grades: `ร` (Incomplete), `มส` (No Sit)
     - High performance grade: `3, 3.5, 4`
   - Calculate summary statistics array (`summaryStats`) in Controller and pass to View for fast rendering.
3. **Data Isolation for Excel Exports:**
   - Always clear output buffer before streaming Excel spreadsheets:
     ```php
     while (ob_get_level() > 0) {
         ob_end_clean();
     }
     ```
   - Set RFC-compliant `Content-Disposition` headers supporting UTF-8 Thai file names:
     `header('Content-Disposition: attachment; filename="' . $asciiFilename . '"; filename*=UTF-8\'\'' . $encodedFilename);`

---

## 3. Safe Refactoring & Error Prevention

1. **Null Safety:**
   - Always guard object/array access to avoid `Attempt to read property on null`:
     `$studentName = isset($stu) ? ($stu->StudentPrefix . $stu->StudentFirstName) : '-';`
2. **Preserve User Code:**
   - Never overwrite manual adjustments made by the user.
   - Test queries with defensive WHERE and GROUP BY clauses to prevent SQL `ONLY_FULL_GROUP_BY` issues.
3. **Buddhist Era Year Handling:**
   - Always ensure academic years reflect Buddhist Era (พ.ศ. e.g. 2568, 1/2568).
