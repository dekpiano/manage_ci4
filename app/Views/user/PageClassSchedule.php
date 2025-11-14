<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2 id="schedule-title">ตารางเรียน <small>(ฉบับทดลอง)</small> </h2>
                <div class="d-flex mt-3 align-items-center">
                    <div style="margin-right: 10px;">
                        <select class="w-auto countries" id="SearchYear">
                            <option value="">เลือกปีการศึกษา...</option>
                        </select>
                    </div>
                    <div style="margin-right: 10px;">
                        <select class="w-auto countries" id="SearchTerm">
                            <option value="">เลือกภาคเรียน...</option>
                        </select>
                    </div>
                    <div>
                        <select class="w-auto countries" id="SearchClassSchedule">
                            <option value="">เลือกตารางเรียน...</option>
                        </select>
                    </div>
                </div>

                <img id="image" src="" alt="Selected Image" class="img-fluid mt-3" style="display:none;">
            </div>

        </div>
    </div>
</div>

<style>
    .countries.ss-main {
        height: 50px;
        font-size: 18px;
        font-weight: bold;
    }
    .ss-main .ss-single-selected {
        height: 50px;
        width: 200px;
    }
</style>

<script>
$(document).ready(function() {
    var uploadServerBaseUrl = '<?= env("upload.server.baseurl") ?>';

    var slimYear = new SlimSelect({
        select: '#SearchYear'
    });

    var slimTerm = new SlimSelect({
        select: '#SearchTerm'
    });

    var slimClass = new SlimSelect({
        select: '#SearchClassSchedule'
    });

    // Initially disable term and class schedule selects
    $('#SearchTerm').prop('disabled', true);
    slimTerm.disable();
    $('#SearchClassSchedule').prop('disabled', true);
    slimClass.disable();

    // Load years into #SearchYear
    $.ajax({
        url: '<?= site_url('user/getscheduleyears') ?>',
        method: 'GET',
        dataType: 'json',
        success: function(years) {
            var yearOptions = [{ text: 'เลือกปีการศึกษา...', value: '' }];
            $.each(years, function(index, year) {
                yearOptions.push({ text: 'ปีการศึกษา ' + year.schestu_year, value: year.schestu_year });
            });
            slimYear.setData(yearOptions);
        },
        error: function(xhr, status, error) {
            console.error("Failed to load years:", error);
        }
    });

    // Handle year selection change
    $('#SearchYear').change(function() {
        var selectedYear = $(this).val();
        
        // Reset and disable term and class schedule selects
        slimTerm.setData([{ text: 'เลือกภาคเรียน...', value: '' }]);
        slimClass.setData([{ text: 'เลือกตารางเรียน...', value: '' }]);
        $('#image').hide();
        $('#SearchClassSchedule').prop('disabled', true);
        slimClass.disable();
        
        if (selectedYear) {
            $('#schedule-title').html('ตารางเรียน <small>(ฉบับทดลอง)</small>');
            $('#SearchTerm').prop('disabled', false);
            slimTerm.enable();
            slimTerm.setData([
                { text: 'เลือกภาคเรียน...', value: '' },
                { text: 'ภาคเรียนที่ 1', value: '1' },
                { text: 'ภาคเรียนที่ 2', value: '2' }
            ]);
        } else {
            $('#SearchTerm').prop('disabled', true);
            slimTerm.disable();
        }
    });

    // Handle term selection change
    $('#SearchTerm').change(function() {
        var selectedYear = $('#SearchYear').val();
        var selectedTerm = $(this).val();

        // Reset class schedule select
        slimClass.setData([{ text: 'เลือกตารางเรียน...', value: '' }]);
        $('#image').hide();

        if (selectedYear && selectedTerm) {
            $('#schedule-title').html('ตารางเรียน ภาคเรียนที่ ' + selectedTerm + '/' + selectedYear + ' <small>(ฉบับทดลอง)</small>');
            $('#SearchClassSchedule').prop('disabled', false);
            slimClass.enable();
            
            // Load class schedules for the selected year and term
            $.ajax({
                url: '<?= site_url('user/searchclassschedule') ?>',
                method: 'GET',
                data: { year: selectedYear, term: selectedTerm },
                dataType: 'json',
                success: function(data) {
                    var classOptions = [{ text: 'เลือกตารางเรียน...', value: '' }];
                    if(data.length > 0){
                        $.each(data, function(index, image) {
                            classOptions.push({ text: 'ม.' + image.schestu_classname +' ('+ image.schestu_name + ')', value: image.schestu_filename });
                        });
                    } else {
                        classOptions.push({ text: 'ไม่พบข้อมูล', value: '', disabled: true });
                    }
                    slimClass.setData(classOptions);
                },
                error: function(xhr, status, error) {
                    console.error("Failed to load class schedules:", error);
                    slimClass.setData([{ text: 'เกิดข้อผิดพลาด', value: '', disabled: true }]);
                }
            });
        } else {
            $('#SearchClassSchedule').prop('disabled', true);
            slimClass.disable();
        }
    });

    // Handle class schedule selection change
    $('#SearchClassSchedule').change(function() {
        var selectedImage = $(this).val();
        var selectedYear = $('#SearchYear').val();
        var selectedTerm = $('#SearchTerm').val();

        if (selectedImage && selectedYear && selectedTerm) {
            // Path is now just the dynamic parts, as the base URL contains the static path
            var imagePath = selectedYear + '/' + selectedTerm + '/' + selectedImage;
            var imageUrl = uploadServerBaseUrl + imagePath;
            var proxiedUrl = '<?= base_url('image_proxy.php?url=') ?>' + encodeURIComponent(imageUrl);
            $('#image').attr('src', proxiedUrl).show();
        } else {
            $('#image').hide();
        }
    });
});
</script>

<?= $this->endSection() ?>
