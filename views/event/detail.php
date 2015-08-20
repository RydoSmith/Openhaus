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
                <div class="col s12 m10 l10">
                    <p>Organiser image, name & bio + type, bedrooms & bathrooms go here</p>

                    <h5 class="grey-text" style="margin: 20px 0;">About this Open House</h5>
                    <p class="grey-text" style="margin: 0"><?=$model->event['description'];?></p>

                    <hr style="border-style: dashed; background-color: #fff; margin: 50px 0; border-color: #cdcdcd">

                    <h5 class="grey-text" style="margin: 20px 0">Photos</h5>
                    <div class="row">
                        <?php foreach($model->event['images'] as $image): ?>
                            <div class="col s6 m6 l6">
                                <div style="width: 100%; overflow: hidden; height: 200px; margin-bottom: 20px;">
                                    <img src="<?= $image['href']; ?>" alt="" style="width: 100%">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>


                    <hr style="border-style: dashed; background-color: #fff; margin: 50px 0; border-color: #cdcdcd">

                    <h5 class="grey-text" style="margin: 20px 0">Who's going?</h5>
                    <p>list of rsvp users goes here</p>

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
                                        <input type="text" name="comment" class="materialize-textarea" placeholder="leave a comment">
                                    </div>
                                    <div class="input-field col s2">
                                        <input type="submit" class="btn teal" value="comment">
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
                <div class="col s12 m2 l2">
                    <p>rsvp</p>
                    <p>share</p>
                    <p>add to watchlist</p>
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





    });

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