
define (['jquery', 'facebook', 'LastFMProxy'], function ($, facebook, LastFMProxy) {
    
    // User likes
    var artists = [];
    
    // Stats object for every artist (associative array)
    var artistStats = [];
    
    function getArtists(callback) {
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
    
    // Get stats for every artists;
    getArtists(function (artists) {
        
        
        // If no artist likes
        if (artists.length === 0) {
            // TO DO: show message
            alert('No artists');
            return;
        }
        
        // Get stats one by one
        artists.forEach(function (artist) {
            artistStats[artist] = LastFMProxy.getStats(artist.name);
        });
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