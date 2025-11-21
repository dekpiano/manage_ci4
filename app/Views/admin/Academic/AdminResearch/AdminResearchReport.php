<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><?= isset($title) ? $title : '' ?></h4>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">ตัวกรองข้อมูล</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('Admin/Acade/Research/Report') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-3">
                        <label for="academic_year" class="form-label">ปีการศึกษา</label>
                        <select name="academic_year" id="academic_year" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <?php if (isset($academic_years)) : ?>
                                <?php foreach ($academic_years as $year) : ?>
                                    <option value="<?= esc($year->seres_year) ?>" <?= (isset($selected_year) && $selected_year == $year->seres_year) ? 'selected' : '' ?>>
                                        <?= esc($year->seres_year) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                     <div class="col-md-3">
                        <label for="term" class="form-label">ภาคเรียน</label>
                        <select name="term" id="term" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <option value="1" <?= (isset($selected_term) && $selected_term == '1') ? 'selected' : '' ?>>1</option>
                            <option value="2" <?= (isset($selected_term) && $selected_term == '2') ? 'selected' : '' ?>>2</option>
                            <option value="3" <?= (isset($selected_term) && $selected_term == '3') ? 'selected' : '' ?>>3</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="learning_group" class="form-label">กลุ่มสาระ</label>
                        <select name="learning_group" id="learning_group" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <?php if (isset($learning_groups)) : ?>
                                <?php foreach ($learning_groups as $group) : ?>
                                    <option value="<?= esc($group->lear_id) ?>" <?= (isset($selected_group) && $selected_group == $group->lear_id) ? 'selected' : '' ?>>
                                        <?= esc($group->lear_namethai) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">กรองข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                ผลการค้นหา
                <?php if (isset($selected_group_name)) : ?>
                    <small class="text-muted">| กลุ่มสาระ: <?= esc($selected_group_name) ?></small>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="researchReportTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>ชื่อ-นามสกุล (ครูผู้สอน)</th>
                            <th>ชื่องานวิจัย</th>
                            <th>สถานะ</th>
                            <th>ไฟล์</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($submissions) && !empty($submissions)) : ?>
                            <?php foreach ($submissions as $submission) : ?>
                                <tr>
                                    <td><?= esc($submission->pers_prefix . $submission->pers_firstname . ' ' . $submission->pers_lastname) ?></td>
                                    <td><?= isset($submission->seres_research_name) ? esc($submission->seres_research_name) : '-' ?></td>
                                    <td>
                                        <?php if (isset($submission->seres_ID)) : ?>
                                            <span class="badge bg-success">ส่งแล้ว</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">ยังไม่ส่ง</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                                                                <?php if (isset($submission->seres_file) && !empty($submission->seres_file)) : ?>
                                                                                    <a href="<?= $research_base_url . $submission->seres_year ?>/<?= $submission->seres_term ?>/<?= $submission->seres_file ?>" class="btn btn-sm btn-info" target="_blank">ดาวน์โหลด</a>
                                                                                <?php else : ?>
                                                                                    -
                                                                                <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#researchReportTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'excel', 'print'
            ],
            pageLength: -1,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ],
        });
    });
</script>
<?= $this->endSection() ?>
