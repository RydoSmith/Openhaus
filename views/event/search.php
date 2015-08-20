<div class="container" style="padding-top: 80px;">
    <div class="row">
        <div class="col s12 m12 l12">
            <form action="/event/search" method="post" style="margin-bottom: 20px;">
                <h6 class="teal-text">Search</h6>
                <h5 class="teal-text" style="line-height: 30px;">
                    I'm looking for a
                    <a class="dropdown-button btn" href="#" data-activates="bedroomselect" style="margin-bottom: 5px;" id="bedroom-select-display">1 bedroom</a>
                    <ul id="bedroomselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                        <li><a href="#!" class="bedroom-select" data-value="any">any bedrooms</a></li>
                        <li><a href="#!" class="bedroom-select" data-value="1">1 bedroom</a></li>
                        <li><a href="#!" class="bedroom-select" data-value="2">2 bedroom</a></li>
                        <li><a href="#!" class="bedroom-select" data-value="3">3 bedroom</a></li>
                        <li><a href="#!" class="bedroom-select" data-value="4">4 bedroom</a></li>
                        <li><a href="#!" class="bedroom-select" data-value="5">5 bedroom</a></li>
                        <li><a href="#!" class="bedroom-select" data-value="6">6+ bedroom</a></li>
                    </ul>
                    <a class="dropdown-button btn" href="#" data-activates="typeselect" style="margin-bottom: 5px;" id="type-select-display">house</a>
                    <ul id="typeselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                        <li><a href="#!" class="type-select" data-value="any">any property type</a></li>
                        <li><a href="#!" class="type-select" data-value="house">house</a></li>
                        <li><a href="#!" class="type-select" data-value="townhouse">townhouse</a></li>
                        <li><a href="#!" class="type-select" data-value="condo">condo</a></li>
                        <li><a href="#!" class="type-select" data-value="other">other</a></li>
                    </ul>
                    in
                    <a class="dropdown-button btn" href="#" data-activates="locationselect" style="margin-bottom: 5px;" id="location-select-display">toronto</a>
                    <ul id="locationselect" class="dropdown-content" style="width: 200px; position: absolute; top: 53px; left: 951.09375px; opacity: 1; display: none;">
                        <li><a href="#!" class="location-select" data-value="any">any location</a></li>
                        <li><a href="#!" class="location-select" data-value="toronto">toronto</a></li>
                        <li><a href="#!" class="location-select" data-value="aberdeen">aberdeen</a></li>
                    </ul>
                    <input type="hidden" name="bedrooms" id="bedroom-search-value" value="<?=$model->selectedBedrooms?>">
                    <input type="hidden" name="type" id="type-search-value" value="<?=$model->selectedType?>">
                    <input type="hidden" name="location"  id="location-search-value" value="<?=$model->selectedLocation?>">
                    <input type="submit" class="btn pink" value="search" style="font-size: 1rem;float: right;">
                    <div class="clearfix"></div>
                </h5>
            </form>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l3">
            <h5 class="teal-text">Filter Results <a href="#!" class="btn small grey clear-filters" style="float: right; margin: 0; height: 27px; font-size: 12px; line-height: 27px;">clear</a></h5>
            <?php if(count($model->resultsTags) > 0): ?>

                <!-- Tags -->
                <h6 class="teal-text">by tags</h6>
                <?php foreach($model->resultsTags as $tag): ?>
                    <a href="#!" class="btn teal tag-select" style="margin-bottom: 10px; "><?=$tag;?></a>
                <?php endforeach; ?>

                <!-- Dates -->
                <h6 class="teal-text">by event dates</h6>
                <?php foreach($model->resultsDates as $date): ?>
                    <a href="#!" class="btn teal date-select" style="margin-bottom: 10px; height: 27px; font-size: 12px; line-height: 27px;" data-date="<?=$date?>"><?=date("F jS", strtotime($date));?></a>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
        <div class="col s12 m12 l9">
            <?php if(count($model->events) > 0): ?>
                <?php foreach($model->events as $event): ?>
                    <?php //print_r($event);exit(); ?>
                    <div class="row event-result"
                         data-tags="<?php foreach($event['keywords'] as $tags){ echo $tags['tag'].','; }; ?>"
                         data-dates="<?php foreach($event['dates'] as $date){ echo $date['date'].','; }; ?>">

                        <div style="width: 100%; padding: 10px 0;">
                            <h4 style="margin: 0;" class="teal-text"><?=$event['name']?></h4>
                            <h6 style="margin: 0;"><?=$event['location']?></h6>
                        </div>
                        <div style="width: 100%;">
                            <div style="width: 30%; height: 180px; overflow: hidden; float: left; background-image: url(<?=$event['images'][0]['href']?>); background-size: 100%; background-repeat: no-repeat;"></div>
                        </div>
                        <div style="min-height: 180px; background-color: #efefef; width: 70%; padding: 10px; margin-bottom: 20px; float: left;">
                            <div class="row">
                                <div class="col s12 m8 l8">
                                    <h5 style="margin: 0" class="teal-text">$<?=$event['price']?></h5>
                                    <p style="margin: 0"><?=$event['bedrooms']?> Bedroom, <?=$event['bathrooms']?> Bath</p>
                                    <h6 class="teal-text">description</h6>
                                    <p style="margin: 0"><?=$event['description']?></p>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col s12 m4 l4">
                                    <h6 class="teal-text">event dates</h6>
                                    <p>
                                        <?php foreach($event['dates'] as $date): ?>
                                            <span class="teal white-text" style="padding: 5px; margin-right: 4px; font-size: 12px"><?= date("F jS", strtotime($date['date']));?></span>
                                        <?php endforeach; ?>
                                    </p>
                                    <h6 class="teal-text">tags</h6>
                                    <p>
                                        <?php foreach($event['keywords'] as $keyword): ?>
                                            <span class="teal white-text" style="padding: 5px; margin-right: 4px"><?= $keyword['tag'] ?></span>
                                        <?php endforeach; ?>
                                    </p>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h4 class="teal-text">Sorry, but nothing matches your search</h4>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        //Search Dropdown Feature
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

        //
        //CLIENT SIDE FILTERING
        //

        //clear filters
        $('.clear-filters').click(function(){
            $('.event-result').hide();
            $('.event-result').show();
        });

        //tags
        $('.tag-select').click(function(){

            $('.event-result').hide();
            $('.event-result').show();

            var tag = $(this).html();
            var eventResults = $('.event-result');
            for(var i=0; i < eventResults.length; i++)
            {
                var tags = $(eventResults[i]).attr('data-tags').split(',');
                var hasTag = false;
                for(var j = 0; j < tags.length; j++)
                {
                    if(tags[j] == tag)
                    {
                        hasTag = true;
                    }
                }

                if(!hasTag)
                {
                    $(eventResults[i]).hide();
                }
            }
        });

        //tags
        $('.date-select').click(function(){

            $('.event-result').hide();
            $('.event-result').show();

            var date = $(this).attr('data-date');
            var eventResults = $('.event-result');
            for(var i=0; i < eventResults.length; i++)
            {
                var dates = $(eventResults[i]).attr('data-dates').split(',');
                var hasDate = false;
                for(var j = 0; j < dates.length; j++)
                {
                    if(dates[j] == date)
                    {
                        hasDate = true;
                    }
                }

                if(!hasDate)
                {
                    $(eventResults[i]).hide();
                }
            }
        });

    });
</script>