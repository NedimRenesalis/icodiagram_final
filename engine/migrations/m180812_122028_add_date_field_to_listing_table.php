<?php

use yii\db\Migration;

/**
 * Class m180812_122028_add_date_field_to_listing_table
 */
class m180812_122028_add_date_field_to_listing_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%listing}}', 'active_from_date', $this->dateTime()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%listing}}', 'active_from_date');
    }
}
