<?php

use common\models\User;
use yii\db\Migration;

class m160910_182952_initSuper extends Migration
{
    public function up()
    {
        $adminUser = new User([
            'username' => "kuncheng",
            'email' => "251949141@qq.com",
            'password' => "kuncheng123",
        ]);
        $adminUser->generateAuthKey();

        if (!$adminUser->save()) {
            throw new \yii\console\Exception('Error when creating admin user.');
        }
    }

    public function down()
    {
        echo "m160910_182952_initSuper cannot be reverted.\n";

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
