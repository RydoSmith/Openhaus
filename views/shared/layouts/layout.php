<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require('views/shared/header.php'); ?>
    </head>
    <body>
        <?php
            if(isset($model) && isset($model->message))
            {
                echo $model->message;
            }
        ?>
        <?php require('views/shared/nav.php'); ?>
        <?php require($location);  ?>
        <?php require('views/shared/footer.php'); ?>
    </body>
</html>
