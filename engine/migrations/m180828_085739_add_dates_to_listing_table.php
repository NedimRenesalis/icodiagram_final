<?php

use yii\db\Migration;

/**
 * Class m180828_085739_add_dates_to_listing_table
 */
class m180828_085739_add_dates_to_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%listing}}', 'pre_ico_upcoming_from_date', $this->dateTime()->null());
        $this->addColumn('{{%listing}}', 'pre_ico_active_from_date', $this->dateTime()->null());
        $this->addColumn('{{%listing}}', 'ico_upcoming_from_date', $this->dateTime()->null());
        $this->addColumn('{{%listing}}', 'ico_active_from_date', $this->dateTime()->null());
        $this->dropColumn('{{%listing}}', 'active_from_date');
    }

    public function down()
    {
        $this->dropColumn('{{%listing}}', 'pre_ico_upcoming_from_date');
        $this->dropColumn('{{%listing}}', 'pre_ico_active_from_date');
        $this->dropColumn('{{%listing}}', 'ico_upcoming_from_date');
        $this->dropColumn('{{%listing}}', 'ico_active_from_date');
        $this->addColumn('{{%listing}}', 'active_from_date', $this->dateTime()->null());
    }
}