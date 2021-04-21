<?php
namespace app\modules\hub\views\layouts\inc;

use app\models\forms\LoginForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$loginForm = new LoginForm()

?>

<?php
$form = ActiveForm::begin([
    'action' => ['site/login'],
    'enableAjaxValidation' => true,
    'validationUrl' => ['site/validate-login'],
    'options' => [
        'autocomplete' => 'off',
    ],
    'fieldConfig' => function ($model, $attribute) {
        $classes = ['col-3 col-12-xsmall'];

        $config = [
            'template' => "{input}",
            'options' => [
                'tag' => 'div',
                'class' => implode(' ', $classes)
            ]
        ];

        return $config;
    },
]) ?>

    <div class="row gtr-uniform">
        <?= $form->field($loginForm, 'email')
            ->textInput(['placeholder' => \Yii::t('app', 'You email')])->label(false)
        ?>

        <?= $form->field($loginForm, 'password')->passwordInput([
            'placeholder' => \Yii::t('app', 'You password')])->label(false)
        ?>

        <div class="col-3 col-12-xsmal">
            <ul class="actions">
                <li>
                    <?= Html::submitInput(\Yii::t('app', 'Login'),
                        ['class' => 'button primary fit small'])
                    ?>
                </li>
            </ul>
        </div>
    </div>

<?php ActiveForm::end() ?>
