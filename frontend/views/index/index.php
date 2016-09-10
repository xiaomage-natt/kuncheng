<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/9/8
 * Time: 下午10:57
 */
use yii\helpers\Url;


?>

<div class="page-index">
    <div class="redirect-back"></div>
    <div class="activity-rule"></div>

    <div class="button-container">
        <div class="section">
            <a href="<?= Url::to(['wish-list']) ?>" class="button"><span>心愿墙</span></a>
        </div>
        <div class="section">
            <a href="<?= Url::to(['my-wish']) ?>" class="button"><span>我的心愿</span></a>
            <a href="<?= Url::to(['reward-list']) ?>" class="button"><span>获奖心愿</span></a>
        </div>
    </div>
</div>
