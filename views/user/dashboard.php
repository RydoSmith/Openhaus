<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="col s12 m12 l12">
            <ul class="user-nav">
                <li><a href="/user/dashboard" class="selected">Dashboard</a></li>
                <li><a href="/user/myevents">My Events</a></li>
                <li><a href="/user/mylistings">My Listings</a></li>
                <li><a href="/user/watchlist">Watchlist</a></li>
                <li><a href="/user/settings">Settings</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s2 m2 l2">
            <img src="<?= $model->account->image ?>" alt="" style="width: 100%;">
            <h5 style="text-align: center"><?= $model->account->full_name?></h5>
            <a href="/user/settings" style="text-align: center; display: block">Edit Settings</a>
        </div>
        <div class="col s10 m10 l10">
            <div class="dashboard-panel">
                <div class="dashboard-panel-heading teal">
                    <h6 class="white-text" style="width: 100%">Notifications <span class="new badge pink notification-count" style="position: relative; padding: 2px; margin-left: 20px;"><?=$model->account->unread_notifications_count?></span></h6>
                </div>
                <div class="dashboard-panel-body">
                    <?php if($model->account->notifications): ?>
                        <?php foreach($model->account->notifications as $notification): ?>
                            <p>
                                <strong class="teal-text"><?=$notification['title']?></strong>
                                <?php if($notification['has_seen'] == 0): ?>
                                    <span class="new badge pink new-badge" style="position: relative; padding: 2px; margin-left: 20px;"></span>
                                <?php endif; ?>
                                <span class="blue-grey-text" style="margin-left: 40px"><?=$notification['content']?></span>

                                <?php if($notification['has_seen'] == 0): ?>
                                    <span style="float: right; margin-left: 30px"><a href="#!" class="large material-icons text-deal dismiss-notification" data-notification-id="<?=$notification['id']?>">done</a></span>
                                <?php endif; ?>

                                <span class="blue-grey-text" style="float: right;"><?=date('D, jS M : ga', strtotime($notification['created'])) ?></span>
                            </p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No new notifications!</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="dashboard-panel">
                <div class="dashboard-panel-heading teal">
                    <h6 class="white-text">Invite Friends</h6>
                </div>
                <div class="dashboard-panel-body" style="height: 100px">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.dismiss-notification').click(function(e){

        var id = $(this).attr('data-notification-id');
        var element = this;
        $.ajax({
            type: "POST",
            url: '/user/DismissNotification',
            data: id,
            dataType: 'json',
            success:function(data, message){
                if(message == 'success')
                {
                    $(element).parent().parent().find('.new-badge').remove();
                    $(element).parent().remove();
                }
                else
                {

                }
            }
        });
    });
</script>