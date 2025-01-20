<?php

namespace app\models;

use app\constants\UserStatus;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $phone_number;
    public $postal_code;
    public $locality;
    public $nif;
    public $nss;
    public $nifap;

    public function attributeLabels()
    {
        return [
            'username' => 'Full Name',
            'nif' => 'NIF',
            'nss' => 'NSS',
            'nifap' => 'NIFAP',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // Can't use it on the password regex, the double-quotes will output bad JS regex
        // $minPassword = Yii::$app->params['user.passwordMinLength'];

        return [
            [
                ['username', 'email'], 
                'trim'
            ],
            [
                ['username', 'email', 'password', 'phone_number', 'postal_code', 'locality', 'nif', 'nss', 'nifap'], 
                'required'
            ],
            ['username', 'string', 'length' => [2, 255]],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

            // ascii and max limit because of bcrypt limitation
            ['password', 'match', 'pattern' => '/^[\x00-\xFF]{8,72}$/'], 

            // In a realistic scenario, we would use something like https://github.com/giggsey/libphonenumber-for-php and send an SMS code
            ['phone_number', 'match', 'pattern' => '/^\+3519[1,2,3,6]\d{7}$/'], 
            ['phone_number', 'unique', 'targetClass' => User::class, 'message' => 'This phone number has already been taken.'],

            ['postal_code', 'match', 'pattern' => '/^[1-9]\d{3}-\d{3}$/'],
            ['locality', 'string', 'length' => [2, 255]],

            // simulating only for individual fiscal entities (persons)
            ['nif', 'match', 'pattern' => '/^[1-3]\d{8}$/'],
            ['nif', 'unique', 'targetClass' => User::class, 'message' => 'This nif has already been taken.'],

            ['nss', 'match', 'pattern' => '/^\d{11}$/'],
            ['nss', 'unique', 'targetClass' => User::class, 'message' => 'This nss has already been taken.'],

            ['nifap', 'match', 'pattern' => '/^\d{6}$/'],
            ['nifap', 'unique', 'targetClass' => User::class, 'message' => 'This nifap has already been taken.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->scenario = User::SCENARIO_REGISTER;
        $user->attributes = Yii::$app->request->post('SignupForm');

        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->generateAuthKey();
        $user->status = UserStatus::PendingEmailConfirmation;

        return $user->save();
    }
}