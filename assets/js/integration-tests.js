define(['jquery'], function($) {

    /**
     * Integration tests for REST API
     */
    var url = 'https://music-analyzer.herokuapp.com/rest';

    $.get(url, function(res) {
        QUnit.test("REST API up and running", function(assert) {
            assert.ok(res === "REST API OK", "Passed!");
        });
    });

    $.get(url + '/stats?artist=asdasdasdasd&pageid=0', function(res) {
        QUnit.test("REST API get unkown stats", function(assert) {
            var obj = JSON.parse(res);
            assert.ok(obj === 0, "Passed!");
        });
    });

    $.get(url + '/stats?artist=Cher&pageid=112915798740840', function(res) {
        QUnit.test("REST API get Cher stats", function(assert) {
            var obj = JSON.parse(res);
            assert.ok(obj.averageFanAge && obj.firstAlbum && obj.similar &&
                    obj.tags, "Passed!");
        });
    });

    $.post(url + '/insertartist', {name: 'TestArtist', url: 'TestURL',
        pageid: '000000', image: 'TestImage'}, function(res) {
        QUnit.test("REST API insert artist", function(assert) {
            assert.equal(res, 'ok', "Passed!");
        });
    });


    $.post(url + '/insertalbum', {artist: 'TestArtist', album: 'TestAlbum',
        url: 'TestURL', date: '2013-01-25T00:11:02+0000'},
    function(res) {
        QUnit.test("REST API insert album", function(assert) {
            assert.equal(res, 'ok', "Passed!");
        });
    });


    $.post(url + '/inserttag', {artist: 'TestArtist', name: 'TestTag',
        url: 'TestURL'}, function(res) {
        QUnit.test("REST API insert tag", function(assert) {
            assert.equal(res, 'ok', "Passed!");
        });
    });


    $.post(url + '/insertfan', {artist: 'TestArtist', url: 'TestURL',
        age: '0'}, function(res) {
        QUnit.test("REST API insert fan", function(assert) {
            assert.equal(res, 'ok', "Passed!");
        });
    });


    $.post(url + '/insertsimilar', {artist: 'TestArtist',
        similar: 'TestSimilar', url: 'TestURL', image: 'TestImage'},
    function(res) {
        QUnit.test("REST API insert similar", function(assert) {
            assert.equal(res, 'ok', "Passed!");
        });
    });

});