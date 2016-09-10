/**
 * Created by air on 16/9/9.
 */

/*
 *
 * 自适应调整
 * 适配mata分辨率以及尺寸
 *
 *******************************/
var phoneWidth = parseInt(window.screen.width);

var phoneScale = phoneWidth / 640;
var ua = navigator.userAgent;
if (/Android (\d+\.\d+)/.test(ua)) {
    var version = parseFloat(RegExp.$1);

    var chromeVersion = 0;
    if(/Chrome\/(\d+\.\d+)/.test(ua)) {
        chromeVersion = parseFloat(RegExp.$1);
    }
    // andriod 2.3
    if (version > 2.3 && chromeVersion < 40.0) {
        document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
        // andriod 2.3以上
    }
    //else if (/(iPad|iPhone|iPod)/g.test(ua)) {
    //    document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
    //}
    else {
        document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
    }
    // 其他系统
} else {
    document.write('<meta name="viewport" content="width=640, user-scalable=no,target-densitydpi=device-dpi">');
}