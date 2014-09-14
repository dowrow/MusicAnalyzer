
/*
 * Diego Castaño 2014
 */

(function (globalScope) {
    
     // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log(response);
      if (response.status === 'connected') {
        // Route to new screen
        location.href = '/music';
      } else {
        alert('Unable to log-in');
      }
    }

    // This function is called when someone finishes with the Login
    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }
    
    /*
     * Event handlers
     */
    
    // Init FB SDK
    window.fbAsyncInit = function() {
        FB.init({
          appId      : '1468034890110746',
          cookie     : true,  // enable cookies to allow the server to access 
                              // the session
          xfbml      : true,  // parse social plugins on this page
          version    : 'v2.1' // use version 2.1
        });
    };
    
    // If session is lost redirect to login
    FB.Event.subscribe('auth.login', function(response) {
        if (response.status !== 'connected') {
            location.href = '/';
        }
    });
    
    // Load the SDK asynchronously
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
   
   // Add to global scope
   globalScope.checkLoginState = checkLoginState;
   
})(this);
