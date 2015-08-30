<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="col s12 m12 l12">
            <ul class="user-nav">
                <li><a href="/user/dashboard">Dashboard</a></li>
                <li><a href="/user/myevents">My Events</a></li>
                <li><a href="/user/mylistings">My Listings</a></li>
                <li><a href="/user/watchlist" class="selected">Watchlist</a></li>
                <li><a href="/user/settings">Settings</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s2 m2 l2">
            <a href="/user/settings" style="text-align: center; display: block; margin: 20px 0px">Currently Watching</a>
        </div>
        <div class="col s10 m10 l10">
            <div class="dashboard-panel">
                <div class="dashboard-panel-heading teal">
                    <h6 class="white-text" style="width: 100%">WatchList</h6>
                </div>
                <div class="dashboard-panel-body" style="height: 500px;">
                    <?php if($model->events): ?>
                        <?php foreach($model->events as $event): ?>
                            <p>
                                <a href="/event/detail/<?=$event['id']?>" class="btn">view</a>
                                <a href="/event/detail/<?=$event['id']?>#comments" class="btn">comments (<?=count($event['comments'])?>)</a>

                                <strong class="teal-text" style="margin-left: 20px"><?=$event['name']?></strong>
                                <span class="blue-grey-text" style="margin-left: 20px"><?=$event['location']?></span>
                            </p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nothing on watchlist!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>