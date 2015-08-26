<form action="/account/verify" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="row" id="card-1">
        <div class="col s12 m6 offset-m3 l4 offset-l4">
            <div class="card white" style="margin: 200px auto 0 auto;">
                <div class="card-content blue-grey-text">
                    <span class="card-title teal-text">Account Info</span>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="username" type="text" name="username" <?= $this->htmlHelper->DisplayValueFor($model, 'username'); ?>>
                            <label for="username">Username</label>
                            <?= $this->htmlHelper->DisplayErrorFor($model, 'username'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" name="password" <?= $this->htmlHelper->DisplayValueFor($model, 'password'); ?>>
                            <label for="password">Password</label>
                            <?= $this->htmlHelper->DisplayErrorFor($model, 'password'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="confirm_password" type="password" name="confirm_password" <?= $this->htmlHelper->DisplayValueFor($model, 'confirm_password'); ?>>
                            <label for="confirm_password">Confirm Password</label>
                            <?= $this->htmlHelper->DisplayErrorFor($model, 'confirm_password'); ?>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#" class="waves-effect waves-light btn pink white-text next-btn" style="float: right">NEXT</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="display:none" id="card-2">
        <div class="col s12 m6 offset-m3 l4 offset-l4">
            <div class="card white" style="margin: 200px auto 0 auto;">
                <div class="card-content blue-grey-text">
                    <span class="card-title teal-text">Your details</span>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="first_name" type="text" name="first_name" <?= $this->htmlHelper->DisplayValueFor($model, 'first_name'); ?>>
                            <label for="first_name">First Name</label>
                            <?= $this->htmlHelper->DisplayErrorFor($model, 'first_name'); ?>
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" type="text" name="last_name" <?= $this->htmlHelper->DisplayValueFor($model, 'last_name'); ?>>
                            <label for="last_name">Last Name</label>
                            <?= $this->htmlHelper->DisplayErrorFor($model, 'last_name'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="country_id">
                                <option value="" disabled selected>Choose your country</option>
                                <?php foreach($model->post['countries'] as $c): ?>
                                    <option value="<?=$c['id']?>" <?php if(isset($model->post)){ $this->htmlHelper->IsSelected($c['id'], $model->post['id']); } ?>><?=$c['name']?></option>
                                <?php endforeach; ?>
                            </select>
                            <label>Country</label>
                            <?= $this->htmlHelper->DisplayErrorFor($model, 'country_id'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="city" type="text" name="city" <?= $this->htmlHelper->DisplayValueFor($model, 'city'); ?>>
                            <label for="city">City</label>
                            <?= $this->htmlHelper->DisplayErrorFor($model, 'city'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <span class="card-title teal-text">Profile Image</span>
                        <p style="margin-bottom: 30px;">You can skip this step and select a profile image later.</p>
                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Image</span>
                                <input type="file" name="file">

                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                            <?= $this->htmlHelper->DisplayErrorFor($model, 'image'); ?>
                        </div>
                    </div>
                    <div class="card-action">
                        <input type="hidden" name="id" value="<?= $model->post['id']; ?>" />
                        <input type="hidden" name="email" value="<?= $model->post['email']; ?>" />
                        <a href="#" class="waves-effect waves-light pink-text" id="prev-btn">BACK</a>
                        <button type="submit" class="waves-effect waves-light btn pink white-text" style="float: right">FINISH</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('select').material_select();

        var selectedCard = 1;

        $('.next-btn').click(function(){
            if(selectedCard == 1)
            {
                selectedCard = 2;
                $('#card-1').hide();
                $('#card-2').show();
            }
        });

        $('#prev-btn').click(function(){
            if(selectedCard == 2)
            {
                selectedCard = 1;
                $('#card-2').hide();
                $('#card-1').show();
            }
        });

    });
</script>