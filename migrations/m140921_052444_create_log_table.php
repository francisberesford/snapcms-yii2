<?php

use yii\db\Schema;

class m140921_052444_create_log_table extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%log}}',
            [
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'level' => Schema::TYPE_INTEGER,
                'category' => Schema::TYPE_STRING,
                'log_time' => Schema::TYPE_INTEGER,
                'prefix' => Schema::TYPE_TEXT,
                'message' => Schema::TYPE_TEXT,
                'INDEX idx_log_level (level)',
                'INDEX idx_log_category (category)',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%log}}');
    }
}
