<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kak\widgets\panel\Panel;

/** @var app\models\forms\AppleForm $appleForm */
?>

<?php Panel::begin(['heading' => false]) ?>

<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div class="col-xs-6">
        <?= $form->field($appleForm, 'count') ?>
    </div>
</div>

<?= Html::submitButton(\Yii::t('app', 'generate'), ['class' => 'btn']) ?>
<?php ActiveForm::end() ?>

<?php Panel::end() ?>
