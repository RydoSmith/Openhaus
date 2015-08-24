<div class="container-fix">
    <form action="/event/create" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="page" id="page-1">
            <span class="page-header teal-text">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h5>When is your open house?</h5>
                            <p class="grey-text">
                                Select the dates which you will have an open house and then <br>
                                specify the best times to drop by.
                            </p>
                        </div>
                    </div>
                </div>
            </span>
            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="teal-text" id="action-title">Pick a date & time</h5>
                        </div>
                        <div class="col s6 m6 l6">
                            <h5 class="teal-text">Selected dates & times</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 m6 l6">
                            <p class="action-message" style="font-size: 12px; padding-bottom: 10px;">Choose the date you're hosting your event</p>
                            <input class="datepicker btn pink" placeholder="Choose a day" style="visibility: hidden" />
                            <input class="timepicker-start btn pink" placeholder="Choose a time" style="visibility: hidden" />
                            <input class="timepicker-end btn pink" placeholder="Choose a time" style="visibility: hidden" />
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="selected-dates"><p class="teal-text"><strong>No dates have been selected</strong></p></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-action">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="waves-effect waves-light btn white-text next-btn btn-large">Next</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page" id="page-2" style="display: none">
            <span class="page-header teal-text">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h5>Where is your open house?</h5>
                            <p class="grey-text">
                                Mark your spot on the map and tell the world where your party is <br>
                                gonna be.
                            </p>
                        </div>
                    </div>
                </div>
            </span>
            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <input id="address" type="text" class="controls" placeholder="Enter a location" name="location">
                            <div id="map-container">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-action">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="waves-effect waves-light btn white-text next-btn btn-large">Next</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page" id="page-3" style="display: none">
            <span class="page-header teal-text">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h5>What are you showing?</h5>
                            <p class="grey-text">
                                Give the basic information about your listing and what makes it <br>
                                awesome.
                            </p>
                        </div>
                    </div>
                </div>
            </span>
            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col s8 m8 l8">
                            <h5 class="grey-text">Listing Price</h5>
                            <input placeholder="price" name="price" type="text" class="validate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s8 m8 l8">
                            <h5 class="grey-text">Details</h5>
                            <div class="row">
                                <div class="input-field col s4 m4 l4">
                                    <select name="bedrooms">
                                        <option value="1" selected>1 Bedroom</option>
                                        <option value="2">2 Bedrooms</option>
                                        <option value="3">3 Bedrooms</option>
                                        <option value="4">4 Bedrooms</option>
                                        <option value="5">5 Bedrooms</option>
                                        <option value="6">6+ Bedrooms</option>
                                    </select>
                                    <label>Bedrooms</label>
                                </div>
                                <div class="input-field col s4 m4 l4">
                                    <select name="bathrooms">
                                        <option value="1" selected>1 Bathroom</option>
                                        <option value="2">2 Bathrooms</option>
                                        <option value="3">3 Bathrooms</option>
                                        <option value="4">4 Bathrooms</option>
                                        <option value="5">5 Bathrooms</option>
                                        <option value="6">6+ Bathrooms</option>
                                    </select>
                                    <label>Bathrooms</label>
                                </div>
                                <div class="input-field col s4 m4 l4">
                                    <select name="type">
                                        <option value="house" selected>House</option>
                                        <option value="townhouse">Townhouse</option>
                                        <option value="condo">Condo</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <label>Type</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s8 m8 l8">
                            <h5 class="grey-text">Keywords</h5>
                            <input placeholder="unique features of your listing eg waterfront, rustic" id="keywords" type="text">
                            <ul class="tag-display">

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="grey-text">Photography</h5>
                            <div class="row">
                                <div class="col s3 m3 l3">
                                    <div class="image-upload">
                                        <a class="btn-floating btn-large waves-effect waves-light pink"><i class="material-icons">add</i></a>
                                    </div>
                                </div>
                                <div class="col s3 m3 l3">
                                    <div class="image-upload">
                                        <a class="btn-floating btn-large waves-effect waves-light pink"><i class="material-icons">add</i></a>
                                    </div>
                                </div>
                                <div class="col s3 m3 l3">
                                    <div class="image-upload">
                                        <a class="btn-floating btn-large waves-effect waves-light pink"><i class="material-icons">add</i></a>
                                    </div>
                                </div>
                                <div class="col s3 m3 l3">
                                    <div class="image-upload">
                                        <a class="btn-floating btn-large waves-effect waves-light pink"><i class="material-icons">add</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-action">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div id="img-guids"></div>
                            <a href="#" class="waves-effect waves-light btn white-text next-btn">Next</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page" id="page-4" style="display: none">
            <span class="page-header teal-text">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h5>Additional Details</h5>
                            <p class="grey-text">
                                Tell us about yourself and what makes your open house unique.
                            </p>
                        </div>
                    </div>
                </div>
            </span>
            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col s8 m8 l8">
                            <h5 class="grey-text">Event Name</h5>
                            <input placeholder="Name your event" type="text"  name="event_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s8 m8 l8">
                            <h5 class="grey-text">Event Description</h5>
                            <textarea id="textarea1" class="materialize-textarea" placeholder="Describe what makes your open house unique" name="event_description"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s8 m8 l8">
                            <h5 class="grey-text">Privacy Settings</h5>
                            <p>
                                <input name="privacy" type="radio" value="public" checked/>
                                <label for="test1">Public page: list this event on Openhaus.it and search engines</label>
                            </p>
                            <p>
                                <input name="privacy" type="radio" value="private" />
                                <label for="test2">Private page: do not list this event publicly</label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-action">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="waves-effect waves-light btn teal white-text">Finish</button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
