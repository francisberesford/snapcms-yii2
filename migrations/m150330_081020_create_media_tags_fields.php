<?php

use yii\db\Schema;
use yii\db\Migration;

class m150330_081020_create_media_tags_fields extends Migration
{
    public function up()
    {
        $this->createTable('{{%tags}}',
            [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING,
                'parent' => Schema::TYPE_INTEGER,
            ]
        );
        
        $this->createTable('{{%media_tags}}',
            [
                'media_id' => Schema::TYPE_INTEGER,
                'tag_id' => Schema::TYPE_INTEGER,
                'PRIMARY KEY (`media_id`,`tag_id`)',
            ]
        );
        
        $this->addForeignKey('fk_mtgs_media', '{{%media_tags}}', 'media_id', '{{%media}}', 'id');
        $this->addForeignKey('fk_mtgs_tags', '{{%media_tags}}', 'tag_id', '{{%tags}}', 'id');
        
        /*
         
        CREATE TABLE `snap_tags` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(45) DEFAULT NULL,
          `parent` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB

        CREATE TABLE `snap_media_tags` (
           `media_id` int(11) NOT NULL,
           `tag_id` int(11) NOT NULL,
            PRIMARY KEY (`media_id`,`tag_id`)
        ) ENGINE=InnoDB
         
         */
    }

    public function down()
    {
        echo "m150330_081020_create_media_tags_fields cannot be reverted.\n";

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
