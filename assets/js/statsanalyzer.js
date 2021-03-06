define (['jquery', 'aggregate'], function ($, Aggregate) {
    
    var stats = [];
    
    function build (statsParam) {
        
        stats = statsParam;
        return true;
    }
    
    function getAgeText () {
        var part1 = $('#result-age-1').val() || 'part_1';
        var part2 = $('#result-age-2').val() || 'part_2';
        var age = 0;
        var count = 0;
        
        // Average fan age
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist] !== 0 && stats[artist] !== 1 && stats[artist].averageFanAge !== -1) {
                    age += parseInt(stats[artist].averageFanAge); 
                    count++;
                }
            }
        }
        
        if (count > 0) {
            age = Math.round(age / count);
            return part1 + age + part2;
        } else {
            return ($('#result-no-age').val() || 'No age');
        }
        
        
    }
    
    function getMusicalAge () {
        var age = 0;
        var count = 0;
        
        // Average fan age
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist] !== 0 && stats[artist] !== 1 && stats[artist].averageFanAge !== -1) {
                    age += parseInt(stats[artist].averageFanAge); 
                    count++;
                }
            }
        }
        
        if (count > 0) {
            age = Math.round(age / count);
            return age;
        } else {
            return 0;
        }
    }
    
    function getEpochText () {
        
        var part1 = $('#result-epoch-1').val() || 'part1';
        var part2 = $('#result-epoch-2').val() || 'part2';
        var part3 = $('#result-epoch-3').val() || 'part3';
        
        var oldestYear = (new Date()).getFullYear();
        var oldestArtist = "";
        var oldestAlbum = "";
        
        // Look for the oldest album
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist] !== 0  && stats[artist] !== 1 && stats[artist].firstAlbum.length > 0) {
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
        
        if (oldestArtist !== "") {
            return part1 + oldestYear + part2 + oldestArtist + part3 + oldestAlbum;
        } else {
            return ($('#result-no-epoch').val() || 'No epoch');
        }
        
    }
    
    function getStyleText () {
        
        var part1 = $('#result-style').val() || 'part1';
        var styles = "";
        
        // Get all the tags
        var tags = [];
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist] !== 0  && stats[artist] !== 1 && stats[artist].tags.length > 0) {
                    for (var i = 0; i < stats[artist].tags.length; i++) {
                        tags.push(stats[artist].tags[i].name);
                    }
                }
            }
        }
        
        // If no tags
        if (!tags.length) {
            return ($('#result-no-style').val() || 'no tags');
        }
        
        var sortedTags = Aggregate.sortByFrequency(tags);
        
        // If all tags have the same freq choose the longest
        if (sortedTags[0][1] === 1) {
            
            var longestTags = tags.sort(function (a,b) {
                return b.length - a.length;
            });
            styles = longestTags.splice(0,3).join(", ");
            
        } else { // Otherwise take the most frequent
            
            var frequentTags = [];
            for (var i = 0; i < sortedTags.length; i++) {
                frequentTags.push(sortedTags[i][0]);
            }
            styles = frequentTags.splice(0,3).join(", ");
        }
        
        return part1 + styles;
    }
    
    function getSimilarText () {
        var part1 = $('#result-similar').val() || 'part1';
        var similar = "";
        
        // Get all similar artists
        var allSimilar = [];
        for (var artist in stats) {
            if (stats.hasOwnProperty(artist)) {
                if (stats[artist] !== 0  && stats[artist] !== 1 && stats[artist].similar.length > 0) {
                    for (var i = 0; i < stats[artist].similar.length; i++) {
                        allSimilar.push(stats[artist].similar[i].name);
                    }
                }
            }
        }
        
        if (allSimilar.length === 0) {
            return ($('#result-no-similar').val() || 'no similar');
        }
        
        similar = allSimilar.splice(0,3).join(", ");
        
        
        return part1 + similar;
    }
    
    return {
        build: build,
        getAgeText: getAgeText,
        getMusicalAge: getMusicalAge,
        getEpochText: getEpochText,
        getStyleText: getStyleText,
        getSimilarText: getSimilarText
    };
});