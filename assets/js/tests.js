define (['statsanalyzer'], function (StatsAnalyzer) {
   
    var mockupStats = {};
    mockupStats['Melendi'] = {
        averageFanAge: 1 , 
        firstAlbum: [{name: 'album1', date:'2013-01-25T00:11:02+0000'}],
        similar: [{name:'Bob Marley'},{name:'Justin Bieber'},{name: 'King Africa'}],
        tags: [{name: 'Gitaneo'},{name: 'Cani'},{name: 'Reggae'}]
    };
    mockupStats['Melendi2'] = {
        averageFanAge: 2 , 
        firstAlbum: [{name: 'album2', date:'2013-01-25T00:11:02+0000'}],
        similar: [{name:'Bob Marley'},{name:'Justin Bieber'},{name: 'King Africa'}],
        tags: [{name: 'Gitaneo'},{name: 'Cani'},{name: 'Reggae'}]    
    };
    mockupStats['Melendi3'] = {
        averageFanAge: 3 , 
        firstAlbum: [{name: 'album3', date:'2013-01-25T00:11:02+0000'}],
        similar: [{name:'Bob Marley'},{name:'Justin Bieber'},{name: 'King Africa'}],
        tags: [{name: 'Gitaneo'},{name: 'Cani'},{name: 'Reggae'}]
    };
        
    QUnit.test("StatsAnalyzer build", function( assert ) {
      assert.ok(StatsAnalyzer.build(mockupStats), "Passed!" );
    });
    QUnit.test("StatsAnalyzer get age text", function( assert ) {
      assert.equal(StatsAnalyzer.getAgeText(),'part_12part_2', "Passed!" );
    });
    QUnit.test("StatsAnalyzer get epoch text", function( assert ) {
      assert.equal(StatsAnalyzer.getEpochText(), 'part12013part2Melendipart3album1', "Passed!" );
    });
    QUnit.test("StatsAnalyzer get style text", function( assert ) {
      assert.equal(StatsAnalyzer.getStyleText(), 'part12013part2Melendipart3album1', "Passed!" );
    });
    QUnit.test("StatsAnalyzer get similar text", function( assert ) {
      assert.equal(StatsAnalyzer.getSimilarText(), 'part1Bob Marley, Justin Bieber, King Africa', "Passed!" );
    });
    
});
/*
 build: build,
getAgeText: getAgeText,
   getMusicalAge: getMusicalAge,
        getEpochText: getEpochText,
        getStyleText: getStyleText,
        getSimilarText: getSimilarText
        */