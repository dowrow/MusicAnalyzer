
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
                      
                      callback(response.data || []);
                      
            });
        }, {scope: 'user_likes'});
    }
    
    
    // Progress & status
    function showModal (title, text) {
        $('#modalTitle').text(title);
        $('#modalText').text(text);
        $('#myModal').modal('show');
    }
    
    
    function showError (){
        $('#loading').hide();
        $('#title').text($('#error-title').val());
        $('#status').text($('#error-status').val());
    }
    
    function updateProgress () {
        analyzedArtistCount++;
        var percent = analyzedArtistCount / artistCount;
        var progress = percent*100;
        $('#appProgress').css('width', progress + '%');
        console.log('Total: ' + artistCount + ' Analyzed: ' + analyzedArtistCount + ' Percent: ' + percent + ' Progress: ' + progress);
    }
        
    function artistCallback (artist) {
        var initialStatus = $('#initial-status').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    
    function albumCallback (artist) {
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
            
            var MAX_ARTISTS = 10;
            
            // If no artist likes show message
            if (artists.length === 0) {
                showError();
                return;
            }
            
            if (artists.length > MAX_ARTISTS) {
                showModal('Too many cooks', 'Try with less cooks');
                artists = artists.splice(0,MAX_ARTISTS);
            }
            artistCount = artists.length || 0;
            
            // Else get stats one by one
            getStats(artists, function () {
                console.log('Finished getting stats!! :D');
                console.log(artistStats);
            });        

        }); // Get user 
    }); // End document ready
}); // End module