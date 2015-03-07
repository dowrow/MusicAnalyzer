define (['jquery', 'aggregate'], function ($, Aggregate) {
    
    var stats = [];
    
    function build (statsParam) {
        
        stats = statsParam;
    }
    
    function getAgeText () {
        
        var part1 = $('#result-age-1').val();
        var part2 = $('#result-age-2').val();
        var age = 0;
        var count = 0;
        
        // Average fan age
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist] !== 0 && stats[artist].averageFanAge !== -1) {
                    age += parseInt(stats[artist].averageFanAge); 
                    count++;
                }
            }
        }
        age = Math.round(age / count);
        
        return part1 + age + part2;
    }
    
    function getEpochText () {
        
        var part1 = $('#result-epoch-1').val();
        var part2 = $('#result-epoch-2').val();
        var part3 = $('#result-epoch-3').val();
        
        var oldestYear = (new Date()).getFullYear();
        var oldestArtist = "";
        var oldestAlbum = "";
        
        console.log(stats);
        
        // Look for the oldest album
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist] !== 0 && stats[artist].firstAlbum.length > 0) {
                    // If very old
                    var releaseYear = (new Date(stats[artist].firstAlbum[0].date)).getFullYear();
                    if (releaseYear < oldestYear) {
                        oldestYear = releaseYear;
                        oldestArtist = artist;
                        oldestAlbum = stats[artist].firstAlbum[0].name; 
                    }
                }
            }
        }
        
        return part1 + oldestYear + part2 + oldestArtist + part3 + oldestAlbum;
    }
    
    function getStyleText () {
        
        var part1 = $('#result-style').val();
        var styles = "Estilo, otro, otro";
        
        // Get all the tags
        var tags = [];
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist] !== 0 && stats[artist].tags.length > 0) {
                    for (var i = 0; i < stats[artist].tags.length; i++) {
                        tags.push(stats[artist].tags[i].name);
                    }
                }
            }
        }
        console.log('tags:');
        console.log(tags);
        var sortedTags = Aggregate.sortByFrequency(tags);
        console.log('sorted:');
        console.log(sortedTags);
        styles = sortedTags.splice(0,3).join(", ");
        return part1 + styles;
    }
    
    function getSimilarText () {
        var part1 = $('#result-similar').val();
        var similar = "Uno, dos, tres";
        
        return part1 + similar;
    }
    
    return {
        build: build,
        getAgeText: getAgeText,
        getEpochText: getEpochText,
        getStyleText: getStyleText,
        getSimilarText: getSimilarText
    };
});