<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="col s12 m12 l12">
            <ul class="user-nav">
                <li><a href="/user/dashboard">Dashboard</a></li>
                <li><a href="/user/myevents">My Events</a></li>
                <li><a href="/user/mylistings">My Listings</a></li>
                <li><a href="/user/watchlist">Watchlist</a></li>
                <li><a href="/user/settings" class="selected">Settings</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s2 m2 l2">
            <a href="#!" style="text-align: center; display: block; margin: 20px 0px" data-page="page-1" class="change-page">General</a>
            <a href="#!" style="text-align: center; display: block;" data-page="page-2" class="change-page">Change Password</a>
        </div>
        <div class="col s10 m10 l10">
            <div class="dashboard-panel" id="page-1">
                <div class="dashboard-panel-heading teal">
                    <h6 class="white-text" style="width: 100%">General</h6>
                </div>
                <div class="dashboard-panel-body" style="min-height: 1200px; padding: 40px; overflow: hidden;">
                    <form action="/user/settings" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s8">
                                <h5 class="card-title teal-text">Account Info</h5>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="username" type="text" name="username" <?= $this->htmlHelper->DisplayValueFor($model, 'username'); ?>>
                                        <label for="username">Username</label>
                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'username'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="email" type="text" name="email" <?= $this->htmlHelper->DisplayValueFor($model, 'email'); ?> disabled="disabled">
                                        <label for="email">Email</label>
                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'email'); ?>
                                    </div>
                                </div>
                                <h5 class="card-title teal-text">Your Details</h5>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="first_name" type="text" name="first_name" <?= $this->htmlHelper->DisplayValueFor($model, 'first_name'); ?>>
                                        <label for="first_name">First Name</label>
                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'first_name'); ?>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="last_name" type="text" name="last_name" <?= $this->htmlHelper->DisplayValueFor($model, 'last_name'); ?>>
                                        <label for="username">Last Name</label>
                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'last_name'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="date" class="datepicker" name="birthday" placeholder="Select your birthday" <?= $this->htmlHelper->DisplayValueFor($model, 'birthday'); ?>>
                                        <label for="username">Birthday</label>
                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'birthday'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select name="gender" style="display: block !important">
                                            <?php if($model->post['gender']): ?>
                                                <option value="male" <?php if($model->post['gender'] == 'male'){ echo "selected=\"selected\""; } ?>>Male</option>
                                                <option value="female" <?php if($model->post['gender'] == 'female'){ echo "selected=\"selected\""; } ?>>Female</option>
                                            <?php else: ?>
                                                <option value="">Choose a gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            <?php endif; ?>
                                        </select>

                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'country_id'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="bio" class="materialize-textarea"  name="bio" placeholder="enter your bio, keep it short and sweet"><?= $this->htmlHelper->DisplayTextareaValueFor($model, 'bio'); ?></textarea>
                                        <label for="bio">Bio</label>
                                    </div>
                                </div>
                                <h5 class="card-title teal-text">Location</h5>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select name="country_id" style="display: block !important">
                                            <?php foreach($model->post['countries'] as $c): ?>
                                                <option value="<?=$c['id']?>" <?php if(isset($model->post)){ $this->htmlHelper->IsSelected($c['id'], $model->post['country_id']); } ?>><?=$c['name']?></option>
                                            <?php endforeach; ?>
                                        </select>

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
                            </div>
                            <div class="input-field col s4">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <img src="<?= $model->account->image ?>" alt="" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="file-field input-field col s12 m12 l12">
                                        <input class="file-path validate" type="text" style="width: 30%;"/>
                                        <div class="btn">
                                            <span>image</span>
                                            <input type="file" name="file" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" <?php $this->htmlHelper->DisplayValueFor($model, 'id')?>>
                        <input type="hidden" name="email" <?php $this->htmlHelper->DisplayValueFor($model, 'email')?>>
                        <input type="submit" class="btn teal" value="update">
                    </form>
                </div>
            </div>
            <div class="dashboard-panel" style="display: none;" id="page-2">
                <div class="dashboard-panel-heading teal">
                    <h6 class="white-text" style="width: 100%">Change Password</h6>
                </div>
                <div class="dashboard-panel-body" style="height: 500px; padding: 30px">
                    <form action="/user/changepassword" method="post" autocomplete="off">
                        <div class="row">
                            <div class="input-field col s8">
                                <h5 class="card-title teal-text">Change Password</h5>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="password" type="password" name="password">
                                        <label for="password">Password</label>
                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'password'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="new_password" type="password" name="new_password">
                                        <label for="new_password">New Password</label>
                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'new_password'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="confirm_password" type="password" name="confirm_password">
                                        <label for="confirm_password">Confirm Password</label>
                                        <?= $this->htmlHelper->DisplayErrorFor($model, 'confirm_password'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" <?php $this->htmlHelper->DisplayValueFor($model, 'id')?>>
                        <input type="hidden" name="email" <?php $this->htmlHelper->DisplayValueFor($model, 'email')?>>
                        <input type="submit" class="btn teal" value="Change Password">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.change-page').click(function(e){
        e.preventDefault();
        var target = $(this).attr('data-page');
        $('.dashboard-panel').hide();
        $('#'+target).show();

    });

    $('.datepicker').pickadate({
        selectMonths: false,
        selectYears: false,
        today: null,
        clear: null,
        close: null
    });
</script>