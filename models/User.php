<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Database fields:
 * 
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $phone_number
 * @property string $postal_code
 * @property string $locality
 * @property int $nif
 * @property int $nss
 * @property int $nifap
 * @property \app\constants\UserStatus $status
 * @property string $auth_key
 * @property string $created_at
 * @property string $updated_at
 * 
 */
class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_REGISTER = 'register';

    public static function tableName()
    {
        return 'users';
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => fn() => date('c')
            ],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_REGISTER => 
            [
                'username', 
                'email', 
                '!password', 
                'phone_number', 
                'postal_code', 
                'locality', 
                'nif', 
                'nss', 
                'nifap',
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Not needed since we are using a statefull session
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return User::findOne(['email' => $email]) ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getProperties()
    {
        return $this->hasMany(Property::class, ['id' => 'property_id'])
            ->viaTable('user_property', ['user_id' => 'id']);
    }
}
