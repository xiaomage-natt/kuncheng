<?php
/* @var $this \yii\web\View */
?>

<div class="page-wish-list">
    <div class="redirect-back"></div>
    <div class="activity-rule"></div>
    <h3 class="banner-content">心愿墙</h3>

    <div class="wish-container">
        <div class="header" id="tab-container">
            <div class="tab active left" data-type="star">
                <span class="con">最多“赞”</span>
            </div>
            <div class="tab right" data-type="new">
                <span class="con">最新“说”</span>
            </div>
        </div>
        <div class="body" id="wish-list" data-url="<?= \yii\helpers\Url::to(['wishes']) ?>"
             data-star-url="<?= \yii\helpers\Url::to(['star']) ?>">

        </div>
    </div>
</div>
