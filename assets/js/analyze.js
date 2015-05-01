/**
 * Main module for analyze view
 * @param {type} $ jQuery module
 * @param {type} facebook Facebook Graph API module
 * @param {type} LastFMProxy LastFM API Wrapper module
 * @param {type} Aggregate Custom aggregation methods module
 * @returns {void}
 */
define (['jquery', 'facebook', 'LastFMProxy', 'StatsAnalyzer', 'SweetAlert'], function ($, facebook, LastFMProxy, StatsAnalyzer, SweetAlert) {
    
    // Stats object for every artist (associative array)
    var artistStats = [];
    
    // Stats for every friend who already used the app
    var friendStats = [];
    
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
        
        // Try to login after init is complete
        FB.getLoginStatus(function(response){
            FB.login(function () {
                FB.api(
                    "/me/music?fields=likes,id,name,category",
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
     * @param {boolean} success 
     * @returns {undefined}
     */
    function showModal (title, text, callback, success) {

        success = success || false;
        
        if (success) {
            SweetAlert({
                title: title,
                text: text,
                type: 'success'
            }, callback);
        } else {
            SweetAlert({
                title: title,
                text: text
            }, callback);
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
     * Callback for showing status
     * @param {type} artist
     * @returns {undefined}
     */
    function artistCallback (artist) {
        var initialStatus = $('#initial-status').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    /**
     * Callback for showing status
     * @param {type} artist
     * @returns {undefined}
     */
    function albumCallback (artist) {
         var initialStatus = $('#initial-status-album').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    /**
     * Callback for showing status
     * @param {type} artist
     * @returns {undefined}
     */
    function fanCallback (artist) {
        var initialStatus = $('#initial-status-fan').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    /**
     * Callback for showing status
     * @param {type} artist
     * @returns {undefined}
     */
    function tagCallback (artist) {
        var initialStatus = $('#initial-status-tag').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    /**
     * Callback for showing status
     * @param {type} artist
     * @returns {undefined}
     */
    function similarCallback (artist) {
        var initialStatus = $('#initial-status-similar').val();
        $('#status').text(initialStatus + ' ' + artist + '...');
    }
    
    /**
     * Get stats one by one recursively and call a callback when finished
     * @param {array} artists
     * @param {function} callback
     * @returns {void}
     */
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
    
    /**
     * Fill and show the results template
     * @returns {void}
     */
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
        $('#share_age').click(function () { 
            shareResult(ageText);
            FB.AppEvents.logEvent('ShareAge');
        });
        $('#share_epoch').click(function () { 
            shareResult(epochText); 
            FB.AppEvents.logEvent('ShareEpoch');
        });
        $('#share_style').click(function () { 
            shareResult(styleText); 
            FB.AppEvents.logEvent('ShareStyle');
        });
        $('#share_similar').click(function () { 
            shareResult(similarText); 
            FB.AppEvents.logEvent('ShareSimilar');
        });
        
        // Ad "How does it work?" links
        $('#howAge').click(function () { 
            showModal($('#how-button').val(), $('#how-age').val()); 
            FB.AppEvents.logEvent('HowAge');
        });
        $('#howStyle').click(function () { 
            showModal($('#how-button').val(), $('#how-style').val()); 
            FB.AppEvents.logEvent('HowStyle');
        });
        $('#howEpoch').click(function () { 
            showModal($('#how-button').val(), $('#how-epoch').val()); 
            FB.AppEvents.logEvent('HowEpoch');
        });
        $('#howSimilar').click(function () { 
            showModal($('#how-button').val(), $('#how-similar').val()); 
            FB.AppEvents.logEvent('HowSimilar');
        });
        
        
        $('#process').hide();
        $('#results').removeClass('hidden');
        $('#results').animate({
            maxHeight: '1000000px',
            opacity:1
        },{
            duration: 1000
        });
        
        drawChart();
    }
     
    
    function drawChart () {
        
        
        var names = [];
        var values = [];
        
        // Ad friend values
        friendStats.forEach(function (stats) {
            if (stats.value[0].age !== null) {
                names.push(stats.name);
                values.push(parseFloat(stats.value[0].age));
            }
        });
        
        // Add own values
        var myName = $('#you').val();        
        names.push(myName);
        values.push(StatsAnalyzer.getMusicalAge());
        
        $(function () { 
            $('#chart').highcharts({
                    title:{
                        text:''
                    },
                    credits: false,
                    chart: {
                        type: 'bar',
                        backgroundColor: '#eee'
                    },
                    xAxis: {
                        categories: names,
                        title: {
                            enabled: false
                        }
                    },
                    yAxis: {
                        title: {
                            enabled: false
                        }
                    },
                    series: [{
                        name: $('#musical-age').val(),
                        data: values,
                        color: '#337ab7',
                        events: {
                            legendItemClick: function () {
                                return false;
                            }
                        }
                    }],
                    column: {
                        events: {
                            legendItemClick: function () {
                                return false; 
                            }
                        }
                    },
                    allowPointSelect: false,
                    point: {
                        events: {
                            legendItemClick: function () {
                                return false;
                            }
                        }
                    }
            });
        });
    }
    
    /**
     * Select the n artits with the most likes
     * @param {type} artists
     * @param {type} n
     * @returns {@exp;artists@call;splice}
     */
    function selectTopRated (artists, n) {
        // Sort from more to less likes
        artists.sort(function (a, b) {
            return b.likes - a.likes;
        });
        return artists.splice(0,n);
    }
    
    /**
     * Share a result to the Facebook timeline
     * @param {type} message
     * @returns {undefined}
     */
    function shareResult (message) {
        var wallPost = {
            method: 'feed',
            picture: $('#share-image').val(),
            link: 'https://apps.facebook.com/music-analyzer',
            name: message,
            caption: "music-analyzer.herokuapp.com",
            description: $('#description').val()
        };
        FB.ui(wallPost);
    }
    
    /**
     * Start the analysis
     * @param  {obj} In-app friends stats
     * @returns {undefined}
     */
    function startAnalyzing (friendStatsObj) {
        
        // Save friendStats
        friendStats = friendStatsObj;
        
        // Set title
        $('#title').text($('#analyze-title').val());
        
        // Get user artists
        getArtists(function (artists) {
            
            var MAX_ARTISTS = 10;
            
            // If no artist likes show message
            if (artists.length === 0) {
                showModal($('#error-title').val(), $('#error-status').val(), function () {
                    document.location = '/';
                });   
            }
            // If too much musicians  select the top 10 sorting by likes count
            if (artists.length > MAX_ARTISTS) {
                artists = selectTopRated(artists, MAX_ARTISTS);
            }
            
            artistCount = artists.length || 0;
            
            // Else get stats one by one
            getStats(artists, function () {
                showResults();
            });        

        });
    }
    
    /**
     * PUBLIC INTERFACE
     */
    return {
        startAnalyzing: startAnalyzing
    };
    
}); // End module