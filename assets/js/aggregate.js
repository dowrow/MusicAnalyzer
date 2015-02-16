define([], function () {
    
    // We can calculate its frequency hashtable with the method:
    function getFrequencyHashtable (array) {
        var hashtable = {};
        array.forEach(function (element) {
            if (!hashtable.hasOwnProperty(element)) {
                hashtable[element] = 1;
            } else {
                hashtable[element] += 1;
            }
        });
        return hashtable;
    }

    // And then get a sorted array without duplicates out of it
    function sortByFrequency (array) {
        var hashtable = getFrequencyHashtable(array);
        var tuples = [];
        for (var key in hashtable) {
            if (hashtable.hasOwnProperty(key)) {
               tuples.push([key, hashtable[key]]);
            }
        }
        return tuples.sort(function(a, b) { 
            return a[1] < b[1] ? 1 : a[1] > b[1] ? -1 : 0;
        });
    }
    
    /**
     * Public
     */
    return {
        getFrequencyHashtable: getFrequencyHashtable,
        sortByFrequency: sortByFrequency
    };
});