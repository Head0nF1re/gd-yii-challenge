<?php

namespace app\models\properties;

use app\constants\PropertyStatus;
use app\models\Property;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Create form
 */
class CreatePropertyForm extends Model
{
    public $name;
    public $latitude;
    public $longitude;
    public $area;
    public $plantation_type;
    public $plantation_units;
    public $plantation_lines;
    public $plantation_unit_fails;
    public $plantation_status;
    public $altitude;
    public $declive;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'], 

            [
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
                ], 
                'required',
            ],

            ['name', 'string', 'length' => [1, 255]],
            ['name', 'unique', 'targetClass' => Property::class, 'filter' => function ($query) {

                /** @var \yii\db\Query $query */

                // Name is unique for the same user, can be duplicated for others
                $query
                    ->innerJoin('user_property', 'user_property.property_id = properties.id')
                    ->andWhere(['user_property.user_id' => Yii::$app->user->id]);
            }],    

            ['latitude', 'number', 'integerOnly' => false, 'min' => -90, 'max' => 90],
            ['longitude', 'number', 'integerOnly' => false, 'min' => -180, 'max' => 180],

            ['area', 'integer', 'min' => 1, 'max' => PHP_INT_MAX],
            ['altitude', 'integer', 'min' => -500, 'max' => 9000],
            ['declive', 'integer', 'min' => 0, 'max' => 100],

            ['plantation_type', 'string', 'length' => [1, 255]],
            ['plantation_status', 'in', 'range' => array_column(PropertyStatus::cases(), 'value')],

            [
                ['plantation_units', 'plantation_lines', 'plantation_unit_fails'], 
                'integer', 
                'min' => 0, 
                'max' => PHP_INT_MAX
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function createProperty()
    {
        if (!$this->validate()) {
            return null;
        }

        return Property::getDb()->transaction(function ($db) {
            $property = new Property();
            $property->scenario = Property::SCENARIO_CREATE;
            $property->attributes = Yii::$app->request->post('CreatePropertyForm');

            $property->save();
            $property->link(User::tableName(), Yii::$app->user->identity);

            return true;
        });
    }

}