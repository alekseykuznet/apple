<?php

namespace app\models\forms;

use app\helpers\Password;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var User
     */
    private $user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
        ];
    }

    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user = User::findOne([
            'email' => $this->email,
            'status' => User::STATUS_ACTIVE
        ]);

        if ($this->user === null || !Password::validate($this->password, $this->user->password_hash)
            || !\Yii::$app->user->login($this->user, 3600*24*30)) {
            $this->addError('email', \Yii::t('app', 'Wrong login or password'));
            return false;
        }

        $this->user->last_seen = date('Y-m-d H:i:s');
        $this->user->last_ip = \Yii::$app->request->userIP;
        $this->user->save();

        return false;
    }
}
