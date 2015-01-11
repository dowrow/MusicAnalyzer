define (['jquery', 'LastFM', 'LastFMCache'], function ($, LastFM, LastFMCache) {
    
    var cache = new LastFMCache();
    var lastfm = new LastFM({
            apiKey    : '5554fc23346ee78a88be13fa9a5201c7',
            cache     : cache
        });
        
    // Private
    
    // DB selection methods (GET)
    function getStats (artist, success, error) {
        
    }
    
    // DB insertion methods (POST)
    
    // Save methods (using LastFM API + POST)
    function saveArtist (artist) {
    
    }
    
    function saveAlbums (artist) {
    
    }
    
    function saveFans (artist) {
    
    }
    
    function saveTags (artist) {
    
    }
    
    function saveSimilar (artist) {
        
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
    function getStatsProxy (artist, artistCallback, albumsCallback, fansCallback, tagsCallback, similarCallback) {
        console.log('TODO. Getting stats for:' + artist);
        i = 999999;
        while (i--) {
            i = i;
        }
        return {};
    }
    
    return {
        getStats: getStatsProxy
    };
}); 

