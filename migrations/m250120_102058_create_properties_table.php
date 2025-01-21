<?php

use app\models\Property;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%properties}}`.
 */
class m250120_102058_create_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = Property::tableName();

        $this->createTable($tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            // 'location' => 'GEOGRAPHY(Point) NOT NULL',
            'latitude' => $this->float()->notNull(),
            'longitude' => $this->float()->notNull(),
            'area' => $this->bigInteger()->notNull(),
            'plantation_type' => $this->string()->notNull(),
            'plantation_units' => $this->integer()->notNull(),
            'plantation_lines' => $this->integer()->notNull(),
            'plantation_unit_fails' => $this->integer()->notNull(),
            'plantation_status' => $this->tinyInteger()->notNull(),
            'altitude' => $this->integer(),
            'declive' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $this->createIndex(
            "idx-$tableName-name",
            $tableName,
            'name'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Property::tableName());
    }
}
