<?php
namespace frontend\models;

use common\models\base\Accounts;
use yii\base\Model;

/**
 * Signup form
 */
class WebSignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'validateUsername'],


            ['password', 'required'],
            ['password', 'string', 'min' => 6],


        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (Accounts::find()->where(['auth_type' => 'web', 'auth_uid' => $this->username])->one()) {
                $this->addError($attribute, '用户已经存在.');
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return Users|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new Users();
        if (!$user->save()) {
            return null;
        } else {
            $accounts = new Accounts();
            $accounts->auth_type = 'web';
            $accounts->auth_uid = $this->username;
            $accounts->auth_token = \Yii::$app->security->generatePasswordHash($this->password);
            $accounts->user_id = $user->id;
            return $accounts->save() ? $user : null;
        }
    }
}
