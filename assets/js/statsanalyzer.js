define (['jquery', 'aggregate'], function ($, aggregate) {
    
    var stats = {};
    
    function build (statsParam) {
        stats = statsParam;
    }
    
    function getAgeText () {
        
        var part1 = $('#result-age-1').val();
        var part2 = $('#result-age-2').val();
        var age = 40;
        
        $('#age_result').text(part1 + age + part2);
       
    }
    
    function getEpochText () {
        
        var part1 = $('#result-epoch-1').val();
        var part2 = $('#result-epoch-2').val();
        var part3 = $('#result-epoch-2').val();
        
        var year = 1992;
        var artist = "Nirvana";
        var album = "Nevermind";
        
        $('#epoch_result').text(part1 + year + part2 + artist + part3 + album);
       
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