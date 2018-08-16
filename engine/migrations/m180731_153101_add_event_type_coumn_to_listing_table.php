<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://www.easyads.io
 * @copyright  2017 EasyAds (https://www.easyads.io)
 * @license    https://www.easyads.io
 * @since      1.3
 */

use yii\db\Migration;

/**
 * Class m180731_153101_add_event_type_coumn_to_listing_table
 */
class m180731_153101_add_event_type_coumn_to_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%listing}}', 'type', 'TINYINT(5) NOT NULL DEFAULT \'1\' AFTER status');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%listing}}', 'type');
    }
}