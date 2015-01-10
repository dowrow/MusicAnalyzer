define (['jquery'], function ($) {
    
    $(document).ready(function () {
        
        // Animate progress bar
        $('#appProgress').css('width', '33%');
    
        // Animate dots
        setInterval(function () {
            switch ($('#loading').text()) {
                case '':
                    $('#loading').text('.');
                    break;
                case '.':
                    $('#loading').text('..');
                    break;
                case '..':
                    $('#loading').text('...');
                    break;
                case '...':
                    $('#loading').text('');
                    break;
            }
        }, 500);
    });
    
});