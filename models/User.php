<?php

namespace app\models;

use app\helpers\Password;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property string $last_ip
 * @property string $last_seen
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    const SCENARIO_REGISTER = 'register';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = ['email', 'password'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'on' => self::SCENARIO_REGISTER, 'message' => 'Обязательное поле'],
            [['status'], 'integer'],
            [['created_at', 'updated_at', 'last_seen'], 'safe'],
            [['email'], 'string', 'max' => 30],
            [['email'], 'email'],
            [['username', 'password_hash', 'password_reset_token', 'last_ip'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAttribute('auth_key') == $authKey;
    }

    /** @inheritdoc */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /** @inheritdoc */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /** @inheritdoc */
    public function getAuthKey()
    {
        return '';
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id , 'status' => self::STATUS_ACTIVE ]);
    }

    public function validatePassword($password)
    {
        if(empty($this->salt) && strlen($this->password_hash)==32) {
            return (md5($password) == $this->password_hash);
        }elseif(!empty($this->salt) && strlen($this->password_hash)==32){
            return (md5($this->salt.$password) == $this->password_hash);
        }
        return Password::validate($password, $this->password_hash );
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE  => \Yii::t('app','status active'),
            self::STATUS_INACTIVE => \Yii::t('app','status inactive'),
        ];
    }

    public function updateLastSeen()
    {
        $this->last_seen = date('Y-m-d H:i:s');
        $this->save(true, ['last_seen']);
    }
}
