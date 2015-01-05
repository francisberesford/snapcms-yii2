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
/*
CREATE TABLE `snap_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `mime_type` varchar(45) DEFAULT NULL,
  `extension` varchar(45) DEFAULT NULL,
  `is_public` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
 
 */
    }

    public function down()
    {
        echo "m150105_083708_create_media_table cannot be reverted.\n";

        return false;
    }
}
