<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m161031_131208_addBeidemei extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%beidema_form}}', [
            'id' => Schema::TYPE_PK,
            'name' => $this->string(64)->null()->comment("姓名"),
            'mobile' => $this->string(16)->null()->comment("手机号"),
            'address' => $this->string(256)->null()->comment("地址"),
            'marry' => $this->string(64)->null()->comment("婚姻状况"),
            'child' => $this->string(64)->null()->comment("孩子年龄"),

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1 COMMENT "状态"',
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NULL COMMENT "更新时间"',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m161031_131208_addBeidemei cannot be reverted.\n";

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
