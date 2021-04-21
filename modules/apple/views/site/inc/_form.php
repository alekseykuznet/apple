<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kak\widgets\panel\Panel;

/** @var app\models\Apple $model */
?>

<?php Panel::begin(['heading' => false]) ?>

<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div class="col-xs-6">
        <?= $form->field($model, 'percent') ?>
    </div>
</div>

<?= Html::submitButton(\Yii::t('app', 'Eat'), ['class' => 'btn']) ?>
<?php ActiveForm::end() ?>

<?php Panel::end() ?>
