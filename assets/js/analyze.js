
define (['jquery', 'facebook'], function ($, facebook) {
    
    function getUserMusic(callback) {
        FB.init({
            appId      : '1468034890110746',
            xfbml      : true,
            status     : true,
            cookie     : true,
            version    : 'v2.1'
        });

        FB.login(function () {
            FB.api(
                "/me/music",
                function (response) {
                  if (!response.data) {
                      console.log('Error getting user music');
                  } else {
                      callback(response.data)
                  }       
            });
        }, {scope: 'user_likes'});
    }
    
    // Get user music ASAP
    getUserMusic(function (artists) {
        console.log(artists);
    });

    // DOM callbacks
    $(document).ready(function () {
        
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