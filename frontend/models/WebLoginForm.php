<?php
namespace frontend\models;

use common\models\base\Accounts;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class WebLoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;
    public $authType = "web";


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->getAuthToken($this->authType))) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return Users|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            /** @var Accounts $accounts */
            $accounts = Accounts::find()->where(['auth_type' => $this->authType, 'auth_uid' => $this->username])->one();
            $this->_user = $accounts ? Users::find()->where(['id' => $accounts->user_id])->one() : null;
        }

        return $this->_user;
    }
}
