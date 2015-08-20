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
                    <h5 class="white-text" style="line-height: 30px;">
                        I'm looking for a
                        <a class="dropdown-button btn" href="#" data-activates="bedroomselect" style="margin-bottom: 5px" id="bedroom-select-display">1 bedroom</a>
                        <ul id="bedroomselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                            <li><a href="#!" class="bedroom-select" data-value="any">any bedrooms</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="1">1 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="2">2 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="3">3 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="4">4 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="5">5 bedroom</a></li>
                            <li><a href="#!" class="bedroom-select" data-value="6">6+ bedroom</a></li>
                        </ul>
                        <a class="dropdown-button btn" href="#" data-activates="typeselect" style="margin-bottom: 5px" id="type-select-display">house</a>
                        <ul id="typeselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                            <li><a href="#!" class="type-select" data-value="any">any property type</a></li>
                            <li><a href="#!" class="type-select" data-value="house">house</a></li>
                            <li><a href="#!" class="type-select" data-value="townhouse">townhouse</a></li>
                            <li><a href="#!" class="type-select" data-value="condo">condo</a></li>
                            <li><a href="#!" class="type-select" data-value="other">other</a></li>
                        </ul>
                        in
                        <a class="dropdown-button btn" href="#" data-activates="locationselect" style="margin-bottom: 5px" id="location-select-display">toronto</a>
                        <ul id="locationselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                            <li><a href="#!" class="location-select" data-value="any">any location</a></li>
                            <li><a href="#!" class="location-select" data-value="toronto">toronto</a></li>
                            <li><a href="#!" class="location-select" data-value="aberdeen">aberdeen</a></li>
                        </ul>
                        <input type="hidden" name="bedrooms" id="bedroom-search-value" value="1">
                        <input type="hidden" name="type" id="type-search-value" value="house">
                        <input type="hidden" name="location"  id="location-search-value" value="toronto">
                        <input type="submit" class="btn pink" value="search" style="font-size: 1rem; float: right;">
                    </h5>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <p>Find the closest open house near me.</p>
        <?php foreach($model->events as $event): ?>
            <?php //print_r($event);exit(); ?>
            <div class="col s12 m6 l4">
                <div style="width: 100%;">
                    <div style="width: 100%; height: 180px; overflow: hidden; background-image: url(<?=$event['images'][0]['href']?>); background-size: 100%; background-repeat: no-repeat;">

                    </div>
                </div>
                <div style="background-color: #efefef; width: 100%; padding: 10px; margin-bottom: 20px;">
                    <p><?=$event['bedrooms']?> Bedroom, <?=$event['bathrooms']?> Bath</p>
                    <p><?=$event['location']?></p>
                    <p><?= date("F jS, Y", strtotime($event['dates'][0]['date']));?> at <?= $event['dates'][0]['time']; ?></p>
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

    });
</script>