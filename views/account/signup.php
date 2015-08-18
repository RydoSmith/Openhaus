<div class="row">
    <div class="col s12 m6 offset-m3 l4 offset-l4">
        <div class="card white" style="margin: 200px auto 0 auto;">
            <form action="/account/signup" method="post" autocomplete="off">
                <div class="card-content blue-grey-text">
                    <span class="card-title teal-text">Sign Up</span>
                    <p style="margin-bottom: 30px;">Creating an account is easy! To get started just pop your email address in the box below...</p>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" type="email" class="validate" name="email">
                            <label for="email" data-error="not a valid email address" style="width: 100%">Email</label>
                            <?php $this->htmlHelper->DisplayErrorFor($model, 'email'); ?>
                        </div>
                    </div>
                <div class="card-action">
                    <button type="submit" class="waves-effect waves-light btn pink" style="float: right">SIGN UP</button>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>