<?php

use yii\db\Schema;

class m140627_043334_create_config_table extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%config}}',
            [
                'path' => Schema::TYPE_STRING . ' NOT NULL',
                'value' => Schema::TYPE_STRING,
                'PRIMARY KEY (path)',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%config}}');
    }
}
