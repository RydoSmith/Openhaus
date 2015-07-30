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
        <div class="layout-transparent mdl-layout mdl-js-layout" style="background: none">
            <?php require('views/shared/nav.php'); ?>
            <main class="mdl-layout__content">
                <?php require($location);  ?>
            </main>
            <?php require('views/shared/footer.php'); ?>
        </div>
    </body>
</html>
