<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * @property integer $id
 * @property string $color
 * @property integer $status
 * @property integer $percent
 * @property string $drop_date
 */
class Apple extends \yii\db\ActiveRecord
{
    const SCENARIO_SEARCH = 'search';

    const STATUS_ON_TREE = 0;
    const STATUS_DROP = 1;
    const STATUS_ROTTEN = 2;
    const STATUS_EATET = 3;

    const DEFAULT_PERCENT = 100;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apple';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color'], 'required'],
            [['status', 'percent'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['color'], 'string', 'max' => 50],
            [['image_url'], 'string', 'max' => 1000],
            [['drop_date'], 'string'],
        ];
    }

    public function scenarios()
    {
        $fields = [
            'id',
            'color',
            'status',
            'percent',
        ];

        $scenarios = ArrayHelper::merge(parent::scenarios(), [
            self::SCENARIO_SEARCH => $fields,
        ]);

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'Id'),
            'name' =>\Yii::t('app', 'Name'),
            'status' => \Yii::t('app', 'Status'),
        ];
    }

    public function search($params)
    {
        if ($this->scenario == self::SCENARIO_DEFAULT) {
            $this->scenario = self::SCENARIO_SEARCH;
        }

        $query = self::find();

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['count_view' => SORT_DESC]
            ]
        ]);

        if (!$this->load($params)) {
            return $dataProvider;
        }

        if ($this->status !== null) {
            $query->andWhere([
                'status' => $this->status,
            ]);
        }


        return $dataProvider;
    }
}
