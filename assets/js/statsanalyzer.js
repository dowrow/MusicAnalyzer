define (['jquery', 'aggregate'], function ($, aggregate) {
    
    var stats = {};
    
    function build (statsParam) {
        stats = statsParam;
    }
    
    function getAgeText () {
        $('#age_result').text("Escuchas la misma música que una persona de 40 años.");
       
    }
    
    function getEpochText () {
        $('#epoch_result').text("Escuchas la misma música que una persona de 40 años.");
       
    }
    
    function getStyleText () {
        $('#style_result').text("Escuchas la misma música que una persona de 40 años.");
       
    }
    
    function getSimilarText () {
        $('#similar_result').text("Escuchas la misma música que una persona de 40 años.");
       
    }
    
    return {
        build: build,
        getAgeText: getAgeText,
        getEpochText: getEpochText,
        getStyleText: getStyleText,
        getSimilarText: getSimilarText
    };
});