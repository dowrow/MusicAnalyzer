define (['jquery', 'aggregate'], function ($, aggregate) {
    
    var stats = [];
    
    function build (statsParam) {
        
        stats = statsParam;
    }
    
    function getAgeText () {
        
        var part1 = $('#result-age-1').val();
        var part2 = $('#result-age-2').val();
        var age = 0;
        var count = 0;
        console.log(stats);
        // Average fan age
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist].averageFanAge !== -1) {
                    console.log('fan age ' stats[artist].averageFanAge);
                    age += parseInt(stats[artist].averageFanAge); 
                    count++;
                }
            }
        }
        age = Math.round(age / count);
        
        $('#age_result').text(part1 + age + part2);
    }
    
    function getEpochText () {
        
        var part1 = $('#result-epoch-1').val();
        var part2 = $('#result-epoch-2').val();
        var part3 = $('#result-epoch-3').val();
        
        var year = 1992;
        var artist = "Nirvana";
        var album = "Nevermind";
        
        $('#epoch_result').text(part1 + year + part2 + artist + part3 + album);
    }
    
    function getStyleText () {
        
        var part1 = $('#result-style').val();
        var styles = "Estilo, otro, otro";
        
        $('#style_result').text(part1 + styles);
    }
    
    function getSimilarText () {
        var part1 = $('#result-similar').val();
        var similar = "Uno, dos, tres";
        
        $('#similar_result').text(part1 + similar);     
    }
    
    return {
        build: build,
        getAgeText: getAgeText,
        getEpochText: getEpochText,
        getStyleText: getStyleText,
        getSimilarText: getSimilarText
    };
});