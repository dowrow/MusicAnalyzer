// Incrementa nº sockets
var http = require('http');
http.globalAgent.maxSockets = 100;

var request = require('request');
var LastfmAPI = require('lastfmapi');

var lfm = new LastfmAPI({
    api_key : '5554fc23346ee78a88be13fa9a5201c7',
    secret : ''
});

var web = 'https://music-analyzer.herokuapp.com';
var ARTISTS_PER_TAG = 1000;
var tags = ["acoustic", "ambient", "blues", "classical", "country",
            "electronic", "emo", "folk", "hardcore", "hip hop", "indie", 
            "jazz", "latin", "metal", "pop", "pop punk", "punk", "reggae", 
            "rnb", "rock", "soul", "world", "60s", "70s", "80s", "90s"];
var max = ARTISTS_PER_TAG * tags.length;
var count = 0;

tags.forEach(getTopArtists);

function getTopArtists (tag) {
    lfm.tag.getTopArtists({
        tag: tag,
        limit: ARTISTS_PER_TAG
    },
    function (err, res) {
        if (!err) {
            res.artist.forEach(function (artist) {
                saveAll(artist.name, function () { 
                    count++;
                    console.info(count + '/' + max + ' Ok -> ' + artist.name);
                });
            });
        }
    });
};

function saveAll (artist, callback) {
    try {
        saveArtist(artist, function(err, res, body) {
            console.info('Insertado artista ' + artist);
            saveAlbums(artist, function(err, res, body) {
                console.info('Insertados albums de ' + artist);
                saveFans(artist, function(err, res, body) {
                    console.info('Insertados fans de ' + artist);
                    saveTags(artist, function(err, res, body) {
                        console.info('Insertados tags de ' + artist);
                        saveSimilar(artist, function(err, res, body) {
                            console.info('Insertados similares a ' + artist);
                            callback();
                        });
                    });
                });
            });  
        });
    }catch (e) {
        console.error('Excepción: ' + e);
    }
}
    
function saveArtist (artist, callback) { 
    
    var query = {
        artist: artist
    };

    var successCallback = function (err, response) { 
        var data = {};
        
        if (err) {
            console.error(err);
            // Insert into DB
            data =  {
                form: {
                    name: artist,
                    url: '',
                    image: '',
                    pageid: ''
                }
            };
        } else {
            // Insert into DB
            data =   { 
                form: {
                    name: response.name,
                    url: response.url,
                    image: response.image[3]['#text'],
                    pageid: ''
                }
            };
        }
        
        var endpoint = web + '/rest/insertartist/';
        request.post(endpoint, data, callback);
    };
    
    lfm.artist.getInfo(query, successCallback);
}

function saveAlbums (artist, callback) {
    var max = 3;
    var query = {
        artist: artist,
        limit: max
    };

    var successCallback = function (err, response) {
        
        if (err) {
            console.error(err);
            callback();
            return;
        }
        
        if (response.album) {
            try {
                saveEveryAlbum(response.album.slice(0,max), callback);
            }catch (err) {
                saveEveryAlbum(response.album, callback);
            }
        } else {
            callback();
        }
    };

    lfm.artist.getTopAlbums(query, successCallback);
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

    var successCallback = function (err, response) {
        if (err) {
            console.error(err);
            saveEveryAlbum(albums, callback);
            return;
        }
        
        var data =  {
            form: {
                artist: response.artist,
                album: response.name,
                url: response.url,
                date: response.releasedate
            }
        };
        
        var endpoint = web + '/rest/insertalbum/';
        
        request.post(endpoint, data, function () {
            if (albums.length !== undefined) {
                saveEveryAlbum (albums, callback);
            } else {
                callback();
            }
        });
    };

    lfm.album.getInfo(query, successCallback);
}

function saveFans (artist, callback) {
    var max = 3;
    var query = {
        artist: artist,
        limit: max
    };

    var successCallback = function (err, response) {
        
        if (err) {
            console.error(err);
            callback();
            return;
        }
        
        if (response.user) {
           try {
                saveEveryFan(artist, response.user.slice(0, max), callback);
           } catch (err) {
                saveEveryFan(artist, response.user, callback);
           }
        } else {
            callback();
        }
    };

    lfm.artist.getTopFans(query, successCallback);
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
        
    var successCallback = function (err, response) {
        
        if (err) {
            console.error(err);
            saveEveryFan(artist, fans, callback);
            return;
        }
        
        var data =  {
            form: {
                 artist: artist,
                 age: response.age,
                 url: response.url
            }
        };
        
        var endpoint = web + '/rest/insertfan/';

        request.post(endpoint, data, function () {
            if (fans.length !== undefined) {
                saveEveryFan(artist, fans, callback);
            } else {
                callback();
            }
        });
    };

    lfm.user.getInfo(fan.name, successCallback);
}

function saveTags (artist, callback) {
    var max = 3;
    var query = {
        artist: artist,
        limit: max
    };

    var successCallback = function (err, response) {
        
        if (err) {
            console.error(err);
            callback();
            return;
        }
        
        if (response.tag) {
           try {
                saveEveryTag(artist, response.tag.slice(0, max), callback);
           } catch (err) {
                saveEveryTag(artist, response.tag, callback);
           }
        } else {
            callback();
        }
    };
    
    lfm.artist.getTopTags(query, successCallback);
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
    
    var successCallback = function (err, response) {

        if (err) {
            console.error(err);
            saveEveryTag(artist, tags, callback);
            return;
        }
        
        var data =  {
            form: {
               artist: artist,
                name: response.name,
                url: response.url 
            }
        };
        
        var endpoint = web + '/rest/inserttag/';

        request.post(endpoint, data, function () {
            if (tags.length !== undefined) {
                saveEveryTag(artist, tags, callback);
            } else {
                callback();
            }
        });
    };

    lfm.tag.getInfo(tag.name, successCallback);
}

function saveSimilar (artist, callback) {
    var max = 3;
    var query = {
        artist: artist,
        limit: max
    };

    var successCallback = function (err, response) {
        if (err) {
            console.error(err);
            callback();
            return;
        }
        if (response.artist && (response.artist[0].name !== undefined  || response.artist.name !== undefined)) {
           try {
                saveEverySimilar(artist, response.artist.slice(0, max), callback);
           } catch (err) {
                saveEverySimilar(artist, response.artist, callback);
           }
        } else {
            callback();
        }
    };
    
    lfm.artist.getSimilar(query, successCallback);
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

    var successCallback = function (err, response) {
        
        if (err) {
            console.error(err);
            saveEverySimilar(artist, similars, callback); 
            return;
        }
        
        var data =  {
            form: {
                artist: artist,
                similar: response.name,               
                url: response.url,
                image: response.image[3]['#text']
            }
           
        };

        var endpoint = web + '/rest/insertsimilar/';

        request.post(endpoint, data, function () {
            if (similars.length !== undefined) {
                saveEverySimilar(artist, similars, callback);
            } else {
                callback();
            }
        });
    };

    lfm.artist.getInfo(query, successCallback);
}    
