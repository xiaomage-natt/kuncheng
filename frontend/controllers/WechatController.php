<?php
namespace frontend\controllers;

use common\models\base\Accounts;
use common\models\base\UserProfiles;
use common\models\base\Users;
use frontend\models\WechatLoginForm;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Site controller
 */
class WechatController extends Controller
{

    public $enableCsrfValidation = false;

    protected $auth_type = 'wechat';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'common\web\ErrorAction',
            ],
        ];
    }


    public function actionLogin($redirect_uri)
    {
        Yii::$app->session->set('__DIRECT_URI__', $redirect_uri);
        return $this->redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . Yii::$app->params["wechat"]["appid"] . "&redirect_uri=" . urlencode(Yii::$app->urlManager->createAbsoluteUrl(['/wechat/login-callback'])) . "&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect");
    }


    public function actionLoginCallback()
    {
        $openid = null;
        $access_token = null;
        if (!isset($_REQUEST["code"])) {
            throw new HttpException(500, "微信授权失败,请稍后再试");
        } else {
            $response = \Requests::get('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . Yii::$app->params["wechat"]["appid"] . '&secret=' . Yii::$app->params["wechat"]["secret"] . '&code=' . $_REQUEST["code"] . '&grant_type=authorization_code');
            $response = json_decode($response->body, true);
            if (!isset($response["openid"]) || !isset($response['access_token'])) {
                throw new HttpException(500, "微信授权失败,请稍后再试");
            }
            $openid = $response["openid"];
            $access_token = $response['access_token'];
        }


        $response = \Requests::get("https://api.weixin.qq.com/sns/userinfo?access_token=" . $access_token . "&openid=" . $openid);
        $response = $response->body;
        $response = json_decode($response, true);
        if (isset($response['errcode']) && $response['errcode'] != 0) {
            throw new HttpException(500, "微信登陆失败");
        }

        /** @var Accounts $accounts */
        $accounts = Accounts::find()->where(['auth_type' => $this->auth_type, 'auth_uid' => $response['openid']])->one();
        if (!$accounts) {
            $users = new Users();
//            $users->name = $response['nickname'];
            $users->save();

            $accounts = new Accounts();
            $accounts->user_id = $users->id;
            $accounts->auth_type = $this->auth_type;
            $accounts->auth_uid = $response['openid'];
            $accounts->auth_token = $response['openid'];
            $accounts->save();


        } else {
            /** @var Users $users */
            $users = Users::find()->where(['id' => $accounts->user_id])->one();
        }
        /** @var UserProfiles $userProfiles */
        $userProfiles = UserProfiles::find()->where(['user_id' => $users->id])->one();
        if (!$userProfiles) {
            $userProfiles = new UserProfiles();
        }
        $userProfiles->user_id = $users->id;;
        $userProfiles->gender = (string)$response['sex'];
        $userProfiles->province = (string)$response['province'];
        $userProfiles->city = (string)$response['city'];
        $userProfiles->thumb = (string)$response['headimgurl'];
//        $userProfiles->nickname = (string)$response['nickname'];
        $userProfiles->save();

        $wechatLoginForm = new WechatLoginForm();
        $wechatLoginForm->load([
            'openid' => $response['openid'],
        ], '');
        if ($wechatLoginForm->login()) {
            return $this->redirect(Yii::$app->session->get("__DIRECT_URI__"));
        } else {
            throw new HttpException(500, "微信登陆失败");
        }
    }
}
