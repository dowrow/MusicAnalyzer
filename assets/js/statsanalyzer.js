define (['jquery', 'aggregate'], function ($, aggregate) {
    
    var stats = {};
    
    function build (statsParam) {
        stats = statsParam;
    }
    
    function getAgeText () {
        
    }
    
    function getEpochText () {
        
    }
    
    function getStyleText () {
        
    }
    
    function getSimilarText () {
        
    }
    
    return {
        build: build,
        getAgeText: getAgeText,
        getEpochText: getEpochText,
        getStyleText: getStyleText,
        getSimilarTex: getSimilarTex
    };
});

StatsAnalyzer.build(artistStats);

var ageText = StatsAnalyzer.getAgeText();
var epochText = StatsAnalyzer.getEpochText();
var styleText = StatsAnalyzer.getStyleText();
var similarText = StatsAnalyzer.getSimilarText();