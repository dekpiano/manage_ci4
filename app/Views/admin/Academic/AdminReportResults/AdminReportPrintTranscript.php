<style>
    @page { size: A4; margin: 0; }
    body { font-family: 'thsarabun', sans-serif; margin: 0; padding: 0; }
    .page { position: relative; width: 210mm; height: 297mm; overflow: hidden; page-break-after: always; }
    .bg { position: absolute; top: 0; left: 0; width: 210mm; height: 297mm; z-index: -1; }
    .txt { position: absolute; font-weight: bold; font-size: 14pt; }
    
    /* พิกัดหน้า 1 */
    .f-name { top: 51.5mm; left: 125mm; }
    .f-last { top: 58.5mm; left: 125mm; }
    .f-code { top: 65.2mm; left: 145mm; }

    /* พิกัดหน้า 2 */
    .b-dir { top: 215mm; left: 120mm; width: 80mm; text-align: center; }
</style>

<!-- หน้า 1 -->
<div class="page">
    <img src="<?= $img_front ?>" class="bg">
    <div class="txt f-name"><?= esc($stu->StudentFirstName) ?></div>
    <div class="txt f-last"><?= esc($stu->StudentLastName) ?></div>
    <div class="txt f-code"><?= esc($stu->StudentCode) ?></div>
</div>

<!-- หน้า 2 -->
<div class="page" style="page-break-after: avoid;">
    <img src="<?= $img_back ?>" class="bg">
    <div class="txt b-dir">
        (นายอภิเชษฐ์  ฉิมพลีพันธุ์)<br>
        ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
    </div>
</div>
