define (['jquery'], function ($) {
    
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

    // Attach callbacks
    $('#start').click(checkLoginState);
    
});