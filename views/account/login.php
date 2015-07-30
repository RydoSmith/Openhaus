<div class="mdl-card mdl-shadow--2dp demo-card-wide" style="margin: 150px auto 0 auto">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Login</h2>
    </div>
    <div class="mdl-card__actions mdl-card--border">
        <form action="/account/login" method="post">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" id="email" name="email" />
                <label class="mdl-textfield__label" for="email">Email</label>
                <span class="mdl-textfield__error">Not a valid email address!</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="password" name="password" />
                <label class="mdl-textfield__label" for="password">Password</label>
            </div>
            <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit" style="float: right">Sign Up</button>
        </form>
    </div>
    <div class="mdl-card__supporting-text">
        <p>Having problems logging in? Have you <a href="#">forgot your password</a>?</p>
    </div>
</div>