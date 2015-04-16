
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
              $.get('/analyze', function (res) {
                    Analyze.startAnalyzing();
              });
          } else if (response.status === 'not_authorized') {
             FB.login(function(response) { statusChangeCallback(response); }, {scope: 'user_likes'});
          } else {
             swal("Please login.");
          }
    }
    
    function onStartClick () {
        checkLoginState();
        
        // Hide logo
        $('#logo').animate({
            opacity:0,
            height:0,
            width:0
        },{
            duration: 1000,
            complete: function () { 
                $('#logo').hide();
            } 
        });
        
        // Hide button
        $('#start').animate({
            opacity:0
        },{
            duration: 1000,
            complete: function () { 
                $('#start').hide();
                $('#loading').removeClass('hidden');
            } 
        });
        
    }
    function inviteFriends () {
        // Use FB.ui to send the Request(s)
        FB.ui({method: 'apprequests',
            title: 'Deberías probar esta app',
            message: '\Check out this Awesome App!'
        }, function (){});
   }
   
    // Attach callbacks
    $(document).ready(function () {
        $('#start').click(onStartClick);
        $('#invite').click(inviteFriends);
    });
    
});