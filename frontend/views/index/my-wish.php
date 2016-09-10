<?php
/* @var $this \yii\web\View */
/* @var $model \common\models\base\Wishes */
use yii\helpers\Url;

?>

<div class="page-my-wish">
    <div class="redirect-back"></div>
    <div class="activity-rule"></div>
    <h3 class="banner-content">我的心愿</h3>

    <div class="my-wish-container">
        <div class="section-1">
            <div class="title">
                <span class="name"><?= \common\helpers\CommonHelper::format_name($model->name) ?></span><span class="mobile"><?= \common\helpers\CommonHelper::format_mobile($model->mobile) ?></span>
            </div>
            <div class="content">
                <?= $model->content ?>
            </div>
        </div>
        <div class="section-2">
            <div class="middle">
                <span class="good"></span><span class="num"><?= $model->star ?></span>
            </div>
        </div>
        <div class="section-3">
            <a href="<?= Url::to(['wish-list']) ?>" class="button"><span>心愿加速</span></a>
        </div>
    </div>
</div>