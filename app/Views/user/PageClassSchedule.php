<?= $this->extend('user/layout/main') ?>

<?= $this->section('content') ?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2>ตารางเรียน 1/2568 <small>(ฉบับทดลอง)</small> </h2>
                <div class="d-flex mt-3">
                   
                    <select class="w-auto countries" id="SearchClassSchedule">
                        <option selected="" value="">เลือกตารางเรียน...</option>
                    </select>
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
// โหลดข้อมูลรูปภาพจากฐานข้อมูล
$.ajax({
   url: 'user/searchclassschedule',
   method: 'GET',
   dataType: 'json',
   success: function(data) {
       console.log(data);
       
       $.each(data, function(index, image) {
           $('#SearchClassSchedule').append('<option value="' + image.schestu_filename + '"> ม.' + image.schestu_classname +' </option>');
       });
   },
   error: function(xhr, status, error) {
       console.error("Status:", status);
       console.error("Error:", error);
       console.error("Response Text:", xhr.responseText);
   }
});

// แสดงรูปภาพเมื่อมีการเปลี่ยนแปลงการเลือก
$('#SearchClassSchedule').change(function() {
   var selectedImage = 'uploads/academic/class_schedule/'+$(this).val();
   if (selectedImage) {
       $('#image').attr('src', selectedImage).show();
   } else {
       $('#image').hide();
   }
});

new SlimSelect({
    select: '#SearchClassSchedule'
  })
</script>

<?= $this->endSection() ?>