<?php

use common\models\User;
use yii\db\Migration;

class m161102_090140_addAdmin extends Migration
{
    public function up()
    {
        $adminUser = new User([
            'username' => "bioderma",
            'email' => "bioderma123@qq.com",
            'password' => "bioderma123",
        ]);
        $adminUser->generateAuthKey();

        if (!$adminUser->save()) {
            throw new \yii\console\Exception('Error when creating admin user.');
        }
    }

    public function down()
    {
        echo "m161102_090140_addAdmin cannot be reverted.\n";

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
