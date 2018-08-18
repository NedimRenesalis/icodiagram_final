<?php

use yii\db\Migration;

/**
 * Class m180818_101638_subscribe_table
 */
class m180818_101638_subscribe_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%subscribers}}', [
            'user_id'               => $this->primaryKey(),
            'email'                 => $this->string(100)->notNull(),
            'created_at'            => $this->dateTime()->notNull(),
            'updated_at'            => $this->dateTime()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%subscribers}}');
    }
}
