<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="col s12 m12 l12">
            <ul class="user-nav">
                <li><a href="/user/dashboard">Dashboard</a></li>
                <li><a href="/user/myevents">My Events</a></li>
                <li><a href="/user/mylistings" class="selected">My Listings</a></li>
                <li><a href="/user/watchlist">Watchlist</a></li>
                <li><a href="/user/settings">Settings</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s2 m2 l2">
            <a href="#!" style="text-align: center; display: block; margin: 20px 0px" data-page="page-1" class="change-page">My Open Houses</a>
            <a href="#!" style="text-align: center; display: block;" data-page="page-2" class="change-page">Open house History</a>
        </div>
        <div class="col s10 m10 l10">
            <div class="dashboard-panel" id="page-1">
                <div class="dashboard-panel-heading teal">
                    <h6 class="white-text" style="width: 100%">My Open Houses</h6>
                </div>
                <div class="dashboard-panel-body" style="height: 500px;">
                    <?php if($model->current_events): ?>
                        <?php foreach($model->current_events as $event): ?>
                            <p>
                                <a href="/event/detail/<?=$event['id']?>" class="btn">view</a>
                                <a href="/event/detail/<?=$event['id']?>#comments" class="btn">comments (<?=count($event['comments'])?>)</a>

                                <strong class="teal-text" style="margin-left: 20px"><?=$event['name']?></strong>
                                <span class="blue-grey-text" style="margin-left: 20px"><?=$event['location']?></span>
                                <span class="blue-grey-text" style="margin-left: 20px; float: right; font-size: 12px; line-height: 32px;">Created on <?=date('D, jS M', strtotime($event['created']))?></span>
                            </p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No events planned!</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="dashboard-panel" style="display: none;" id="page-2">
                <div class="dashboard-panel-heading teal">
                    <h6 class="white-text" style="width: 100%">Open House History</h6>
                </div>
                <div class="dashboard-panel-body" style="height: 500px;">
                    <?php if($model->past_events): ?>
                        <?php foreach($model->past_events as $event): ?>
                            <p>
                                <a href="/event/detail/<?=$event['id']?>" class="btn">view</a>
                                <a href="/event/detail/<?=$event['id']?>#comments" class="btn">comments (<?=count($event['comments'])?>)</a>

                                <strong class="teal-text" style="margin-left: 20px"><?=$event['name']?></strong>
                                <span class="blue-grey-text" style="margin-left: 20px"><?=$event['location']?></span>
                                <span class="blue-grey-text" style="margin-left: 20px; float: right; font-size: 12px; line-height: 32px;">Created on <?=date('D, jS M', strtotime($event['created']))?></span>
                            </p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No events planned!</p>
                    <?php endif; ?>
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
</script>
