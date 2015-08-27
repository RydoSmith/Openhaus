<link rel="stylesheet" href="/public/plugins/nivo/nivo-slider.css">
<link rel="stylesheet" href="/public/plugins/nivo/themes/default/default.css">
<style>
    .nivoSlider img{height:100% !important;}
    .nivo-main-image{height:100% !important;}
</style>

<div style="background-color: #efefef; width: 100%;">
    <div class="container" style="padding-top: 64px;">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="slider-wrapper theme-default" style="height: 400px; overflow: hidden">
                    <div class="ribbon"></div>
                    <div id="slider" class="nivoSlider"  style="height: 400px; overflow: hidden">
                        <?php foreach($model->event['images'] as $image): ?>
                            <img src="<?= $image['href']; ?>" alt="">
                        <?php endforeach; ?>
                    </div>
                    <div id="htmlcaption" class="nivo-html-caption">
                        <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4 class="grey-text" style="margin: 0"><?=$model->event['name'];?></h4>

            <div class="row">
                <div class="col s9 m9 l9">
                    <div class="row">
                        <div class="col s5 m5 l5">
                            <div style="width: 150px; padding: 10px; margin-left: 40px;">
                                <img src="<?= $model->account->image ?>" alt="" class="circle responsive-img" style="width: 100%">
                                <p style="text-align:center; margin: 0; color: #696969; font-size: 22px;"><?= ucfirst($model->event['user']['first_name']); ?> <?= ucfirst($model->event['user']['last_name']); ?></p>
                                <p style="text-align:center; margin: 0; color: #696969; font-size: 16px;"><?= ucfirst($model->event['user']['bio']); ?>Bio will go here, interface is coming!</p>
                            </div>
                        </div>
                        <div class="col s2 m2 l2">
                            <p style="text-align:center; margin: 30px 0 0 0; font-size: 32px; color: #696969;"><?=$model->event['type'];?></p>
                            <p style="text-align:center; margin: 0; color: #696969;">property type</p>
                        </div>
                        <div class="col s2 m2 l2">
                            <p style="text-align:center; margin: 30px 0 0 0; font-size: 32px; color: #696969;"><?=$model->event['bedrooms'];?></p>
                            <p style="text-align:center; margin: 0; color: #696969;">bedroom</p>
                        </div>
                        <div class="col s1 m1 l1">
                            <p style="text-align:center; margin: 30px 0 0 0; font-size: 32px; color: #696969;"><?=$model->event['bathrooms'];?></p>
                            <p style="text-align:center; margin: 0; color: #696969;">bathroom</p>
                        </div>
                    </div>

                    <h5 class="grey-text" style="margin: 60px 0 20px 0;">About this Open House</h5>
                    <p class="grey-text" style="margin: 0"><?=$model->event['description'];?></p>

                    <hr style="border-style: dashed; background-color: #fff; margin: 50px 0; border-color: #cdcdcd">

                    <h5 class="grey-text" style="margin: 20px 0">Photos</h5>
                    <div class="row">
                        <?php foreach($model->event['images'] as $image): ?>
                            <div class="col s4 m4 l4 event-images-container">
                                <img src="<?= $image['href']; ?>" alt="" class="materialboxed" width="300">
                            </div>
                        <?php endforeach; ?>
                    </div>


                    <hr style="border-style: dashed; background-color: #fff; margin: 50px 0; border-color: #cdcdcd">

                    <h5 class="grey-text" style="margin: 20px 0">Who's going?</h5>
                    <div class="row">
                        <div class="rsvp-users col s2 m2 l2">
                            <?php if(count($model->event['rsvps']) > 0): ?>

                                <?php foreach($model->event['rsvps'] as $rsvp): ?>
                                    <img src="<?= $rsvp['user']['image']['href'];  ?>" style="margin-left: 10px; width: 70px; margin-top: 15px" alt="" class="circle responsive-img" />
                                    <p style="font-size: 18px"><?= ucfirst($rsvp['user']['first_name']).' '.ucfirst($rsvp['user']['last_name']) ?> </p>
                                <?php endforeach; ?>

                            <?php else: ?>

                                <p class="rsvp-message">There are no RSVP's to this event, <a href="#!" class="rsvpmodal-launch teal-text not-auth-btn">be the first</a>!</p>

                            <?php endif; ?>

                        </div>
                    </div>
                    <hr style="border-style: dashed; background-color: #fff; margin: 50px 0; border-color: #cdcdcd">

                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="grey-text" style="margin: 20px 0">Location</h5>
                            <div style="width: 100%; height: 300px; overflow: hidden;">
                                <div id="map" style="width: 100%; height: 330px; margin-left: 0;"></div>
                            </div>

                        </div>
                    </div>


                    <hr style="border-style: dashed; background-color: #fff; margin: 50px 0; border-color: #cdcdcd">

                    <h5 class="grey-text" style="margin: 20px 0">Comments</h5>
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <?php if(HTMLHelper::IsLoggedIn()): ?>
                                    <div class="input-field col s10">
                                        <input type="text" name="comment" class="materialize-textarea" placeholder="leave a comment" id="comment-input">
                                    </div>
                                    <div class="input-field col s2">
                                        <input type="button" class="btn teal not-auth-btn" value="comment" id="comment-btn">
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m12 l12" id="comments">
                                            <?php if($model->event['comments']): ?>
                                                <?php foreach($model->event['comments'] as $comment): ?>
                                                    <div class="row">
                                                        <div class="col s1 m1 l1">
                                                            <img src="<?= $comment['user']['image']['href'] ?>" alt="" class="circle responsive-img" style="width: 100%">
                                                        </div>
                                                        <div class="col s11 m11 l11">
                                                            <h6 class="teal-text" style="font-size: 22px">
                                                                <?= ucfirst($comment['user']['first_name']) ?> <?= ucfirst($comment['user']['last_name']) ?>
                                                                <span class="grey-text" style="font-size: 12px; float: right;"><?= HTMLHelper::TimeElapsedString($comment['created']) ?></span>
                                                            </h6>
                                                            <p style="margin-bottom: 40px;"><?= $comment['content'] ?></p>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="row">
                                                    <div class="col s12 m12 l12">
                                                        <p>No comments yet, get there first!</p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col s12">
                                        <h6 class="teal-text">You must be <a href="/account/login">logged in</a> to leave a comment</h6>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col s13 m3 l3">
                    <a href="#!" class="btn waves-effect waves-light btn teal rsvpmodal-launch not-auth-btn" style="width: 100%; margin-bottom: 10px;">RSVP to Attend</a>
                    <div id="rsvpmodal" class="modal" style="width: 500px;">
                        <div class="modal-content" style="height: 300px;">
                            <h4>RSVP to Event</h4>
                            <!-- Dropdown Trigger -->
                            <a class='dropdown-button btn' href='#' data-activates='rsvp-dropdown'>Choose a Date</a>

                            <!-- Dropdown Structure -->
                            <ul id='rsvp-dropdown' class='dropdown-content' style="min-width: 300px !important;">
                                <?php foreach($model->event['dates'] as $date): ?>
                                    <li style="padding: 20px; width: 300px;" class="rsvp-option" data-event-date-time="<?= date("D, M jS", strtotime($date['date']));?> &nbsp; <?= date("g A", strtotime($date['start_time']));?>-<?= date("g A", strtotime($date['end_time']));?>" data-event-date-id="<?=$date['id'];?>"><?= date("D, M jS", strtotime($date['date']));?> &nbsp; <?= date("g A", strtotime($date['start_time']));?>-<?= date("g A", strtotime($date['end_time']));?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <p id="rsvp-message" style="padding: 0 10px 0 10px"></p>
                            <a href="#!" class=" modal-action waves-effect waves-green btn-flat" id="rsvp-btn">rsvp</a>
                            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">cancel</a>
                        </div>
                    </div>
                    <a href="#!" class="btn waves-effect waves-light btn teal" style="width: 100%; margin-bottom: 10px;" id="share-btn">Share with a Friend</a>
                    <a href="#!" class="btn waves-effect waves-light btn teal not-auth-btn" style="width: 100%; margin-bottom: 10px;" id="watchlist-btn">Add to Watchlist</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="/public/plugins/nivo/jquery.nivo.slider.js"></script>
