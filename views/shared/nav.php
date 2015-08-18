<nav class="teal" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">openhaus.it</a>
        <ul class="right hide-on-med-and-down">
            <?php if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1): ?>
                <!-- Dropdown Trigger -->
                <a class='dropdown-button btn' href='#' data-activates='dropdown1' style="margin-left: 20px;margin-top: -3px;"><?= $model->account->first_name; ?></a>
                <!-- Dropdown Structure -->
                <ul id='dropdown1' class='dropdown-content' style="width: 200px; !important; ">
                    <li><a href="#!">notifications</a></li>
                    <li class="divider"></li>
                    <li><a href="#!">dashboard</a></li>
                    <li><a href="#!">my listings</a></li>
                    <li><a href="#!">my events</a></li>
                    <li class="divider"></li>
                    <li><a href="#!">settings</a></li>
                </ul>
                <li><a href="/account/logout">LOGOUT</a></li>
                <a href="/event/create" class="waves-effect waves-light btn pink btn-nav">CREATE EVENT</a>
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