<?php

use yii\db\Schema;
use yii\db\Migration;

class m150105_083708_create_media_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%media}}',
            [
                'id' => Schema::TYPE_PK,
                'title' => Schema::TYPE_STRING,
                'filename' => Schema::TYPE_STRING,
                'mime_type' => 'VARCHAR(45)',
                'extension' => 'VARCHAR(45)',
                'is_public' => Schema::TYPE_BOOLEAN,
                'created_at' => Schema::TYPE_DATETIME,
                'updated_at' => Schema::TYPE_DATETIME,
                'created_by' => Schema::TYPE_INTEGER,
                'updated_by' => Schema::TYPE_INTEGER,
            ]
        );
    }

    public function down()
    {
        echo "m150105_083708_create_media_table cannot be reverted.\n";

        return false;
    }
}
