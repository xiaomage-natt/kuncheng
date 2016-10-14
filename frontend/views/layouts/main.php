<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\helpers\CommonHelper;
use common\models\base\Accounts;
use common\models\base\Wishes;
use frontend\assets\ScreenAsset;
use yii\helpers\Html;
use frontend\assets\AppAsset;

ScreenAsset::register($this);
AppAsset::register($this);

/** @var Wishes $wishes */
$wishes = Wishes::find()->where(['user_id' => Yii::$app->getUser()->id])->andWhere(['IN', 'status', [Wishes::ACTIVE]])->orderBy('created_at desc')->one();

if(!Yii::$app->getUser()->getIsGuest()) {
    /** @var Accounts $accounts */
    $accounts = Accounts::find()->where(['user_id' => Yii::$app->getUser()->id])->one();
    $openid = $accounts->auth_uid;
} else {
    $openid = '';
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="openid" content="<?= $openid ?>">
    <?php
    if ($wishes) {
        ?>
        <meta name="name" content="<?= $wishes->name ?>">
        <meta name="mobile" content="<?= $wishes->mobile ?>">
        <?php
    } else {
        ?>
        <meta name="name" content="">
        <meta name="mobile" content="">
    <?php
    }
    ?>
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
    var _title = "暖暖内涵光，照亮他人的心愿。";
    <?php
    if ($wishes) {
        $url = Yii::$app->urlManager->createAbsoluteUrl(['/index/share-wish', 'id' => $wishes->id]);
    } else {
        $url = Yii::$app->urlManager->createAbsoluteUrl(['index/index']);
    }
    ?>
    var _link = "<?= $url ?>";
    var _imgUrl = "http://kuncheng.foolbaicai.com/resource/images/wap/share.jpeg";
    var _desc = "TA的心愿需要你的助力";
    if (typeof(wx) != "undefined") {
        wx.config(<?= json_encode(\common\helpers\WechatHelper::jsApiSignature()) ?>);

        wx.error(function (res) {
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


<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//webtracking.sysmart.cn/";
        _paq.push(['setTrackerUrl', u+'webtracking.php']);
        _paq.push(['setSiteId', 10]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'webtracking.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<img style="display:none;" src="http://218.244.145.245/mlog.php?campaign_id=kunchengxuyuan&fromkol=<?php echo Yii::$app->request->get('fromkol'); ?>"/>
<noscript><p><img src="//webtracking.sysmart.cn/webtracking.php?idsite=10" style="border:0;" alt="" /></p></noscript>
</body>
</html>
<?php $this->endPage() ?>
