<?php
require '../bootstrap.php';

$trainTime = new \GDay\Library\Train\TimeTable;
$timeTable = $trainTime->getNextTrain(1, \GDay\Infrastructure\Enum\TrainDirection::FromCity);

$arriveTime = strtotime($timeTable['arrive_time']);
$now = strtotime('now');
$internal = $arriveTime - $now;
$minutesToGo = ceil($internal / 60);
$hoursToGo = 0;
if($minutesToGo >= 60){
    $hoursToGo = floor($minutesToGo / 60);
    $hoursToGo = str_pad($hoursToGo, 2, '0', STR_PAD_LEFT);
    $minutesToGo = $minutesToGo % 60;
    $minutesToGo = str_pad($minutesToGo, 2, '0', STR_PAD_LEFT);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Next Train in Rhodes</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Catch Train">
    <link rel="apple-touch-icon" href="icon-60x60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icon-120x120.png">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- style -->
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
    <!-- style end -->
</head>
<body>


<!-- site loader -->
<div class="loader"></div>
<!-- site loader end -->


<!-- curtains -->
<div id="curtains"></div>
<!-- curtains end -->


<!-- shade -->
<div id="shade"></div>
<!-- shade end -->

<!-- social icons -->
<div class="social-icons-wrapper">
    <ul class="social-icons">
        <li><a href="#"><img src="images/social/twitter.png" alt="Twitter"></a></li>
        <li><a href="#"><img src="images/social/facebook.png" alt="Facebook"></a></li>
    </ul>
</div>
<!-- social icons end -->

<!-- hours wrapper -->
<div id="hours-wrapper">
    <div class="hours-wrapper">

        <!-- intro -->
        <div class="intro">
            <div class="introduction">

                <!-- author -->
                <div id="intro-author">NEXT TRAIN FROM</div>
                <!-- author end -->
                <!-- title -->
                <div id="intro-title">RHODES<span class="to">TO</span><span>EPPING</span></div>
                <!-- title end -->

				<div id="intro-author">WILL DEPART IN</div>
				
                <!-- countdown -->
                <div id="countdown-wrapper">
                    <div id="countdown-wrap">
                        <ul id="countdown">
                            <li><span class="hours"><?php echo $hoursToGo ?></span>
                                <p class="timeRefHours">hours</p>
                            </li>
                            <li><span class="minutes"><?php echo $minutesToGo ?></span>
                                <p class="timeRefMinutes">mins</p>
                            </li>
                            <li><span>at</span></li>
                            <li><span><?php echo date('h', $arriveTime) ?></span><span class="colon">:</span><span><?php echo date('i', $arriveTime) ?></span></span>
                            </li>
                            <li><span class="ampm"><?php echo date('A', $arriveTime) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- countdown end -->

                <!-- intro line -->
                <div><span class="intro-line"></span><span class="intro-intro"><?php echo $timeTable['delay'] ?> MINUTES LATE</span></div>
                <!-- intro line end -->

            </div>
        </div>
        <!-- intro end -->
    </div>
</div>
<!-- hours wrapper end -->

<div class="panel-button"><a href="#">Opposite Direction</a></div>

<!-- scripts -->
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/supersized.3.2.7.min.js"></script>
<script type="text/javascript">
    // supersized
    jQuery(function($){
        $.supersized({
            // Functionality
            slideshow               :   1,			// Slideshow on/off
            autoplay				:	1,			// Slideshow starts playing automatically
            start_slide             :   0,			// Start slide (0 is random)
            stop_loop				:	0,			// Pauses slideshow on last slide
            random					: 	1,			// Randomize slide order (Ignores start slide)
            slide_interval          :   3000,		// Length between transitions
            transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
            transition_speed		:	3000,		// Speed of transition
            new_window				:	1,			// Image links open in new window/tab
            pause_hover             :   0,			// Pause slideshow on hover
            keyboard_nav            :   1,			// Keyboard navigation on/off
            performance				:	2,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
            image_protect			:	1,			// Disables image dragging and right click with Javascript

            // Size || Position
            min_width		        :   0,			// Min width allowed (in pixels)
            min_height		        :   0,			// Min height allowed (in pixels)
            vertical_center         :   1,			// Vertically center background
            horizontal_center       :   1,			// Horizontally center background
            fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
            fit_portrait         	:   1,			// Portrait images will not exceed browser height
            fit_landscape			:   0,			// Landscape images will not exceed browser width

            // Components
            slide_links				:	'false',	// Individual links for each slide (Options: false, 'number', 'name', 'blank')
            thumb_links				:	1,			// Individual thumb links for each slide
            thumbnail_navigation    :   0,			// Thumbnail navigation
            slides 					:  	[			// Slideshow Images
                {image : 'images/background/1.jpg', title : '', thumb : '', url : ''},
                {image : 'images/background/2.jpg', title : '', thumb : '', url : ''},
                {image : 'images/background/4.jpg', title : '', thumb : '', url : ''}
            ]

        });
    });

    // site loader
    $(window).load(function() {
        $('.loader').fadeOut('slow');
    });

    var onBridgeReady = function () {
        var SHARE_IMG = 'http://gday.stagingserver.com.au/icon-120x120.png';

        WeixinJSBridge.call('hideToolbar');
        WeixinJSBridge.on('menu:share:appmessage', function (argv) {
            WeixinJSBridge.invoke('sendAppMessage', {
                "img_url": SHARE_IMG,
                "img_width": "120",
                "img_height": "120",
                "link": window.location.href,
                "desc": 'Next train from Rhodes to Epping will depart in 2 minutes',
                "title": ''
            }, function (res) {
                ;
            });
        });
        WeixinJSBridge.on('menu:share:timeline', function (argv) {
            WeixinJSBridge.invoke('shareTimeline', {
                "img_url": SHARE_IMG,
                "link": window.location.href,
                "desc": '',
                "title": 'Next train from Rhodes to Epping will depart in 2 minutes'
            }, function (res) {
                ;
            });
        });
    };
    if (document.addEventListener) {
        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
    } else if (document.attachEvent) {
        document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
    }
</script>
</body>
</html>



