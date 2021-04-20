<?php
namespace app\modules\hub\views\layouts\inc;

use yii\helpers\Html;

?>

<div class="row gtr-uniform">
    <div class="col-3 col-12-xsmal">
        <?= \Yii::$app->user->identity->email ?>
    </div>
    <div class="col-3 col-12-xsmal">
        <ul class="actions">
            <li>
                <?= Html::a(\Yii::t('app', 'Logout'),
                    ['site/logout'],
                    ['class' => 'button primary fit small'])
                ?>
            </li>
        </ul>
    </div>
</div>
