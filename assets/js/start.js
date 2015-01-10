define (['jquery'], function ($) {
    
    function checkLoginState() {
        FB.getLoginStatus(function (response) { statusChangeCallback(response); });
    }
    
    function statusChangeCallback(response) {
          if (response.status === 'connected') {
              console.log('Conectado');
          } else if (response.status === 'not_authorized') {
             console.log('En FB pero sin login en la app');
          } else {
             console.log('Sin FB');
          }
    }
    
    // Init. FB SDK
    window.fbAsyncInit = function() {
       
        
        // If session is lost redirect to login
        FB.Event.subscribe('auth.login', onLogin);
        
        function onLogin (response) {
            
            if (response.status !== 'connected') {
                location.href = '/';
            } else {
                console.log('conected');
            }
        }
    };
    
    // Load async. FB SDK
    (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&appId=1468034890110746&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    
    // Attach callbacks
    $('#start').click(checkLoginState);
    
});