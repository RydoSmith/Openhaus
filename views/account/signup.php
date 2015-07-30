<div class="mdl-card mdl-shadow--2dp demo-card-wide" style="margin: 150px auto 0 auto">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Sign Up</h2>
    </div>
    <div class="mdl-card__supporting-text">
        Creating an account is easy! To get started just pop your email address in the box below...
    </div>
    <div class="mdl-card__actions mdl-card--border">
        <form action="/account/signup" method="post">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" id="email" name="email" />
                <label class="mdl-textfield__label" for="email">Email</label>
                <span class="mdl-textfield__error">Not a valid email address!</span>
            </div>
            <?php $this->htmlHelper->DisplayErrorFor($model, 'email'); ?>
            <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit" style="float: right">Sign Up</button>
        </form>
    </div>
</div>