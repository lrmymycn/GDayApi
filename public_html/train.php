<?php
require '../bootstrap.php';

$trainTime = new \GDay\Library\Train\TimeTable;
$timeTable = $trainTime->getNextTrain();
?>

    Rhodes next train (FROM CITY): <?php echo $timeTable['arrive_time'] ?>