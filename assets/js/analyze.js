
define (['jquery', 'facebook'], function ($, facebook) {
      /*
    FB.init({
        appId      : '1468034890110746',
        xfbml      : true,
        status     : true,
        cookie     : true,
        version    : 'v2.1'
    });
    
    function checkLoginState() {
        // Reset permission
        FB.getLoginStatus(function (response) { statusChangeCallback(response); });
    }
    
    function statusChangeCallback(response) {
        
          if (response.status === 'connected') {
              console.log('ok');
          } else if (response.status === 'not_authorized') {
             FB.login(function(response) { statusChangeCallback(response); }, {scope: 'user_likes'});
          } else {
             alert("Please login.");
          }
    }
    */

    // DOM callbacks
    $(document).ready(function () {
        
        //setTimeout(checkLoginState, 1000);
    
        // Animate progress bar
        $('#appProgress').css('width', '33%');
    
        // Animate dots
        setInterval(function () {
            switch ($('#loading').text()) {
                case '':
                    $('#loading').text('.');
                    break;
                case '.':
                    $('#loading').text('..');
                    break;
                case '..':
                    $('#loading').text('...');
                    break;
                case '...':
                    $('#loading').text('');
                    break;
            }
        }, 500);
        
        FB.api(
            "/v1.0/me",
            function (response) {
              if (response && !response.error) {
                console.log('Me:' + response);               
              }
            }
        );
    });
});