<script type="text/javascript">

    $(window).load(function() {
        $('#slider').nivoSlider({
            effect: 'fade',
            controlNav: false
        });

        $('#share-btn').click(function(){
            Materialize.toast('Feature coming, be patient :)', 4000);
        })

        <?php if(isset($model->account)): ?>
            $('.rsvpmodal-launch').click(function(){
                $('#rsvpmodal').openModal();
            });

            $('#rsvp-btn').click(function(){

                var eventDateId = $(this).attr('data-event-date-id');
                $('#rsvpmodal').closeModal();

                $.ajax({
                    type: "POST",
                    url: '/event/rsvp',
                    data: eventDateId,
                    success: function(data, message)
                    {
                        $('#rsvp-message').html('');
                        if(data.json == "success")
                        {
                            Materialize.toast('Your RSVP to this event has been sent to the organizer', 4000);
                            if($('.rsvp-message'))
                            {
                                $('.rsvp-message').remove();
                            }
                            $('.rsvp-users').prepend("<img src=\"<?= $model->account->image;  ?>\" style=\"margin-left: 10px; width: 70px; margin-top: 15px\" alt=\"\" class=\"circle responsive-img\" /><p style=\"font-size: 18px\"><?= ucfirst($model->account->first_name).' '.ucfirst($model->account->last_name) ?> </p>");
                        }
                        else
                        {
                            Materialize.toast('You have already send this organizer an RSVP for that date', 4000);
                        }
                    },
                    dataType: "JSON"
                });
            });

            $('.rsvp-option').click(function(){
                var eventDateId = $(this).attr('data-event-date-id');
                $('#rsvp-message').html('You have selected <span class="teal-text">' + $(this).attr('data-event-date-time') + '</span>. Click RSVP below to RSVP to this event.');
                $('#rsvp-btn').attr('data-event-date-id', eventDateId);
            });

            var isOnWatchlist = false;

            $('#watchlist-btn').click(function(){
                if(!isOnWatchlist)
                {
                    Materialize.toast('Event added to watchlist!', 4000);
                    isOnWatchlist = true;
                }
                else
                {
                    Materialize.toast('You already have this event on your watchlist!', 4000);
                }
            });

            $('#comment-btn').click(function(){
                var comment = $('#comment-input').val();

                var data =
                {
                    'event_id': "<?= $model->event['id'] ?>",
                    'user_id': "<?= $model->account->id ?>",
                    'comment': comment
                }

                if(comment)
                {
                    $.ajax({
                        type: "POST",
                        url: '/event/comment',
                        data: data,
                        dataType: 'json',
                        success: function(data, message)
                        {
                            if(data == "success")
                            {
                                Materialize.toast('Comment added!', 4000);
                                $('#comments').prepend('<div class="row"><div class="col s1 m1 l1"><img src="<?= $model->account->image ?>" alt="" class="circle responsive-img" style="width: 100%"></div><div class="col s11 m11 l11"> <h6 class="teal-text" style="font-size: 22px"><?= ucfirst($model->account->first_name) ?> <?= ucfirst($model->account->last_name) ?><span class="grey-text" style="font-size: 12px; float: right;">now</span> </h6> <p style="margin-bottom: 40px;">' + comment + '</p><hr></div></div>');
                                $('#comment-input').val('');
                            }
                            else
                            {
                                Materialize.toast('There was a problem adding your comment', 4000);
                            }
                        },
                        dataType: "JSON"
                    });
                }
            });
        <?php else : ?>

            $('.not-auth-btn').click(function(){
                Materialize.toast('You must be logged in to perform this action. Either <a href="/account/login">&nbsp; login &nbsp; </a> or <a href="/account/signup">&nbsp; sign up</a>!', 4000);
            });

        <?php endif; ?>



    });

    //
    //Map
    //
    var address = "<?=$model->event['location']?>";
    var geocoder = new google.maps.Geocoder();
    function initialize() {
        var mapProp = {
            center:new google.maps.LatLng(43.761539, -79.411079),
            zoom:10,
            mapTypeId:google.maps.MapTypeId.ROADMAP,
            navigationControl: false,
            mapTypeControl: false
        };

        var map=new google.maps.Map(document.getElementById("map"), mapProp);

        if (geocoder) {
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                        map.setCenter(results[0].geometry.location);

                        var infowindow = new google.maps.InfoWindow({
                            content: '<b>' + address + '</b>',
                            size: new google.maps.Size(150, 50)
                        });

                        var marker = new google.maps.Marker({
                            position: results[0].geometry.location,
                            map: map,
                            title: address
                        });

                        google.maps.event.addListener(marker, 'click', function () {
                            infowindow.open(map, marker);
                        });
                    }
                }
            });
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>