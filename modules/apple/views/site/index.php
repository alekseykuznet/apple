<?php
use kak\widgets\grid\GridView;;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use app\models\Apple;

/**
 * @var yii\web\View  $this
 * @var yii\data\ActiveDataProvider $provider
 */
?>
<?php if (!\Yii::$app->user->isGuest) : ?>
    <?= $this->render('inc/_generate_form', compact('appleForm')) ?>
<?php endif; ?>
<hr>

<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id',
        'color',
        'percent',
        'status' => [
            'attribute' => 'status',
            'value' => function($model){
                return Apple::getStatuses()[$model->status];
            }
        ],
        'created_at',
        'drop_date',
        'actions' => [
            'class' => ActionColumn::class,
            'template' => '{eat} {drop} {delete}',
            'buttons' => [
                'eat' => function ($url, $model, $key) {
                    return Html::a(Yii::t('app', 'eat'), [
                        'eat',
                        'id' => $model->id,
                    ], [
                            'class' => 'btn btn-success btn-xs',
                            'data-method' => 'post',
                        ]
                    );
                },
                'drop' => function ($url, $model, $key) {
                    return Html::a(Yii::t('app', 'drop'), [
                        'drop',
                        'id' => $model->id,
                    ], [
                            'class' => 'btn btn-success btn-xs',
                            'data-method' => 'post',
                        ]
                    );
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a(Yii::t('app', 'action grid delete'), [
                        'delete',
                        'id' => $model->id,
                    ], [
                            'class' => 'btn btn-danger btn-xs',
                            'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                            'data-method' => 'post',
                        ]
                    );
                },
            ],
        ],
    ],
]) ?>
