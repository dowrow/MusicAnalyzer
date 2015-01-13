
define (['jquery', 'facebook', 'LastFMProxy'], function ($, facebook, LastFMProxy) {
    
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
                      //debug 
                      callback( [{name:'Eminem'}, {name:'Linkin Park'}]);
                  } else {
                      callback(response.data);
                  }       
            });
        }, {scope: 'user_likes'});
    }
    
    // Get user artists
    getArtists(function (artists) {
        
        // If no artist likes show message
        if (artists.length === 0) {
            // TO DO: show message
            alert('No artists');
            return;
        }
        
        // Else get stats one by one
        getStats(artists, function () {
            console.log('Finished getting stats!! :D');
            console.log(artistStats);
        });        
        
    });
    
    // Get stats one by one recursively and call a callback when finished
    function getStats (artists, callback) {
        
        // Race end: empty array
        if (artists.length === 0) {
            callback();
            return;
        }
        
        // Pop an artist from array
        var artist = artists.pop();
        
        // Get stats for the popped artist and then continue
        LastFMProxy.getStats(artist.name, function (stats) { 
            artistStats[artist.name] = stats;
            getStats(artists, callback);
        });
    }
        
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