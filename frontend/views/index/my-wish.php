<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

?>

<div class="page-my-wish">
    <div class="redirect-back"></div>
    <div class="activity-rule"></div>
    <h3 class="banner-content">我的心愿</h3>

    <div class="my-wish-container">
        <div class="section-1">
            <div class="title">
                <span class="name">刘＊＊</span><span class="mobile">188＊＊＊＊000</span>
            </div>
            <div class="content">
                留言内容留言内容留言内容留言内容留言内容留言内容留言内容留言内容留言内容留言内容留言内容留言内容留
            </div>
        </div>
        <div class="section-2">
            <div class="middle">
                <span class="good"></span><span class="num">250</span>
            </div>
        </div>
        <div class="section-3">
            <a href="<?= Url::to(['wish-list']) ?>" class="button"><span>心愿加速</span></a>
        </div>
    </div>
</div>