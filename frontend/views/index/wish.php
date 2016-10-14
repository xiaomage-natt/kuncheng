<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/9/10
 * Time: 下午2:53
 */
use yii\helpers\Url;

?>

<div class="page-wish">
    <a class="redirect-back" href="<?= Url::to(['index']) ?>"></a>
    <div class="activity-rule"></div>
    <h3 class="banner-content">我的心愿</h3>

    <div class="wish-container">
        <div class="header">
            <p>请写下您的心愿</p>
            <p>*心愿请不要超过50个字(含标点)以及特殊字符。</p>
        </div>
        <div class="body">
            <div class="input-group">
                <textarea name="content"></textarea>
            </div>
            <div class="input-group">
                <label for="name">请留下姓名</label>
                <input name="name" id="name" type="text"  data-target="statistics" data-id="请留下姓名">
            </div>
            <div class="input-group">
                <label for="mobile">请留下电话</label>
                <input name="mobile" id="mobile" type="number"  data-target="statistics" data-id="请留下电话">
            </div>
            <div class="input-group">
                <a href="" class="button submit" id="submit" data-url="<?= Url::to(['submit-wish']) ?>"><span>提交心愿</span></a>
            </div>
        </div>
    </div>
</div>
