<?php

/**
 * @var \yii\web\View $this
 * @var string $message
 */

use yii\helpers\Html;
?>
<div class="site-error">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="text-center">
        <?= nl2br(Html::encode($message)) ?>
    </div>
</div>
