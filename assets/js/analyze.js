/**
 * Main module for analyze view
 * @param {type} $ jQuery module
 * @param {type} facebook Facebook Graph API module
 * @param {type} LastFMProxy LastFM API Wrapper module
 * @param {type} Aggregate Custom aggregation methods module
 * @returns {void}
 */
define (['jquery', 'facebook', 'LastFMProxy', 'StatsAnalyzer'], function ($, facebook, LastFMProxy, StatsAnalyzer) {
    
    // Stats object for every artist (associative array)
    var artistStats = [];
    
    // Number of artists liked by the user
    var artistCount = 0;

    // Number of artist already analyzed
    var analyzedArtistCount = 0;
    
    /**
     * Try to login and get an array of musicians
     * @param {type} callback
     * @returns {undefined}
     */
    function getArtists(callback) {
        FB.init({
            appId      : '1468034890110746',
            xfbml      : true,
            status     : true,
            cookie     : true,
            version    : 'v2.1'
        });
        
        // Try to login after init is complete
        FB.getLoginStatus(function(response){
            FB.login(function () {
                FB.api(
                    "/me/music?fields=likes,id,name, category",
                    function (response) {
                          var likes = response.data || [];
                          var artists = [];
                          
                          // Filter by  category
                          likes.forEach(function (like) {
                              if(like.category === "Musician/band") {
                                  artists.push(like);
                              }
                          });
                                                    
                          callback(artists); 

                });
            }, {scope: 'user_likes'});
        });
       
    }
        
    /**
     * Show the modal window with a given text
     * @param {type} title Window title to show
     * @param {type} text Text to show
     * @param {function} callback 
     * @returns {undefined}
     */
    function showModal (title, text, callback) {
        $('#modalTitle').text(title);
        $('#modalText').text(text);
        $('#myModal').modal('show');
        if (callback) {
            $('#modalOk').click(callback);
            $('#modalClose').click(callback);
        }
    }
    
    /**
     * Update progress bar as analyzedArtistCound increases
     * @returns {undefined}
     */
    function updateProgress () {
        analyzedArtistCount++;
        var percent = analyzedArtistCount / artistCount;
        var progress = percent*100;
        $('#appProgress').css('width', progress + '%');
    }
    
    /**
     * 
     * @param {type} artist
     * @returns {undefined}
     */
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
            artistStats[artist.name] = JSON.parse(stats);
            getStats(artists, callback);
            
        });
    }
    
    function showResults() {
        
        // Analyze the stats
        StatsAnalyzer.build(artistStats);
        
        // Get the results text
        var ageText = StatsAnalyzer.getAgeText();
        var epochText = StatsAnalyzer.getEpochText();
        var styleText = StatsAnalyzer.getStyleText();
        var similarText = StatsAnalyzer.getSimilarText();
        
        // Print the resutls
        $('#age_result').text(ageText);
        $('#epoch_result').text(epochText);
        $('#style_result').text(styleText);
        $('#similar_result').text(similarText);
        
        // Add sharing event handlers shareResult('prueba');
        $('#share_age').click(function () { shareResult(ageText); });
        $('#share_epoch').click(function () { shareResult(epochText); });
        $('#share_style').click(function () { shareResult(styleText); });
        $('#share_similar').click(function () { shareResult(similarText); });
        
        $('#process').hide();
        $('#results').removeClass('hidden');
        $('#results').animate({
            maxHeight: '1000px',
            opacity:1
        },{
            duration: 1000
        });
            
    }
    
    function selectTopRated (artists, n) {
        // Sort from more to less likes
        artists.sort(function (a, b) {
            return b.likes - a.likes;
        });
        return artists.splice(0,n);
    }
    
    function shareResult (message) {
        var wallPost = {
            method: 'feed',
            picture: $('#share-image').val(),
            link: 'https://apps.facebook.com/music-analyzer',
            name: "name",
            caption: "caption",
            description: "description",
            message:"message"
        };
        
        FB.ui(wallPost);
        /*
        FB.login(function(loginResponse) {
            if (!loginResponse || loginResponse.error) {
                // No permission
                console.log('Login error');
            } else {
                FB.api('/me/feed', 'post', wallPost , function(response) {
                    if (!response || response.error) {
                        console.log('Hubo un error');
                        console.log(response);
                    } else {
                        console.log('Posteado correctamente');
                    }
                });
            }
        }, {scope: 'publish_actions'});
        */
    }
    
    // DOM callbacks
    $(document).ready(function () {
        
        // Get user artists
        getArtists(function (artists) {
            
            var MAX_ARTISTS = 10;
            
            // If no artist likes show message
            if (artists.length === 0) {
                showModal($('#error-title').val(), $('#error-status').val(), function () {
                    document.location = '/';
                });   
            }
            // If too much musicians
            if (artists.length > MAX_ARTISTS) {
                artists = selectTopRated(artists, MAX_ARTISTS);
            }
            
            artistCount = artists.length || 0;
            
            // Else get stats one by one
            getStats(artists, function () {
                showResults();
            });        

        }); // Get user artists
    }); // End document ready
}); // End module