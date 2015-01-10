  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1468034890110746',
      xfbml      : true,
      version    : 'v2.1'
    });
  };

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/all.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));

define (['jquery'], function ($) {
    
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
    

    // DOM callbacks
    $(document).ready(function () {
        
       

        checkLoginState();
    
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
    });
    
});