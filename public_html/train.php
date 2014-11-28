<?php
require '../bootstrap.php';

$trainTime = new \GDay\Library\Train\TimeTable;
$timeTable = $trainTime->getNextTrain();

$arriveTime = strtotime($timeTable['arrive_time']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Next Train</title>

    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="keywords" content="">
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
                <div id="intro-author">NEXT TRAIN</div>
                <!-- author end -->
                <!-- title -->
                <div id="intro-title">RHODES<span class="to">TO</span><span>EPPING</span></div>
                <!-- title end -->

                <!-- countdown -->
                <div id="countdown-wrapper">
                    <div id="countdown-wrap">
                        <ul id="countdown">
                            <li><span class="hours">00</span>
                                <p class="timeRefHours">hours</p>
                            </li>
                            <li><span class="minutes">14</span>
                                <p class="timeRefMinutes">minutes</p>
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
                <div><span class="intro-line"></span><span class="intro-intro">3 MINS LATE</span></div>
                <!-- intro line end -->

            </div>
        </div>
        <!-- intro end -->
    </div>
</div>
<!-- hours wrapper end -->

<!-- scripts -->
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/supersized.3.2.7.min.js"></script>
<script type="text/javascript" src="js/hours.js"></script>
</body>
</html>



