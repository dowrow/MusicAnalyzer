
define (['jquery', 'facebook'], function ($, facebook) {

    FB.init({
        appId      : '1468034890110746',
        xfbml      : true,
        status     : true,
        cookie     : true,
        version    : 'v2.1'
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
        $('#start').animate({opacity:0},{duration: 500});
    }

    // Attach callbacks
    $(document).ready(function () {
        $('#start').click(onStartClick);
        
    });
    
    
});