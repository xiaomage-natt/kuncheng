<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/9/8
 * Time: 下午10:57
 */

namespace frontend\controllers;


use common\helpers\CommonHelper;
use common\models\base\Wishes;
use common\models\base\WishStars;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class IndexController extends Controller
{
    public function beforeAction($action)
    {
        if (CommonHelper::isWeixin() && Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(['/wechat/login', 'redirect_uri' => Yii::$app->request->absoluteUrl]);
        } else if (Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect(['/site/login']);
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionWish()
    {
        return $this->render("wish");
    }

    public function actionWishList()
    {

        return $this->render("wish-list");


    }

    public function actionMyWish()
    {
        /** @var Wishes $wishes */
        $wishes = Wishes::find()->where(['user_id' => Yii::$app->getUser()->id])->andWhere(['IN', 'status', [Wishes::ACTIVE, Wishes::CHECK]])->orderBy('id desc')->one();
        if (!$wishes) {
            return $this->redirect(['wish']);
        } else {

            if ($wishes->status == Wishes::ACTIVE) {
                return $this->render("my-wish", [
                    'model' => $wishes
                ]);
            } else {
                return $this->render("my-wish-empty");
            }
        }
    }

    public function actionRewardList()
    {
        $end_date = Yii::$app->params['end_date'];
        if (date("Y-m-d") > $end_date) {
            $query = Wishes::find()->andWhere(['IN', 'status', [Wishes::ACTIVE]])->limit(10);
            $query->orderBy('star desc');
            /** @var Wishes[] $wishes */
            $wishes = $query->all();
            return $this->render("reward-list", [
                'models' => $wishes
            ]);
        } else {
            return $this->render("reward-list-empty");
        }
    }


    /**
     * Returns the value of the specified query parameter.
     * This method returns the named parameter value from [[params]]. Null is returned if the value does not exist.
     * @param string $name the parameter name
     * @param string $defaultValue the value to be returned when the specified parameter does not exist in [[params]].
     * @return string the parameter value
     */
    protected function getQueryParam($name, $defaultValue = null)
    {
        $request = Yii::$app->getRequest();
        $params = $request instanceof Request ? $request->getQueryParams() : [];
        return isset($params[$name]) && is_scalar($params[$name]) ? $params[$name] : $defaultValue;
    }

    public function actionWishes()
    {
        $type = Yii::$app->request->get('type', 'star');

        $limit = 20;
        $page = $this->getQueryParam('page', 1);
        $query = Wishes::find()->andWhere(['IN', 'status', [Wishes::ACTIVE]])->offset(($page - 1) * $limit)->limit($limit);

        if ($type == 'star') {
            $query->orderBy('star desc');
        } else if ($type == 'new') {
            $query->orderBy('created_at desc');
        }
        /** @var Wishes[] $wishes */
        $wishes = $query->all();

        foreach ($wishes as $wish) {
            $wish->mobile = CommonHelper::format_mobile($wish->mobile);
            $wish->name = CommonHelper::format_name($wish->name);
        }
        return $this->returnJson($wishes);
    }

    public function actionSubmitWish()
    {
        if (date("Y-m-d") > Yii::$app->params['end_date']) {
            return $this->returnJson([], false, '活动已经结束');
        } else {

            /** @var Wishes $wishes */
            $wishes = Wishes::find()->where(['user_id' => Yii::$app->getUser()->id])->andWhere(['IN', 'status', [Wishes::ACTIVE, Wishes::CHECK]])->one();
            if (!$wishes) {
                $wishes = new Wishes();
                $wishes->load(Yii::$app->request->post(), '');
                $wishes->user_id = Yii::$app->getUser()->id;
                $wishes->day = date("Y-m-d");
                $wishes->status = Wishes::ACTIVE;

                if ($wishes->save()) {
                    return $this->returnJson([
                        'redirect_uri' => Url::to(['wish-list']),
                    ]);
                } else {
                    return $this->returnJson([], false, "创建失败请稍后再试!");
                }
            } else {
                return $this->returnJson([], false, "您已经许过愿了!");
            }
        }
    }

    public function actionStar()
    {
        $id = Yii::$app->request->post('id');

        /** @var Wishes $wishes */
        $wishes = Wishes::find()->where(['id' => $id])->one();
        if ($wishes) {

            if (date("Y-m-d") > Yii::$app->params['end_date']) {
                return $this->returnJson([], false, '活动已经结束');
            } else {
                $count = WishStars::find()->where(['user_id' => Yii::$app->getUser()->id, 'day' => date("Y-m-d")])->count();
                if ($count >= 3) {
                    return $this->returnJson([], false, '今天您投票的次数已用完，明天再来吧！');
                } else {
                    $wishStars = new WishStars();
                    $wishStars->user_id = Yii::$app->getUser()->id;
                    $wishStars->wish_id = $wishes->id;
                    $wishStars->day = date("Y-m-d");
                    if ($wishStars->save()) {
                        Wishes::updateAllCounters(['star' => 1], ['id' => $wishes->id]);
                        return $this->returnJson([]);
                    } else {
                        return $this->returnJson([], false, '操作失败');
                    }
                }
            }
        } else {
            return $this->returnJson([], false, '找不到该愿望');
        }
    }

    /**
     * @param null $data
     * @param bool $isSuccess
     * @param string $msg
     * @return array
     */
    public function returnJson($data = null, $isSuccess = true, $msg = "请求成功")
    {

        $data = [
            "code" => $isSuccess !== null && $isSuccess !== false && $isSuccess !== true ? $isSuccess : ($isSuccess ? 1 : 0),
            "msg" => $msg,
            "data" => $data === null ? [] : $data,
        ];

        $callback = Yii::$app->request->get("callback");
        Yii::$app->getResponse()->format =
            (is_null($callback)) ?
                Response::FORMAT_JSON :
                Response::FORMAT_JSONP;
        // return data
        return (is_null($callback)) ?
            $data :
            array(
                'data' => $data,
                'callback' => $callback
            );
    }
}