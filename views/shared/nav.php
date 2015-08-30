<nav class="teal" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">openhaus.it</a>
        <ul class="right hide-on-med-and-down">
            <?php if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1): ?>

                <a href="/event/create" class="waves-effect waves-light btn pink btn-nav">CREATE EVENT</a>
                <div style="padding-top: 12px; float: right; margin-left: 10px">
                    <span style="display: inline-block; padding: 0; margin: 0; margin-top: -20px; line-height: 20px;">Hi, <?= ucfirst($model->account->first_name); ?>! <a href="/user/dashboard" class="new badge pink notification-count" style="display: inline-block; position: relative; padding: 2px 10px; margin-left: 0px;"><?=$model->account->unread_notifications_count?></a>
                    <br>
                        <a href="/account/logout" style="display: inline-block; padding: 0; font-size: 12px">LOGOUT</a>
                    </span>
                    <img src="<?= $model->account->image ?>" alt="" class="circle responsive-img" style="width: 38px;">
                </div>

            <?php else: ?>
                <li><a href="/account/signup">SIGN UP</a></li>
                <li><a href="/account/login">LOGIN</a></li>
                <a href="/event/create" class="waves-effect waves-light btn pink btn-nav">CREATE EVENT</a>
            <?php endif; ?>
        </ul>

        <ul id="nav-mobile" class="side-nav">
            <li><a href="/account/signup">SIGN UP</a></li>
            <li><a href="/account/login">LOGIN</a></li>
            <li><a href="/event/create">CREATE EVENT</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>

<script>
    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrain_width: false, // Does not change width of dropdown to that of the activator
            hover: true, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: true // Displays dropdown below the button
        }
    );
</script>