<script src="/public/js/jquery.geocomplete.js"></script>
<script>
    $(document).ready(function() {

        //Initialize controls
        $('select').material_select();

        //
        //Date functionality
        //

        $('.datepicker').hide();
        $('.timepicker-start').hide();
        $('.timepicker-end').hide();


        var newDate = {}; //used when adding a date object
        var selectedDates = []; //stores the added dates

        var isSelectingDate = true;
        var isSelectingStartTime = false;
        var isSelectingEndTime = false;

        var datePicker = null;
        var startTimePicker = null;
        var endTimePicker = null;

        datePicker = $('.datepicker').pickadate({
            formatSubmit: 'yyyy/mm/dd',
            hiddenName: true,
            today: null,
            clear: null,
            close: null,
            onClose: function()
            {
                if(isSelectingDate)
                {
                    this.open();
                }
                else
                {
                    $('.action-message').html('You have selected <strong class="teal-text">' + newDate.date + '</strong>. Now choose a start time.');
                    startTimePicker.pickatime("picker").open();
                }
            },
            onSet: function(v)
            {
                var selectedDate = this.get();
                if(selectedDate)
                {
                    newDate = { 'id': guid(), 'date': selectedDate };

                    isSelectingDate = false;
                    isSelectingStartTime = true;
                    isSelectingEndTime = true;
                }
            },
            onStart: function() {
                this.open()
            }
        });

        startTimePicker = $('.timepicker-start').pickatime({
            today: null,
            clear: null,
            close: null,
            onClose: function()
            {
                if(isSelectingStartTime)
                {
                    this.open();
                }
                else
                {
                    $('.action-message').html('You have selected <strong class="teal-text">' + newDate.date + "</strong> at <strong class=\"teal-text\">" + newDate.startTime + '</strong>. When does it end?');
                    endTimePicker.pickatime("picker").open();
                }
            },
            onSet: function()
            {
                var selectedTime = this.get();
                if(selectedTime)
                {
                    newDate.startTime = selectedTime;

                    isSelectingEndTime = true;
                    isSelectingStartTime = false;
                    isSelectingDate = false;
                }
            }
        });

        endTimePicker = $('.timepicker-end').pickatime({
            today: null,
            clear: null,
            close: null,
            onClose: function()
            {
                if(isSelectingEndTime)
                {
                    this.open();
                }
                else
                {
                    if(selectedDates.length == 1)
                    {
                        $('.action-message').html('Your event begins on <strong class="teal-text">' + newDate.date + '</strong> from <strong class="teal-text">' + newDate.startTime + '</strong> to <strong class=\"teal-text\">' + newDate.endTime + '</strong>. You can add another date.');
                        datePicker.pickadate("picker").open();
                    }
                    else
                    {
                        $('.action-message').html('Great! You\'ve added another date <strong class="teal-text">' + newDate.date + '</strong> from <strong class="teal-text">' + newDate.startTime + '</strong> to <strong class=\"teal-text\">' + newDate.endTime + '</strong>. You can add another date.');
                        datePicker.pickadate("picker").open();
                    }

                    //Clear new date after used in message
                    newDate = {};
                }
            },
            onSet: function()
            {
                var selectedTime = this.get();
                if(selectedTime)
                {
                    newDate.endTime = selectedTime;

                    selectedDates.push(newDate);

                    renderDates();

                    isSelectingEndTime = false;
                    isSelectingStartTime = false;
                    isSelectingDate = true;
                }
            }
        });



        //Display dates in the UI
        function renderDates()
        {
            var sd = $('.selected-dates');

            //Clear selected dates
            sd.html('');

            //Add each selected date to the UI
            for(var i = 0; i < selectedDates.length; i++)
            {
                sd.append(createDateCard(selectedDates[i]));
            }
        }

        function createDateCard(d)
        {
            //Create the UI element to be appended
            return "<span class=\"date-card\">On " + d.date + " from " + d.startTime + " to " + d.endTime + "</span><input type=\"hidden\" name=\"dates[]\" value=\"" + d.date + "-" + d.startTime + "-" + d.endTime + "\"/>";
        }

        //
        //End date features
        //



        //Initialize multi-step page functionality
        var selectedPage = 1;

        $('.next-btn').click(function(){
            selectedPage++;

            hidePages();
            showPage();

            //If users has navigation to the second page (with the map)
            //then try to geolocate and render map to users location
            if(selectedPage == 2)
            {
                if ("geolocation" in navigator) {
                    /* geolocation is available */
                    navigator.geolocation.getCurrentPosition(function(position) {
                        $('#address').geocomplete("find", position.coords.latitude + ", " + position.coords.longitude);
                        google.maps.event.trigger(document.getElementById('map'), 'resize');
                    });
                } else {
                    /* geolocation IS NOT available */
                    $('#address').trigger("geocode");
                }
            }
        });

        $('.prev-btn').click(function(){
            selectedPage--;
            hidePages();
            showPage();
        });

        function hidePages()
        {
            $('#page-1').hide();
            $('#page-2').hide();
            $('#page-3').hide();
            $('#page-4').hide();
        }

        function showPage()
        {
            $('#page-'+selectedPage).show();
        }
        //end multi-step page


        //
        //Google map autocomplete
        //
        $('#address').geocomplete({
            map:  '#map',
            mapOptions: {
                disableDefaultUI: true
            }
        });
        //end google map autocomplete


        //
        //tag feature
        //
        var tags = [];
        $('body').keyup(function(e)
        {
            if(e.keyCode == 32)
            {
                if($('#keywords').is(':focus'))
                {
                    tags.push($('#keywords').val());
                    $('#keywords').val('');
                    renderTags();
                }
            }
        });

        function renderTags()
        {
            $('.tag-display').html('');
            for(var i = 0; i < tags.length; i++)
            {
                $('.tag-display').append('<li>' + tags[i] + '</li><input type="hidden" name="tags[]" value="' + tags[i] + '">');
            }

        }

        //end tags

        //
        //Image upload
        //
        $(".image-upload").dropzone({
            url: '/event/imageupload',
            'maxFiles': 1,
            'autoProcessQueue': true,
            'uploadMultiple': false,
            'init': function()
            {
                this.on("addedfile", dropzoneFileAdded);
                this.on("success", fileUploaded);
            }
        });

        function dropzoneFileAdded(file)
        {
            var p = file.previewElement.parentElement;
            $(p).children('a').hide();
            $(p).css('padding', '0');
        }

        function fileUploaded(obj, guid)
        {
            $('#img-guids').append('<input type="hidden" name="images[]" value="' + guid + '">');
        }

        //End image upload

    });
</script>
