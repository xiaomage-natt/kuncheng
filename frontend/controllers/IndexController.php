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
        $wishes = Wishes::find()->where(['user_id' => Yii::$app->getUser()->id])->orderBy('created_at desc')->one();
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

    public function actionShareWish($id)
    {
        /** @var Wishes $wishes */
        $wishes = Wishes::find()->where(['id' => $id])->one();
        return $this->render("share-wish", [
            'model' => $wishes
        ]);
    }

    public function actionRewardList()
    {
        $end_date = Yii::$app->params['end_date'];
        if (date("Y-m-d") > $end_date) {
            $query = Wishes::find()
                ->select(['name,mobile,content,count(1) as star'])
                ->innerJoin("wish_stars", "wish_stars.wish_id=wishes.id and wish_stars.created_at<=:time", [':time' => date("Y-m-d 23:59:59", strtotime(Yii::$app->params['end_date']))])
                ->groupBy("wishes.id")
                ->andWhere(['IN', 'wishes.status', [Wishes::ACTIVE]])
                ->limit(10);
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

    public static $mingan = [
        "勃起", "操", "操逼", "操弄", "操死", "操我", "操穴", "插进插出", "插入", "插死你", "插穴", "大炮", "打炮", "奶子", "兽交", "强奸", "TMD", "你妈逼", "操你妈逼", "操你妈", "他妈的", "傻逼", "逼", "习近平", "李克强", "中南海", "毛泽东", "文化大革命", "四人帮", "中华民国", "台独", "藏独", "分裂", "偷渡", "尖阁列岛", "斯普拉特利群岛", "怕拉塞尔群岛", "北方四岛", "民族分裂"
    ];

    public function actionSubmitWish()
    {
        if (date("Y-m-d") > Yii::$app->params['end_date']) {
            return $this->returnJson([], false, '活动已经结束');
        } else {

            /** @var Wishes $wishes */
            $wishes = Wishes::find()->where(['user_id' => Yii::$app->getUser()->id])->orderBy("created_at desc")->one();
            if (!$wishes || $wishes->status != Wishes::ACTIVE) {
                $wishes = new Wishes();
                $wishes->load(Yii::$app->request->post(), '');
                $wishes->user_id = Yii::$app->getUser()->id;
                $wishes->day = date("Y-m-d");
                $wishes->status = Wishes::ACTIVE;

                foreach (self::$mingan as $item) {
                    if (strpos($wishes->content, $item) !== false) {
                        return $this->returnJson([], false, "您发布的内容包含敏感词汇,请修改后发布!");
                    }
                }

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

    public function actionStatistics()
    {
        $post = Yii::$app->request->post();
        $requests_Response = \Requests::post("http://218.244.145.245/api/contact/form?campaign_id=kunchengxuyuan&token=imtravelzoo", [], $post);
        echo $requests_Response->body;exit;
    }
}