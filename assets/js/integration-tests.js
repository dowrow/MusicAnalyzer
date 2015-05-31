define (['jquery'], function ($) {
    
    /**
     * Integration tests for REST API
     */
    var url = 'https://music-analyzer.herokuapp.com/rest';
    
    $.getJSON(url, function (res) {
        QUnit.test("REST get stats Cher", function( assert ) {
            assert.ok(res === "ok", "Passed!" );
        });
    });
});