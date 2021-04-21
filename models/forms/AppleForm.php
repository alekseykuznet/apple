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
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['count'], 'required'],
            [['count'], 'integer', 'min' => 0],
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
