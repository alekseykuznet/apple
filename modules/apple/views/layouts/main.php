<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 * @var \yii\base\Exception $exception
 */

namespace app\modules\apple\views\layouts;
use app\modules\hub\assets\MainAsset;
use yii\helpers\Html;

$bundle = MainAsset::register($this);
$assetsPrefix = $bundle->baseUrl;

?>
<?php $this->beginPage() ?>
    <!doctype html>

    <html lang="<?= \Yii::$app->language ?>">
    <head>
        <meta charset="<?= \Yii::$app->charset ?>">

        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?= Html::csrfMetaTags() ?>
    </head>

    <body>
        <?php $this->beginBody() ?>


        <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
