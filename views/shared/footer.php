<!--<footer class="page-footer teal">-->
<!--    <div class="footer-copyright">-->
<!--        <div class="container">-->
<!--            &copy; 2015. <a class="pink-text text-lighten-3" href="/">openhaus.it</a>-->
<!--        </div>-->
<!--    </div>-->
<!--</footer>-->
<!--<script>-->
<!--    (function($){-->
<!--        $(function(){-->
<!---->
<!--            $('.button-collapse').sideNav();-->
<!---->
<!--        }); // end of document ready-->
<!--    })(jQuery);-->
<!--</script>-->


<script>
    var LoggedIn = false;
    var id = "<?= $model->account->id ?>";
    if(id)
    {
        LoggedIn = true;
    }

    setInterval(function(){
        $.ajax({
            type: "POST",
            url: '/user/GetUnSeenCount',
            data: {},
            dataType: 'json',
            success:function(data, message){
                if(message == 'success')
                {
                    $('.notification-count').html(data);
                    if(data == 0)
                    {
                        $('.notification-count').hide();
                    }
                    else
                    {
                        $('.notification-count').show();
                        $('.notification-count').style('display', 'inlineBlock')
                    }
                }
            }
        });
    }, 2000);

</script>