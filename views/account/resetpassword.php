<form action="/account/resetpassword" method="post" autocomplete="off">
    <div class="row" id="card-1">
        <div class="col s12 m6 offset-m3 l4 offset-l4">
            <div class="card white" style="margin: 200px auto 0 auto;">
                <div class="card-content blue-grey-text">
                    <span class="card-title teal-text">Reset Password</span>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" name="password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="confirm_password" type="password" name="confirm_password">
                            <label for="confirm_password">Confirm Password</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="hidden" name="email" value="<?= $model->email; ?>"/>
                        <input type="hidden" name="id" value="<?= $model->id; ?>"/>
                        <button type="submit" class="waves-effect waves-light btn pink white-text" style="float: right">CHANGE PASSWORD</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>