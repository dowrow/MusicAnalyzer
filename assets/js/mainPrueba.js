define (['jquery', 'LastFM', 'LastFMCache'], function ($, LastFM, LastFMCache) {
    
    var cache = new LastFMCache(),
        lastfm = new LastFM({
            apiKey    : '5554fc23346ee78a88be13fa9a5201c7',
            cache     : cache
        });
   
    var query = {
        artist: 'Linkin park'
    };
    
    var callbacks = {
        success: function (response) { console.log(response); },
        error: function (response) { console.log('Error: ' + response); }
    };
    
    lastfm.artist.getInfo(query, callbacks);
    lastfm.artist.getTopTags(query, callbacks);
    
});