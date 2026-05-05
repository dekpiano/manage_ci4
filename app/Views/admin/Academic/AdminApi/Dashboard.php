<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">วิชาการ /</span> จัดการ API สำหรับนักพัฒนา
    </h4>

    <div class="row g-4">
        <!-- API Connection Info -->
        <div class="col-md-12">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">API Configuration 🔐</h5>
                            <p class="card-text">ใช้ข้อมูลด้านล่างนี้ในการเชื่อมต่อกับระบบจากภายนอก</p>
                        </div>
                        <div class="avatar avatar-lg">
                            <span class="avatar-initial rounded bg-label-light"><i class="bx bx-key"></i></span>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="small text-white-50">API Base URL</label>
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control bg-transparent text-white border-light" value="<?= $base_url ?>" readonly id="baseUrlInput">
                                <button class="btn btn-outline-light" type="button" onclick="copyToClipboard('baseUrlInput')"><i class="bx bx-copy"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-white-50">X-API-KEY (Header)</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control bg-transparent text-white border-light" value="<?= $api_key ?>" readonly id="apiKeyInput">
                                <button class="btn btn-outline-light" type="button" onclick="togglePassword('apiKeyInput')"><i class="bx bx-show"></i></button>
                                <button class="btn btn-outline-light" type="button" onclick="copyToClipboard('apiKeyInput')"><i class="bx bx-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Endpoints List -->
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2"><i class="bx bx-list-ul me-2"></i>รายการ API Endpoints</h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th>รายการ</th>
                                <th>Method</th>
                                <th>URL Path</th>
                                <th>คำอธิบาย</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach($endpoints as $api): ?>
                            <tr>
                                <td><strong><?= $api['name'] ?></strong></td>
                                <td><span class="badge bg-label-success"><?= $api['method'] ?></span></td>
                                <td><code><?= str_replace($base_url, '', $api['url']) ?></code></td>
                                <td class="small text-wrap"><?= $api['desc'] ?></td>
                                <td>
                                    <a href="<?= $api['url'] ?>?key=<?= $api_key ?>" target="_blank" class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="bx bx-link-external"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Security Warning -->
        <div class="col-md-12">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <span class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2">
                    <i class="bx bx-error bx-xs"></i>
                </span>
                <div>
                    <strong>ข้อควรระวัง:</strong> API Key นี้เป็นความลับ ห้ามเปิดเผยต่อบุคคลภายนอกที่ไม่เกี่ยวข้อง ข้อมูลนักเรียนและบุคลากรเป็นข้อมูลส่วนบุคคล (PDPA) โปรดใช้งานด้วยความระมัดระวัง
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    var copyText = document.getElementById(elementId);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    
    Swal.fire({
        icon: 'success',
        title: 'คัดลอกแล้ว!',
        showConfirmButton: false,
        timer: 1000,
        toast: true,
        position: 'top-end'
    });
}

function togglePassword(elementId) {
    var x = document.getElementById(elementId);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
