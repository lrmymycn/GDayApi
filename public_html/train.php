<?php
require '../bootstrap.php';

$trainTime = new \GDay\Library\Train\TimeTable;
<<<<<<< HEAD
$trainTime->updateTimeTable();
=======
$timeTable = $trainTime->getNextTrain();
?>

Rhodes next train (FROM CITY): <?php echo $timeTable['arrive_time'] ?>
>>>>>>> FETCH_HEAD
