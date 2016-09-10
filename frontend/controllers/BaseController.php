<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/8/16
 * Time: 下午11:10
 */

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class BaseController
 * @package frontend\controllers
 */
class BaseController extends Controller
{
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

    /**
     * @param $error
     * @return string
     */
    public function parseError($error)
    {
        if (is_array($error)) {
            $msg = [];
            foreach ($error as $item) {
                $msg[] = implode(",", $item);
            }
            return implode(",", $msg);
        } else {
            return "请求错误";
        }
    }
}