<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Database fields:
 * 
 * @property int $user_id
 * @property int $property_id
 * @property float|null $ownership_percentage
 * 
 */
class UserProperty extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_property';
    }
}
