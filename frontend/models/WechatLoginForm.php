<?php
namespace frontend\models;

use common\models\base\Accounts;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class WechatLoginForm extends Model
{
    /**
     * @var
     */
    public $openid;

    /**
     * @var
     */
    private $_user;

    /**
     * @var string
     */
    public $authType = "wechat";


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['openid'], 'required'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);
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
            $accounts = Accounts::find()->where(['auth_type' => $this->authType, 'auth_uid' => $this->openid])->one();
            $this->_user = $accounts ? Users::find()->where(['id' => $accounts->user_id])->one() : null;
        }
        return $this->_user;
    }
}
