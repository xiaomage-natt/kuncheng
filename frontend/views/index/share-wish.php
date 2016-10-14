<?php
/* @var $this \yii\web\View */
/* @var $model \common\models\base\Wishes */
use yii\helpers\Url;

?>

<div class="page-my-wish">
    <a class="redirect-back" href="<?= Url::to(['index']) ?>"></a>
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
            <div class="middle num-counter"
                 data-star-url="<?= \yii\helpers\Url::to(['star']) ?>" data-id="<?= $model->id ?>">
                <span class="good"></span><span class="num"><?= $model->star ?></span>
            </div>
        </div>
        <div class="section-3">
            <a href="javascript:void(0);" class="button" id="share-button" data-id="心愿加速" data-target="statistics"><span>心愿加速</span></a>
        </div>
    </div>
</div>
<div class="share-overflow">
    <div class="content">
        <p>暖暖内涵光，心愿闪闪亮。</p>
        <p>加速你的心愿吧！</p>
    </div>
</div>