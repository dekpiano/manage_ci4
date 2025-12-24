<footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    &#169;
                                    <script>
                                    document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤️ by
                                    <a href="" target="_blank" class="footer-link">Dekpiano</a>
                                </div>
                             
                            </div>
                        </div>
                    </footer>
<script>
console.log("Script block is executing.");

// Wait for the DOM to be fully loaded before running the script
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed.");

    const schoolYearSelect = document.getElementById('schyear_year');

    if (schoolYearSelect) {
        console.log("Found the select element.");

        schoolYearSelect.addEventListener('change', function(event) {
            console.log("Change event triggered.");
            
            const selectedYear = this.value;
            console.log("Selected value:", selectedYear);

            const formData = new FormData();
            formData.append('schyear_year', selectedYear);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            if (!confirm('คุณต้องการเปลี่ยนปีการศึกษาของระบบเป็น ' + selectedYear + ' ใช่หรือไม่?')) {
                console.log("User cancelled.");
                location.reload(); 
                return;
            }

            const targetUrl = '<?= site_url('Admin/Settings/UpdateSchoolYear') ?>';
            console.log("Sending fetch request to:", targetUrl);

            fetch(targetUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log("Received response from server.");
                return response.json();
            })
            .then(data => {
                console.log("Parsed JSON data:", data);
                if (data.status === 'success') {
                    alert('อัปเดตปีการศึกษาเรียบร้อยแล้ว');
                    location.reload();
                } else {
                    alert('เกิดข้อผิดพลาด: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                alert('เกิดข้อผิดพลาดที่ไม่คาดคิด (ดูที่ console สำหรับรายละเอียด)');
            });
        });
    }
});
</script>