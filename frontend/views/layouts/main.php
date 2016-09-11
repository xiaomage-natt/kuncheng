<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\helpers\CommonHelper;
use frontend\assets\ScreenAsset;
use yii\helpers\Html;
use frontend\assets\AppAsset;

ScreenAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container">
    <?= $content ?>
</div>

<?php

?>
<script>
    var _title = "微信活动分享标题";
    var _link = "http://kuncheng.foolbaicai.com";
    var _imgUrl = "http://kuncheng.foolbaicai.com/resource/images/wap/rule_logo.png";
    var _desc = "微信分享简介微信分享简介微信分享简介微信分享简介微信分享简介";
    if (typeof(wx) != "undefined") {
        wx.config(<?= json_encode(\common\helpers\WechatHelper::jsApiSignature()) ?>);

        wx.error(function(res){
            alert(JSON.stringify(res));
        });
        function wechatShare() {
            wx.onMenuShareTimeline({
                title: _title, // 分享标题
                link: _link, // 分享链接
                imgUrl: _imgUrl, // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    if (typeof(eval(share)) == "function") {
                        var to_platform = "TIMELINE";
                        share(to_platform);
                    }
                },
                cancel: function () {
                    if (typeof(eval(shareCancel)) == "function") {
                        shareCancel.call(this, "TIMELINE");
                    }
                }
            });
            wx.onMenuShareAppMessage({
                title: _title, // 分享标题
                desc: _desc, // 分享描述
                link: _link, // 分享链接
                imgUrl: _imgUrl, // 分享图标
                type: 'link', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                    if (typeof(eval(share)) == "function") {
                        var to_platform = "APPMESSAGE";
                        share(to_platform);
                    }
                },
                cancel: function () {
                    if (typeof(eval(shareCancel)) == "function") {
                        shareCancel.call(this, "APPMESSAGE");
                    }
                }
            });

            wx.onMenuShareQQ({
                title: _title, // 分享标题
                desc: _desc, // 分享描述
                link: _link, // 分享链接
                imgUrl: _imgUrl, // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    if (typeof(eval(share)) == "function") {
                        var to_platform = "QQ";
                        share(to_platform);
                    }
                },
                cancel: function () {
                    if (typeof(eval(shareCancel)) == "function") {
                        shareCancel.call(this, "QQ");
                    }
                }
            });

            wx.onMenuShareWeibo({
                title: _title, // 分享标题
                desc: _desc, // 分享描述
                link: _link, // 分享链接
                imgUrl: _imgUrl, // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    if (typeof(eval(share)) == "function") {
                        var to_platform = "WEIBO";
                        share(to_platform);
                    }
                },
                cancel: function () {
                    if (typeof(eval(shareCancel)) == "function") {
                        shareCancel.call(this, "WEIBO");
                    }
                }
            });
        }

        wx.ready(function () {
            wechatShare();
        });
    }
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
