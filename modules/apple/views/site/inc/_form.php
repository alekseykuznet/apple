<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var app\models\Apple $model */
?>

<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div class="col-xs-6">
        <?= $form->field($model, 'percent') ?>
    </div>
</div>

<?= Html::submitButton(\Yii::t('app', 'Eat'), ['class' => 'btn']) ?>
<?php ActiveForm::end() ?>

