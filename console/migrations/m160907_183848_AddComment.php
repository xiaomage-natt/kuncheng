<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160907_183848_AddComment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //用户
        $this->createTable('{{%comments}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => $this->integer()->null(),
            'day' => $this->date()->null(),
            'name' => $this->string(64)->null(),
            'mobile' => $this->string(16)->null(),
            'content' => $this->string(256)->null(),
            'star' => $this->integer()->defaultValue(0),

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1 COMMENT "状态"',
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NULL COMMENT "更新时间"',
        ], $tableOptions);

        $this->createIndex('idxUserId', '{{%comments}}', 'user_id', true);
        $this->createIndex('idxDay', '{{%comments}}', 'day', true);
    }

    public function down()
    {
        echo "m160907_183848_AddComment cannot be reverted.\n";

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
