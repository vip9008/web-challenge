<?php

use vip9008\materialgrid\widgets\ActiveForm;
use vip9008\materialgrid\helpers\Html;

$this->title = 'Web Challenge';
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="row radiobutton-group submit-options">
    <div class="radiobutton-input orange" tabindex="0">
        <div class="radio">
            <input type="radio" name="Tree[select]" value="0" checked>
        </div>
        <span class="label">Upload JSON file</span>
    </div>
    <div class="radiobutton-input orange" tabindex="0">
        <div class="radio">
            <input type="radio" name="Tree[select]" value="1">
        </div>
        <span class="label">Select uploaded file</span>
    </div>
</div>

<div class="space"></div>

<div class="row">
    <div class="col medium-12">
        <h2 class="orange">Upload a new files</h2>
        <div class="btn-group">
            <a class="btn raised color orange" href="javascript: file_input();">
                <div class="material-icon">attach_file</div>
                <span id="file-path-label">JSON file</span>
            </a>
        </div>
        <?= $form->field($model, 'jsonFile')->fileInput()->label(false) ?>
        <?= $form->field($model, 'json')->hiddenInput()->label(false) ?>
    </div>
</div>

<div class="row">
    <div class="col medium-12">
        <h2 class="orange">Uploaded files</h2>
        <div class="divider light"></div>
    </div>
</div>
<div class="row radiobutton-group" id="files-list">
    <?php
    foreach ($uploads as $json_file) {
        if (!$json_file->isDot() && !$json_file->isDir()) {
        ?>
        <div class="col large-3 medium-4 small-4 radiobutton-input orange disabled" tabindex="0">
            <div class="radio">
                <input type="radio" name="radiobutton" value="<?= $json_file->getPathname() ?>">
            </div>
            <span class="label"><?= $json_file->getFilename() ?></span>
        </div>
        <?php
        }
    }
    ?>
</div>
<div class="row"><div class="col medium-12"><div class="divider light"></div></div></div>

<div class="row">
    <div class="col medium-12">
        <div class="space"></div>
        <div class="btn-group">
            <button class="btn raised color orange-900">Submit</button>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>