<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anglès Montalt</title>
    <link rel="icon" type="image/png" href="img/favicon.png" ; />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
        integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="wrapper">
        <div class="phone">
            <a href="https://api.whatsapp.com/send?phone=34666068734&text=M%27agradaria%20saber%20m%C3%A9s%20sobre%20els%20classes%20d%27Angl%C3%A8s%21"
                <i class="fab fa-whatsapp"></i></a>
        </div>
        <?php

        if (isset($_GET['language'])) {
            $source = $_GET['language'];
        } else {
            $source = 'cat.php';
        }

        switch ($source) {

            case 'cat.php';
                include "includes/cat.php";
                break;
            case 'esp.php';
                include "includes/esp.php";
                break;

            case 'eng.php';
                include "includes/eng.php";
                break;

            default:
                include "includes/cat.php";
        }

        ?>


        <h3>Website by D.A.Steer/Anglès Montalt © <?php echo date('Y'); ?></h3>
    </div>
    <script src="script.js"></script>
</body>

</html>
