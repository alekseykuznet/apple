<?php
use yii\widgets\ListView;
?>

<?=
    ListView::widget([
        'dataProvider' => $provider,
        'layout' => "{items}<br>{pager}",
        'itemView' => 'inc/_category_item',
        'options' => [
            'tag' => 'section',
            'class' => 'tiles'
        ],
        'itemOptions' => [
            'tag' => 'article',
            'class' => 'style1',
        ],
    ])
?>
