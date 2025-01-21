<?php

use app\models\Property;
use app\models\User;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_property}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%property}}`
 */
class m250120_115440_create_junction_table_for_user_and_property_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_property', [
            'user_id' => $this->integer(),
            'property_id' => $this->integer(),
            'ownership_percentage' => $this->float(2),
            'PRIMARY KEY(user_id, property_id)',
        ]);

        $this->createIndex(
            'idx-user_property-user_id',
            'user_property',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_property-user_id',
            'user_property',
            'user_id',
            User::tableName(),
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_property-property_id',
            'user_property',
            'property_id'
        );

        $this->addForeignKey(
            'fk-user_property-property_id',
            'user_property',
            'property_id',
            Property::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_property');
    }
}
