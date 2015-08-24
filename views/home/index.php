<div class="proposition">
    <div class="content">
        <h1 class="title" class="z-depth-1-half">FIND AN OPEN HOUSE NEAR YOU</h1>
        <p>A supporting statement of your value proposition. Entice your visitor to keep reading <br /> the high levels of your offering.</p>
    </div>
</div>
<div class="row">
    <div class="searchbar" style="width: 100%; min-height: 60px; background-color: #009688; display: inline-block; text-align: center;">
        <div class="container">
            <div class="col s12 m12 l12">
                <form action="/event/search" method="post">
                    <h6 class="white-text" style="line-height: 60px; margin: 0;">
                        I'm looking for a
                        <a class="dropdown-button btn" href="#" data-activates="bedroomselect" style="margin-bottom: 5px; background: none !important;" id="bedroom-select-display">1 bedroom</a>
                        <ul id="bedroomselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                            <li><a href="#!" class="bedroom-select" data-value="any">any bedrooms</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="1">1 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="2">2 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="3">3 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="4">4 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="5">5 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="6">6+ bedroom</a></li>
                        </ul>
                        <a class="dropdown-button btn" href="#" data-activates="typeselect" style="margin-bottom: 5px;background: none !important;" id="type-select-display">house</a>
                        <ul id="typeselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                            <li><a href="#!" class="type-select" data-value="any">any property type</a></li>
                            <li><a href="#!" class="type-select" data-value="house">house</a></li>
                            <li><a href="#!" class="type-select" data-value="townhouse">townhouse</a></li>
                            <li><a href="#!" class="type-select" data-value="condo">condo</a></li>
                            <li><a href="#!" class="type-select" data-value="other">other</a></li>
                        </ul>
                        in
                        <a class="dropdown-button btn" href="#" data-activates="locationselect" style="margin-bottom: 5px;background: none !important;" id="location-select-display">any location</a>
                        <ul id="locationselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                            <li><a href="#!" class="location-select" data-value="any">any location</a></li>
<!--                            <li><a href="#!" class="location-select" data-value="toronto">toronto</a></li>-->
<!--                            <li><a href="#!" class="location-select" data-value="aberdeen">aberdeen</a></li>-->
                        </ul>
                        <input type="hidden" name="bedrooms" id="bedroom-search-value" value="1">
                        <input type="hidden" name="type" id="type-search-value" value="house">
                        <input type="hidden" name="location"  id="location-search-value" value="any">
                        <input type="submit" class="btn pink" value="search" style="font-size: 1rem; margin-top: -5px">
                    </h6>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <p class="blue-grey-text">Find the <span class="pink-text">closest</span> open house near me.</p>
        </div>
        <?php foreach($model->events as $event): ?>
            <div class="col s12 m6 l4">
                <div class="card hoverable home-event-display" data-event-id="<?= $event['id'] ?>">
                    <div class="card-image waves-effect waves-block waves-light" style="height: 180px; overflow: hidden;">
                        <img src="<?=$event['images'][0]['href']?>">
                    </div>
                    <div class="card-content grey lighten-4">
                        <p class="blue-grey-text" style="font-size: 18px;">
                            <i class="material-icons tiny">info_outline</i>
                            <span><?=$event['bedrooms']?> Bedroom, <?=$event['bathrooms']?> Bath</span>
                        </p>
                        <p class="blue-grey-text" style="height: 22px; overflow: hidden;">
                            <i class="material-icons tiny">location_on</i>
                            <span><?=$event['location']?></span>
                        </p>
                        <p class="blue-grey-text">
                            <i class="material-icons tiny">schedule</i>
                            <span><?= date("D, M jS", strtotime($event['dates'][0]['date']));?> &nbsp; <?= date("g A", strtotime($event['dates'][0]['start_time']));?>-<?= date("g A", strtotime($event['dates'][0]['end_time']));?></span>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#bedroom-select-display').html($('#bedroom-search-value').val() + ' bedroom');

        if($('#type-search-value').val() == 'any')
        {
            $('#type-select-display').html($('#type-search-value').val() + ' property type');
        }
        else
        {
            $('#type-select-display').html($('#type-search-value').val());
        }

        if($('#location-search-value').val() == 'any')
        {
            $('#location-select-display').html($('#location-search-value').val() + ' location');
        }
        else
        {
            $('#location-select-display').html($('#location-search-value').val());
        }

        //Search Dropdown Feature
        $('.bedroom-select').click(function(){
            $('#bedroom-search-value').val($(this).attr('data-value'));
            $('#bedroom-select-display').html($(this).html());
       });

        $('.type-select').click(function(){
            $('#type-search-value').val($(this).attr('data-value'));
            $('#type-select-display').html($(this).html());
        });

        $('.location-select').click(function(){
            $('#location-search-value').val($(this).attr('data-value'));
            $('#location-select-display').html($(this).html());
        });

        //Redirect to event on click
        $('.home-event-display').click(function(){
            window.location.href = "/event/detail/" + $(this).attr('data-event-id');
        });

    });
</script>