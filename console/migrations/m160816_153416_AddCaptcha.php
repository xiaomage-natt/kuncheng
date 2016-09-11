<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160816_153416_AddCaptcha extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //用户
        $this->createTable('{{%users}}', [
            'id' => Schema::TYPE_PK,
            'name' => $this->string(64)->null(),
            'mobile' => $this->string(64)->null(),

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1 COMMENT "状态"',
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NULL COMMENT "更新时间"',
        ], $tableOptions);

        $this->createIndex('idxMobile', '{{%users}}', 'mobile');

        $this->createTable('{{%accounts}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => $this->integer()->null(),
            'auth_type' => $this->string()->defaultValue("wechat")->unique(),
            'auth_uid' => $this->string(64)->notNull()->unique(),
            'auth_token' => $this->string(256)->null(),

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1 COMMENT "状态"',
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NULL COMMENT "更新时间"',
        ], $tableOptions);

        $this->createIndex('idxUserId', '{{%accounts}}', 'user_id');
        $this->createIndex('idxAuthUid', '{{%accounts}}', ['auth_type', 'auth_uid'], false);


        $this->createTable('{{%user_profiles}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => $this->integer()->null(),
            'nickname' => $this->string(32)->null(),
            'gender' => $this->string(8)->null(),
            'province' => $this->string(32)->null(),
            'city' => $this->string(32)->null(),
            'thumb' => $this->string(256)->null(),

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1 COMMENT "状态"',
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NULL COMMENT "更新时间"',
        ], $tableOptions);
        $this->createIndex('idxUserId', '{{%user_profiles}}', 'user_id');
    }

    public function down()
    {
        echo "m160816_153416_AddCaptcha cannot be reverted.\n";
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
