
require(['jquery'], function ($) {
    
    var API_KEY = "5554fc23346ee78a88be13fa9a5201c7",
        tags = ["acoustic"],
       artistCount = 0,
       completedCount = 0,
       ARTISTS_PER_TAG = 2;
                
    tags.forEach(function (tag) {
        
        var topArtistsUrl = "http://ws.audioscrobbler.com/2.0/?method=tag.gettopartists&tag=" + tag + "&format=json&limit=" + ARTISTS_PER_TAG + "&api_key=" + API_KEY;
        
        // Get top artists for each tag
        $.get(topArtistsUrl, function (response) {
            
            response.topartists.artist.forEach(function (artist) {
                artistCount++;
                $('#count').text(completedCount + "/" + artistCount + " artists");
                console.log("Processing artist: " + artist);
                 
                // Get artist info 
                $.get("rest/GetArtistInfo?artist=" + encodeURIComponent(artist.name), function (result) {
                     console.log("Artist info --> " + result);
                     
                    // Get albums info 
                     $.get("rest/GetAlbumsInfo?artist=" + encodeURIComponent(artist.name), function (result) {
                        console.log("Albums info --> " + result);
                        
                        // Get tags info 
                        $.get("rest/GetTagsInfo?artist=" + encodeURIComponent(artist.name), function (result) {
                             console.log("Tags info --> " + result);
                             
                             // Get fans info 
                            $.get("rest/GetFansInfo?artist=" + encodeURIComponent(artist.name), function (result) {
                                 console.log("Fans info --> " + result);
                                 
                                   // Get similars info 
                                    $.get("rest/GetSimilarsInfo?artist=" + encodeURIComponent(artist.name), function (result) {
                                         console.log("Similars info --> " + result);
                                         completedCount++;
                                         $('#count').text(completedCount + "/" + artistCount + " artists");
                                    });
                            });
                        });
                     });
                     
                });
                 
             });
            
        });

    });
        
});