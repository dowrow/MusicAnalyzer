<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        
        <!-- Custom -->
        <link rel="stylesheet" href="assets/css/analyze.css">
    </head>
    
    <body>
        <div class="container">
            
            <br/>
            <div class="progress">
                <div id="appProgress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            
            <br/>
            <div class="jumbotron">
                <h1 class="text-center">
                    <?php echo $this->lang->line('analyze_title'); ?>
                </h1>
                <br/> 
                
                <!-- Hidden inputs to store location-dependent text -->
                <input id="initial-status" type="hidden" value="<?php echo $this->lang->line('analyze_status'); ?>"/>
                <input id="initial-status-album" type="hidden" value="<?php echo $this->lang->line('analyze_status_album'); ?>"/>
                <input id="initial-status-fan" type="hidden" value="<?php echo $this->lang->line('analyze_status_fan'); ?>"/>
                <input id="initial-status-tag" type="hidden" value="<?php echo $this->lang->line('analyze_status_tag'); ?>"/>
                <input id="initial-status-similar" type="hidden" value="<?php echo $this->lang->line('analyze_status_similar'); ?>"/>
                
                <p class="text-center" id="status"></p>
                <img class="center-block" src="assets/img/loading.gif" alt="Loading..."/>
                
            </div>
            <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        
        </div>
        
        <script data-main="assets/js/analyze.js" src="assets/js/require.js"></script>

        <!-- FB root -->
        <div id="fb-root"></div>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        
    </body>
    
</html>