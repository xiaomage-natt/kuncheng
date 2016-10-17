<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/9/8
 * Time: 下午11:23
 */
use yii\helpers\Url;

?>


<div class="page-reward-list">
    <a class="redirect-back" href="<?= Url::to(['index']) ?>"></a>
    <div class="activity-rule"></div>
    <h3 class="banner-content">获奖心愿</h3>

    <div class="reward-container">
        <div class="header">
            <p>恭喜以下获奖者，我们将在活动结束之后，</p>
            <p>与您取得联系，通知您领奖事宜！</p>
        </div>
        <div class="body">
            <?php
            /** @var \common\models\base\Wishes[] $models */
            foreach ($models as $k => $model) {
                ?>
                <div class="item">
                    <div class="left">
                        <div class="title">
                            <span
                                class="name"><?= \common\helpers\CommonHelper::format_name($model->name) ?></span><span
                                class="mobile"><?= \common\helpers\CommonHelper::format_mobile($model->mobile) ?></span>
                        </div>
                        <div class="content">
                            <?= $model->content ?>
                        </div>
                    </div>
                    <div class="right">
                        <span class="star"><?= $k + 1 ?></span>
                        <span class="good"></span>
                        <span class="num"><?= $model->star ?></span>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
</div>