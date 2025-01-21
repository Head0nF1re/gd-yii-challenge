<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Database fields:
 * 
 * @property int $id
 * @property string $name
 * @property float $latitude
 * @property float $longitude
 * @property int $area
 * @property string $plantation_type
 * @property int $plantation_units
 * @property int $plantation_lines
 * @property int $plantation_unit_fails
 * @property \app\constants\PropertyStatus  $plantation_status
 * @property int|null $altitude
 * @property float|null $declive
 * @property string $created_at
 * @property string $updated_at
 * 
 */
class Property extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    public static function tableName()
    {
        return 'properties';
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
            self::SCENARIO_CREATE => 
            [
                'name', 
                'latitude', 
                'longitude', 
                'area', 
                'plantation_type', 
                'plantation_units', 
                'plantation_lines', 
                'plantation_unit_fails', 
                'plantation_status', 
                'altitude',
                'declive',
            ],
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('user_property', ['property_id' => 'id']);
    }

}
