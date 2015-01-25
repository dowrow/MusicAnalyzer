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
        
        var query = {
            artist: artist
        };
        
        var successCallback = function (response) {
            
            if (response.topalbums.album) {
               saveEveryAlbum(response.topalbums.album, callback);
            } else {
                callback();
            }
        };
        
        var callbacks = {
            success: successCallback,
            error: callback
        };

        lastfm.artist.getTopAlbums(query, callbacks);
    }
    
    // Save every album recursively
    function saveEveryAlbum (albums, callback) {
        
        // Race end
        if ( albums.length === 0) {
            callback();
            return;
        }
        var album = albums.pop() || albums;
        
        console.log('Saving album');
        console.log(album);
        
        var query = {
            artist: album.artist.name,
            album: album.name
        };
        
        var successCallback = function (response) {
            var data =  {
                artist: response.album.artist,
                album: response.album.name,
                url: response.album.url,
                date: response.album.releasedate
            };
            var endpoint = '/rest/insertalbum/';
    
            $.post(endpoint, data, function () {
                if (albums.length !== undefined) {
                    saveEveryAlbum (albums, callback);
                } else {
                    callback();
                }
            });
        };
        
        var callbacks = {
            success: successCallback,
            error: function () { saveEveryAlbum(albums, callback); }
        };

        lastfm.album.getInfo(query, callbacks);
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

