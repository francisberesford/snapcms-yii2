<?php

use yii\db\Migration;

class m150929_080307_add_tmp_field_to_media extends Migration
{
    public function up()
    {
        $this->addColumn("{{%media}}", 'is_tmp', $this->boolean()->defaultValue(0));
    }

    public function down()
    {
        echo "m150929_080307_add_tmp_field_to_media cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
