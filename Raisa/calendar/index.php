<html lang="nl">
<head>
    <link href="calendar.css" type="text/css" rel="stylesheet" />
    <title></title>
</head>
<body>
<?php
include 'calendar.php';

$calendar = new Calendar();

echo $calendar->show();
?>
</body>
</html>