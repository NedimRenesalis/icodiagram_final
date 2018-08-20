<?php

use yii\db\Migration;

/**
 * Class m180820_195612_add_new_remove_unnecessary_fileds_for_ad
 */
class m180820_195612_add_new_remove_unnecessary_fileds_for_ad extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('{{%listing}}', 'currency_id', $this->integer()->null());
        $this->alterColumn('{{%listing}}', 'price', $this->double()->null());
        $this->addColumn('{{%listing}}', 'youtube', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'token', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'pre_ico_price', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'ico_price', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'bonus', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'mvp_prototype', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'platform', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'accepting', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'minimum_investment', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'soft_cap', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'hard_cap', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'bounty', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'whitelist_kyc', $this->string(255)->null());
        $this->addColumn('{{%listing}}', 'restricted_areas', $this->string(255)->null());
    }

    public function down()
    {
        echo "m180820_195612_add_new_remove_unnecessary_fileds_for_ad cannot be reverted.\n";

        $this->alterColumn('{{%listing}}', 'currency_id', $this->integer()->notNull());
        $this->alterColumn('{{%listing}}', 'price', $this->double()->notNull());
        $this->dropColumn('{{%listing}}', 'youtube');
        $this->dropColumn('{{%listing}}', 'token');
        $this->dropColumn('{{%listing}}', 'pre_ico_price');
        $this->dropColumn('{{%listing}}', 'ico_price');
        $this->dropColumn('{{%listing}}', 'bonus');
        $this->dropColumn('{{%listing}}', 'mvp_prototype');
        $this->dropColumn('{{%listing}}', 'platform');
        $this->dropColumn('{{%listing}}', 'accepting');
        $this->dropColumn('{{%listing}}', 'minimum_investment');
        $this->dropColumn('{{%listing}}', 'soft_cap');
        $this->dropColumn('{{%listing}}', 'hard_cap');
        $this->dropColumn('{{%listing}}', 'bounty');
        $this->dropColumn('{{%listing}}', 'whitelist_kyc');
        $this->dropColumn('{{%listing}}', 'restricted_areas');
    }
}
