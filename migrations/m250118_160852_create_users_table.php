<?php

use app\models\User;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m250118_160852_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = User::tableName();

        $this->createTable($tableName, 
        [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'phone_number' => $this->string()->notNull()->unique(),
            'postal_code' => $this->string()->notNull(),
            'locality' => $this->string()->notNull(),
            'nif' => $this->integer()->notNull()->unique(),
            'nss' => $this->bigInteger()->notNull()->unique(),
            'nifap' => $this->bigInteger()->notNull()->unique(),
            'status' => $this->tinyInteger()->notNull(),
            'auth_key' => $this->string()->unique(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $this->createIndex(
            "idx-$tableName-email",
            $tableName,
            'email'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(User::tableName());
    }
}
