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
            artist: artist
        };
        
        var successCallback = function (response) { 
            
            // Insert into DB
            var data =  {
                name: response.artist.name,
                url: response.artist.url,
                image: response.artist.image[3]['#text']
            };
            
            console.log('Inserting artist');
            console.log(data);
            
            var endpoint = '/rest/insertartist/';
            
            $.post(endpoint, data, callback);
             
        };
        
        var callbacks = {
            success: successCallback,
            error: callback
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

