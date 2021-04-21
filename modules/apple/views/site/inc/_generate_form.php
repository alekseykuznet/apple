<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var app\models\forms\AppleForm $appleForm */
?>

<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div class="col-xs-6">
        <?= $form->field($appleForm, 'count') ?>
    </div>
</div>

<?= Html::submitButton(\Yii::t('app', 'generate'), ['class' => 'btn']) ?>
<?php ActiveForm::end() ?>
