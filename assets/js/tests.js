define (['statsanalyzer', 'aggregate', 'LastFMProxy'], function (StatsAnalyzer, Aggregate, LastFMProxy) {
    
    /**
     * LastFM Proxy
     */
    
        var dummyCallback = function (){};
        LastFMProxy.getStats('112915798740840', 'Cher', dummyCallback, dummyCallback, dummyCallback, dummyCallback, dummyCallback, function (stats) {
            QUnit.test("LastFMProxy get Cher stats", function( assert ) {
                assert.ok(stats.length > 1, "Passed!" );
            });
        });
        LastFMProxy.getStats('0', 'asdasdasdsdfsdf', dummyCallback, dummyCallback, dummyCallback, dummyCallback, dummyCallback, function (stats) {
            QUnit.test("LastFMProxy get unknown stats", function( assert ) {
                assert.ok(stats === '1', "Passed!" );
            });
        });
    
    /**
     * Aggregate tests
     */
    var list1 = ['d', 'a', 'c', 'c', 'b', 'd', 'c', 'b', 'd', 'd'];
    var sorted1 = [['d', 4], ['c', 3], ['b', 2], ['a', 1]];
    QUnit.test("Aggregate sort list", function( assert ) {
      assert.equal(Aggregate.sortByFrequency(list1).join(), sorted1.join(), "Passed!");
    });
    QUnit.test("Aggregate sort empty", function( assert ) {
      assert.equal(Aggregate.sortByFrequency([]).join(), '', "Passed!");
    });
    
    /**
     * StatsAnalyzer tests
     */
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
      assert.equal(StatsAnalyzer.getStyleText(), 'part1Gitaneo, Cani, Reggae', "Passed!" );
    });
    QUnit.test("StatsAnalyzer get similar text", function( assert ) {
      assert.equal(StatsAnalyzer.getSimilarText(), 'part1Bob Marley, Justin Bieber, King Africa', "Passed!" );
    });
    QUnit.test("StatsAnalyzer build empty", function( assert ) {
      assert.ok(StatsAnalyzer.build({}), "Passed!" );
    });
    QUnit.test("StatsAnalyzer get age text empty", function( assert ) {
      assert.equal(StatsAnalyzer.getAgeText(),'No age', "Passed!" );
    });
    QUnit.test("StatsAnalyzer get epoch text empty", function( assert ) {
      assert.equal(StatsAnalyzer.getEpochText(), 'No epoch', "Passed!" );
    });
    QUnit.test("StatsAnalyzer get style text empty", function( assert ) {
      assert.equal(StatsAnalyzer.getStyleText(), 'no tags', "Passed!" );
    });
    QUnit.test("StatsAnalyzer get similar text empty", function( assert ) {
      assert.equal(StatsAnalyzer.getSimilarText(), 'no similar', "Passed!" );
    });
    
    
});