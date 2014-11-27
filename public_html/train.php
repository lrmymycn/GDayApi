<?php
require '../bootstrap.php';

$trainTime = new \GDay\Library\Train\TimeTable;
$timeTable = $trainTime->getNextTrain();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Next Train</title>
</head>
<body>
    <p>Rhodes next train (FROM CITY): <?php echo $timeTable['arrive_time'] ?></p>
</body>
</html>



