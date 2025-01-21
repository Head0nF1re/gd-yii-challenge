<?php

namespace app\commands;

use app\constants\PropertyStatus;
use app\constants\UserStatus;
use app\models\Property;
use app\models\User;
use app\models\UserProperty;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{
    public function actionIndex()
    {
        // Basic seeder setup

        $user = new User();
        $user->scenario = User::SCENARIO_REGISTER;

        $user->username = 'GD';
        $user->email = 'test@gmail.com';
        $user->password = Yii::$app->security->generatePasswordHash('test1234');
        $user->phone_number = '+351910000000';
        $user->postal_code = '5000-400';
        $user->locality = 'Somewhere';
        $user->nif = 123456789;
        $user->nss = 12345678999;
        $user->nifap = 123456;
        $user->status = UserStatus::Active;

        $user->save();

        $lastKey = array_key_last(PropertyStatus::getValuesWithNames());

        /** @var \Faker\Generator $faker */
        $faker = \Faker\Factory::create('pt_PT');

        $linkUserProperties = [];
        $properties = [];
        for ($i=1; $i <= 20; $i++) { 
            $property = new Property();
            $property->id = $i;
            $property->name = $faker->unique->text(20);
            $property->latitude = $faker->randomFloat(nbMaxDecimals: 2, min: -90, max: 90);
            $property->longitude = $faker->randomFloat(nbMaxDecimals: 2, min: -180, max: 180);
            $property->area = $faker->randomNumber();
            $property->plantation_type = $faker->word();
            $property->plantation_units = $faker->randomNumber();
            $property->plantation_lines = $faker->randomNumber();
            $property->plantation_unit_fails = $faker->randomNumber();
            $property->plantation_status = $faker->numberBetween(1, $lastKey);
            $property->altitude = $faker->randomNumber(nbDigits: 2);
            $property->declive = $faker->randomNumber(nbDigits: 2);
            $property->created_at = date('c');
            $property->updated_at = date('c');

            $linkUserProperty = new UserProperty();
            $linkUserProperty->user_id = $user->id;
            $linkUserProperty->property_id = $property->id;

            $properties[] = $property->toArray();
            $linkUserProperties[] = $linkUserProperty->toArray();
        }
        
        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                Property::tableName(),
                [
                    'id',
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
                    'created_at',
                    'updated_at',
                ],
                $properties
            )->execute();

        Yii::$app->db
        ->createCommand()
            ->batchInsert(
                UserProperty::tableName(),
                [
                    'user_id',
                    'property_id',
                ],
                $linkUserProperties
            )->execute();

        ExitCode::OK;
    }
}
