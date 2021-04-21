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
            'status' => \Yii::t('app', 'Status'),
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_ON_TREE => Yii::t('app', 'On tree'),
            self::STATUS_DROP => Yii::t('app', 'droped'),
            self::STATUS_ROTTEN => Yii::t('app', 'rotten'),
            self::STATUS_EATET => Yii::t('app', 'eatet'),
        ];
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        if ($this->scenario == self::SCENARIO_DEFAULT) {
            $this->scenario = self::SCENARIO_SEARCH;
        }

        $query = self::find();

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
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

    /**
     * @param $percent
     * @return bool
     */
    public function eat(): bool
    {
        if ($this->status === self::STATUS_ON_TREE) {
            $this->addError('percent', \Yii::t('app', 'Apple on tree'));
            return false;
        }

        if ($this->status === self::STATUS_ROTTEN) {
            $this->addError('percent', \Yii::t('app', 'Apple rotten'));
            return false;
        }

        if ($this->status === self::STATUS_EATET) {
            $this->addError('percent', \Yii::t('app', 'Apple eatet'));
            return false;
        }

        $this->percent -= $this->percent;
        if ($this->percent === 0) {
            $this->status = self::STATUS_EATET;
        }

        return $this->save();
    }

    /**
     * @return bool
     */
    public function fallToGround(): bool
    {
        if ($this->status !== self::STATUS_ON_TREE) {
            return false;
        }

        $this->status = self::STATUS_DROP;
        $this->drop_date = date('Y-m-d H:i:s');

        return $this->save();
    }
}
