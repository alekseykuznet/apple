<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 * @var \yii\base\Exception $exception
 */

namespace app\modules\apple\views\layouts;

use app\modules\apple\assets\GuestAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$bundle = GuestAsset::register($this);
$assetsPrefix = $bundle->baseUrl;

$controllerId = $this->context->id;
$actionId = $this->context->action->id;
$isIndexPage = $controllerId === 'site' && $actionId == 'index';

$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(["{$assetsPrefix}/favicon.ico"])]);
?>
<?php $this->beginPage() ?>
    <!doctype html>

    <html lang="<?= \Yii::$app->language ?>">
    <head>
        <meta charset="<?= \Yii::$app->charset ?>">
        <meta name="keywords" content="pornomoviehub.com,pornomoviehub, porno movie hub,porn,video,videos,"/>
        <meta name="description" content="PornoMmovieHub Free Porn Videos"/>
        <meta name="yandex-verification" content="947b523a3551adf4" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?= Html::csrfMetaTags() ?>
    </head>
    <body class="is-preload">
        <?php $this->beginBody() ?>
            <div id="wrapper">

                <header id="header">
                    <div class="inner">

                        <!-- Logo -->
                        <a href="<?= Url::to([\Yii::$app->homeUrl]) ?>" class="logo">
                            <span class="symbol">
                                <img src="/images/logo.svg" alt="" />
                            </span>
                            <span class="title">
                                <?= \Yii::$app->name ?>
                            </span>
                        </a>

                        <?php if (\Yii::$app->user->isGuest) : ?>
                            <?= $this->render('inc/login') ?>
                        <?php else : ?>
                            <?= $this->render('inc/user') ?>
                        <?php endif; ?>

                        <!-- Nav -->
                        <nav>
                            <ul>
                                <li>
                                    <a href="#menu"><?= \Yii::t('app', 'Categories') ?></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </header>


                <div id="main">
                    <div class="inner">
                        <section>
                            <?=
                                Breadcrumbs::widget([
                                    'homeLink' => [
                                        'label' => \Yii::t('app', 'Main'),
                                        'url' => \Yii::$app->homeUrl,
                                    ],
                                    'options' => [
                                            'class' => 'breadcrumb'
                                    ],
                                    'links' => isset($this->params['breadcrumbs'])?  $this->params['breadcrumbs']: [],
                            ]);
                            ?>
                        </section>
                        <?= $content ?>
                    </div>
                </div>

            </div>

        <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>

