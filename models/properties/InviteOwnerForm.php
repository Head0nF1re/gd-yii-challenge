<?php

namespace app\models\properties;

use app\models\Property;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Create form
 */
class InviteOwnerForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'], 
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * Invite Co-Owner of the @see app\models\Property
     *
     * @return bool 
     */
    public function inviteOwner()
    {
        if (!$this->validate()) {
            return null;
        }

    }

}