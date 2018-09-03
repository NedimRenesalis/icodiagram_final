<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://www.easyads.io
 * @copyright  2017 EasyAds (https://www.easyads.io)
 * @license    https://www.easyads.io
 * @since      1.0
 */

use yii\db\Migration;

/**
 * Handles the creation of table `banner`.
 */
class m170516_143000_init_banner extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%banner}}', [
            'id'                   => $this->primaryKey(),
            'title'                => $this->string()->notNull()->unique(),
            'slug'                 => $this->string()->notNull()->unique(),
            'image'                => $this->string()->notNull(),
            'url'                  => $this->string()->notNull(),
            'client'               => $this->string(),
            'adspace'              => $this->string(),
            'visit_count'          => $this->integer(),
            'created_at'           => $this->date(),
            'updated_at'           => $this->date(),
            'valid_from'           => $this->date(),
            'valid_until'          => $this->date(),
            'comment'              => $this->text(),
            'active'               => $this->boolean()->defaultValue(true),
        ], $tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%banner}}');
    }
}
