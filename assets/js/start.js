
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
                    var friendStats = JSON.parse(res);
                    Analyze.startAnalyzing(friendStats);
              });
          } else if (response.status === 'not_authorized') {
             FB.login(function(response) { statusChangeCallback(response); }, {scope: 'user_likes,public_profile,user_friends'});
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
        FB.ui({
            method: 'apprequests',
            message: $('#try-music-analyzer').val()
        }, function (){});
   }
   
    // Attach callbacks
    $(document).ready(function () {
        $('#start').click(onStartClick);
        $('#invite').click(inviteFriends);
        $('#start').removeClass('hidden');
        $('#chart').click(function (e) {
            e.stopPropagation();
            return false; 
        });
    });
    
});