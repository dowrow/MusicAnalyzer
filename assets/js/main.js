
/*
 * Diego Castaño 2014
 */

// Requires FaceBooks JS SDK
(function (FB) {
    
    function logInCallback (response) {
         if(response.status === 'connected') {
            // Route to new screen
            location.href = '/music';
        } else {
            alert('Unable to log in');
         }
    }
    
    function logIn() {
        FB.login(logInCallback, {scope: 'user_likes'});
    }
    
    /*
     * Event handlers
     */
    
    // Init FB SDK
    document.addEventListener('DOMContentLoaded', function () {
        FB.init({
            appId: 1468034890110746,
            frictionlessRequests: true,
            status: true,
            version: 'v2.0'
        });
    });
    
    // Handle login
    document.querySelector('#logIn').addEventListener('click', logIn);

})(FB);
