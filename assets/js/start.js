
define (['jquery', 'facebook', 'analyze'], function ($, facebook, Analyze) {

    FB.init({
        appId      : '1468034890110746',
        xfbml      : true,
        status     : true,
        cookie     : true,
        version    : 'v2.2'
    });

    function checkLoginState() {
        FB.getLoginStatus(function (response) { statusChangeCallback(response); });
    }
    
    function statusChangeCallback(response) {
          if (response.status === 'connected') {
              location.href='/analyze';
          } else if (response.status === 'not_authorized') {
             FB.login(function(response) { statusChangeCallback(response); }, {scope: 'user_likes'});
          } else {
             alert("Please login.");
          }
    }
    
    function onStartClick () {
        checkLoginState();
        $('#start').animate({
            opacity:0
        },{
            duration: 1000,
            complete: function () { 
                $('#start').hide();
                $('#loading').removeClass('hidden'); 
            } 
        });
        
        Analyze.startAnalyzing();
    }

    // Attach callbacks
    $(document).ready(function () {
        $('#start').click(onStartClick);
    });
    
});