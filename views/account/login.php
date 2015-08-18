<div class="row">
    <div class="col s12 m6 offset-m3 l4 offset-l4">
        <div class="card white" style="margin: 200px auto 0 auto;">
            <form action="/account/login" method="post" autocomplete="off">
                <div class="card-content blue-grey-text">
                    <span class="card-title teal-text">Login</span>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" type="email" name="email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" name="password">
                            <label for="email">Password</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <p style="float:left">Have you <a href="/account/password" class="pink-text" style="margin-right: 0">forgot your password</a>?</p>

                        <?php if(isset($model->returnUrl)): ?>
                            <input type="hidden" name="returnUrl" value="<?= $model->returnUrl ?>">
                        <?php endif; ?>

                        <button type="submit" class="waves-effect waves-light btn pink" style="float: right">LOGIN</button>
                        <div class="clearfix"></div>
                    </div>
            </form>
        </div>
    </div>
</div>