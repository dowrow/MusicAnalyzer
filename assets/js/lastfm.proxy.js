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
        saveArtist(artist, function() {
            saveAlbums(artist, function () {
               saveFans(artist, function () {
                   saveTags(artist, function () {
                       saveSimilar(artist, function () {
                           callback();
                       });
                   });
               });
            });
        });
    }
    
    function saveArtist (artist, callback) {
        
        var query = {
            artist: encodeURIComponent(artist)
        };
        
        var realCallback = function (response) { 
            console.log('Query artist to lastfm:' + artist);
            console.log(response);
            callback(); 
        };
        
        var callbacks = {
            success: realCallback,
            error: realCallback
        };

        lastfm.artist.getInfo(query, callbacks);
    }
    
    function saveAlbums (artist, callback) {
        callback();
    }
    
    function saveFans (artist, callback) {
        callback();
    }
    
    function saveTags (artist, callback) {
        callback();
    }
    
    function saveSimilar (artist, callback) {
        callback();
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
        
        // Try to get stats
        getStats(artist, function (stats) {
            
            // If ok
            if (stats !== '0') {
                callback(stats);
                return;
            }
            
            // Else retry after saving info
            saveAll(artist, function () {
                getStats(artist, callback);
            });
        });
        
    }
    
    return {
        getStats: getStatsProxy
    };
}); 

