<?php

namespace app\models\forms;

use app\models\Apple;
use Yii;
use yii\base\Model;

class AppleForm extends Model
{
    /**
     * @var integer
     */
    public $count;

    /**
     * @var integer
     */
    public $percent;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['count', 'percent'], 'integer'],
            [['count'], 'integer', 'min' => 0],
            [['percent'], 'integer', 'min' => 0, 'max' => 100],
        ];
    }

    public function generate()
    {
        if (!$this->validate()) {
            return false;
        }

        for ($i = 0; $i < $this->count; $i++) {
            $apple = new Apple();

            $apple->color = substr(md5(rand()), 0, 6);
            $apple->save();
        }

        return false;
    }
}
