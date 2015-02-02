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
        var max = 3;
        var query = {
            artist: artist
        };
        
        var successCallback = function (response) {
            
            if (response.topalbums.album) {
                try {
                    saveEveryAlbum(response.topalbums.album.slice(0,max-1), callback);
                }catch (err) {
                    saveEveryAlbum(response.topalbums.album, callback);
                }
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
        
        // Race condition
        if ( albums.length === 0) {
            callback();
            return;
        }
        
        try {
            var album = albums.pop();
        } catch (err) {
            var album = albums;
        }
        
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
        var max = 3;
        var query = {
            artist: artist
        };
        
        var successCallback = function (response) {
            
            if (response.topfans.user) {
               try {
                    saveEveryFan(artist, response.topfans.user.slice(0, max-1), callback);
               } catch (err) {
                    saveEveryFan(artist, response.topfans.user, callback);
               }
            } else {
                callback();
            }
        };
        
        var callbacks = {
            success: successCallback,
            error: callback
        };

        lastfm.artist.getTopFans(query, callbacks);
        
    }
    
    function saveEveryFan (artist, fans, callback) {
                
        // Race condition
        if (fans.length === 0) {
            callback();
            return;
        }
        
        try {
            var fan = fans.pop();
        } catch (err) {
            var fan = fans;
        }
        
        var query = {
            user: fan.name
        };
        
        var successCallback = function (response) {
            var data =  {
                artist: artist,
                age: response.user.age,
                url: response.user.url
            };
            var endpoint = '/rest/insertfan/';
    
            $.post(endpoint, data, function () {
                if (fans.length !== undefined) {
                    saveEveryFan(artist, fans, callback);
                } else {
                    callback();
                }
            });
        };
        
        var callbacks = {
            success: successCallback,
            error: function () { saveEveryFan(artist, fans, callback); }
        };

        lastfm.user.getInfo(query, callbacks);
    }
    
    function saveTags (artist, callback) {
        var max = 3;
        var query = {
            artist: artist
        };
        
        var successCallback = function (response) {
            
            if (response.toptags.tag) {
               try {
                    saveEveryTag(artist, response.toptags.tag.slice(0, max-1), callback);
               } catch (err) {
                    saveEveryTag(artist, response.toptags.tag, callback);
               }
            } else {
                callback();
            }
        };
        
        var callbacks = {
            success: successCallback,
            error: callback
        };

        lastfm.artist.getTopTags(query, callbacks);
    }
    
    function saveEveryTag (artist, tags, callback) {
                
        // Race condition
        if (tags.length === 0) {
            callback();
            return;
        }
        
        try {
            var tag = tags.pop();
        } catch (err) {
            var tag = tags;
        }
        
        var query = {
            tag: tag.name
        };
        
        var successCallback = function (response) {
            var data =  {
                artist: artist,
                name: response.tag.name,
                url: response.tag.url
            };
            var endpoint = '/rest/inserttag/';
    
            $.post(endpoint, data, function () {
                if (tags.length !== undefined) {
                    saveEveryTag(artist, tags, callback);
                } else {
                    callback();
                }
            });
        };
        
        var callbacks = {
            success: successCallback,
            error: function () { saveEveryTag(artist, fans, callback); }
        };

        lastfm.tag.getInfo(query, callbacks);
    }
    
    function saveSimilar (artist, callback) {
        var max = 3;
        var query = {
            artist: artist
        };
        
        var successCallback = function (response) {
            if (response.similarartists.artist) {
               try {
                    saveEverySimilar(artist, response.similarartists.artist.slice(0, max-1), callback);
               } catch (err) {
                    saveEverySimilar(artist, response.similarartists.artist, callback);
               }
            } else {
                callback();
            }
        };
        
        var callbacks = {
            success: successCallback,
            error: callback
        };

        lastfm.artist.getSimilar(query, callbacks);
    }
    
    function saveEverySimilar (artist, similars, callback) {
                
        // Race condition
        if (similars.length === 0) {
            callback();
            return;
        }
        
        try {
            var similar = similars.pop();
        } catch (err) {
            var similar = similars;
        }
        
        var query = {
            artist: similar.name
        };
        
        var successCallback = function (response) {
            var data =  {
                artist: artist,
                similar: response.artist.name,               
                url: response.artist.url,
                image: response.artist.image[3]['#text']
            };
            
            var endpoint = '/rest/insertsimilar/';
    
            $.post(endpoint, data, function () {
                console.log('Similar a ' + artist);
                console.log(data);
                if (similars.length !== undefined) {
                    saveEverySimilar(artist, similars, callback);
                } else {
                    callback();
                }
            });
        };
        
        var callbacks = {
            success: successCallback,
            error: function () { saveEverySimilar(artist, similars, callback); }
        };

        lastfm.artist.getInfo(query, callbacks);
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

