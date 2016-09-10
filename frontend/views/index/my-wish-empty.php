<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

?>

<div class="page-my-wish">
    <div class="redirect-back"></div>
    <div class="activity-rule"></div>
    <h3 class="banner-content">我的心愿</h3>

    <div class="my-wish-empty-container">
        <div class="section-1">
            <p>你的愿望未通过审核,</p>
            <p>请重新填写你的愿望哦!</p>
        </div>
        <div class="section-2">
            <a href="<?= Url::to(['wish']) ?>" class="button"><span>重新许愿</span></a>
        </div>
    </div>
</div>