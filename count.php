<?php
include "./db_worksheets.php";

$query = "SELECT * FROM count";

$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $views = $row['views'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1 class="">This is the count: <?php echo "$views"; ?></h1>

</body>

</html>