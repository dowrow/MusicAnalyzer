define (['jquery', 'LastFM', 'LastFMCache'], function ($, LastFM, LastFMCache) {
    
    var cache = new LastFMCache();
    var lastfm = new LastFM({
            apiKey    : '5554fc23346ee78a88be13fa9a5201c7',
            cache     : cache
        });
        
    // Private
    
    // DB selection methods (GET)
    function getStats (artist, callback) {
        $.get('/rest/stats/?artist=' + encodeURIComponent(artist), function (response) {
            callback(response);
        });
    }
    
    // DB insertion methods (POST)
    
    // Save methods (using LastFM API + POST)
    function saveAll (artist, callback) {
        saveArtist(artist, function(response) {
            saveAlbums(artist, function (response) {
               saveFans(artist, function (response) {
                   saveTags(artist, function (response) {
                       saveSimilar(artist, function (response) {
                           callback();
                       });
                   });
               });
            });
        });
    }
    
    function saveArtist (artist, callback) {
    
    }
    
    function saveAlbums (artist, callback) {
    
    }
    
    function saveFans (artist, callback) {
    
    }
    
    function saveTags (artist, callback) {
    
    }
    
    function saveSimilar (artist, callback) {
        
    }
    
    /*
    var query = {
        artist: 'Linkin park'
    };
    
    var callbacks = {
        success: function (response) { console.log(response); },
        error: function (response) { console.log('Error: ' + response); }
    };
    
    lastfm.artist.getInfo(query, callbacks);
    lastfm.artist.getTopTags(query, callbacks);
    */
    
    // Debug main:
    
    
    // Public interface    
    // Get artist async.
    function getStatsProxy (artist, callback) {
        
        console.log('Gettin\' stats for ' + artist + '...');
        
        // Try to get stats
        getStats(artist, function (stats) {
            console.log('Stats:' + stats);
            if (/* TODO: Check if no error*/true) {
                callback(stats);
                return;
            }
            
            // Retry after saving info
            saveAll(artist, function () {
                getStats(artist, callback);
            });
        });
        
    }
    
    return {
        getStats: getStatsProxy
    };
}); 

