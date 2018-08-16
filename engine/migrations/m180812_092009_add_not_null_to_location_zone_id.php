<?php

use yii\db\Migration;

/**
 * Class m180812_092009_add_not_null_to_location_zone_id
 */
class m180812_092009_add_not_null_to_location_zone_id extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%location}}', 'zone_id', $this->integer()->null());
    }

    public function down()
    {
        echo "m180812_092009_add_not_null_to_location_zone_id cannot be reverted.\n";

        $this->alterColumn('{{%location}}', 'zone_id', $this->integer()->notNull());
    }
}
