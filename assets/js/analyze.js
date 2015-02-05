
define (['jquery', 'facebook', 'LastFMProxy'], function ($, facebook, LastFMProxy) {
    
    // Stats object for every artist (associative array)
    var artistStats = [];
    
    // Number of artists liked by the user
    var artistCount = 0;

    // Number of artist already analyzed
    var analyzedArtistCount = 0;
    
    
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
                      // TO DO: Show message
                  } else {
                      callback(response.data);
                      artistCount = response.data.length || 0;
                  }       
            });
        }, {scope: 'user_likes'});
    }
    
    
    // Progress & status
    
    function updateProgress () {
        analyzedArtistCount++;
        var percent = analyzedArtistCount / artistCount;
        var progress = percent*100;
        $('#appProgress').css('width', progress + '%');
        console.log('Total: ' + artistCount + ' Analyzed: ' + analyzedArtistCount + ' Percent: ' + percent + ' Progress: ' + progress);
    }
    
    
    function updateStatus (artist) {
        var initialStatus = $('#initial-status').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    
    function artistCallback (artist) {
        var initialStatus = $('#initial-status').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    
    function albumCallback (artists) {
         var initialStatus = $('#initial-status-album').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    
    function fanCallback (artist) {
        var initialStatus = $('#initial-status-fan').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    
    function tagCallback (artist) {
        var initialStatus = $('#initial-status-tag').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    
    function similarCallback (artist) {
        var initialStatus = $('#initial-status-similar').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    
    // Get stats one by one recursively and call a callback when finished
    function getStats (artists, callback) {
        
        // Race end: empty array
        if (artists.length === 0) {
            callback();
            return;
        }
        
        // Pop an artist from array
        var artist = artists.pop();
        
        updateStatus(artist.name);
        
        // Get stats for the popped artist and then continue
        LastFMProxy.getStats(artist.id, artist.name, artistCallback, albumCallback, fanCallback, tagCallback, similarCallback, function (stats) { 
            updateProgress();
            artistStats[artist.name] = stats;
            getStats(artists, callback);
            
        });
    }
    
    
    // DOM callbacks
    $(document).ready(function () {
        
        // Get user artists
        getArtists(function (artists) {

            // If no artist likes show message
            if (artists.length === 0) {
                // TO DO: show message
                console.log('No artists');
                return;
            }

            // Else get stats one by one
            getStats(artists, function () {
                console.log('Finished getting stats!! :D');
                console.log(artistStats);
            });        

        }); // Get user 
    }); // End document ready
}); // End module