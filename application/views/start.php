<!DOCTYPE html>
<html lang="en">
    
    <head>
        <!-- Responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Facebooks Graph Api Tags -->
        <meta property="og:url"                content="https://apps.facebook.com/music-analyzer/" />
        <meta property="fb:app_id"             content="1468034890110746" />
        <meta property="og:title"              content="Music Analyzer" />
        <meta property="og:description"        content="Discover what your music says about you." />
        <meta property="og:image"              content="<?php echo $this->lang->line('share_image'); ?>"/>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        
        <!-- Modal windows -->
        <link rel="stylesheet" href="assets/css/sweet-alert.css">
        
        <!-- Custom styles -->
        <link rel="stylesheet" href="assets/css/start.css">

    </head>
    
    <body>
    
        <div class="container">
            
            <br/>
            <div class="progress">
                <div id="appProgress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            
            <div id="process" class="jumbotron text-center">
                
                <!-- App logo -->
                <span id="logo" class="logo">
                    <span class="glyphicon glyphicon-search"></span>
                    <span class="glyphicon glyphicon-music"></span>
                </span>
                
                <!-- Title -->
                <h1 id="title" class="text-center">
                    <?php echo $this->lang->line('start_title'); ?>
                </h1>
                
                <p class="lead text-center" id="status"><?php echo $this->lang->line('start_description'); ?></p>
                <p><a id="start" class="btn btn-primary btn-lg hidden" href="javascript:void(0);" role="button"><?php echo $this->lang->line('start_button'); ?></a></p>
                <img id="loading" class="hidden center-block" src="assets/img/loading.gif" alt="Loading..."/>
                
                <!-- Analyze -->
                
                <!-- Hidden inputs to store location-dependent text -->
                
                <!-- Static text -->
                <input id="analyze-title" type="hidden" value="<?php echo $this->lang->line('analyze_title'); ?>"/>
                <input id="initial-status" type="hidden" value="<?php echo $this->lang->line('analyze_status'); ?>"/>
                <input id="description" type="hidden" value="<?php echo $this->lang->line('analyze_description'); ?>"/>
                <input id="share-image" type="hidden" value="<?php echo $this->lang->line('analyze_share_image'); ?>"/>
                <input id="initial-status-album" type="hidden" value="<?php echo $this->lang->line('analyze_status_album'); ?>"/>
                <input id="initial-status-fan" type="hidden" value="<?php echo $this->lang->line('analyze_status_fan'); ?>"/>
                <input id="initial-status-tag" type="hidden" value="<?php echo $this->lang->line('analyze_status_tag'); ?>"/>
                <input id="initial-status-similar" type="hidden" value="<?php echo $this->lang->line('analyze_status_similar'); ?>"/>
                
                <!-- Error text -->
                <input id="error-title" type="hidden" value="<?php echo $this->lang->line('analyze_error_title'); ?>"/>
                <input id="error-status" type="hidden" value="<?php echo $this->lang->line('analyze_error_status'); ?>"/>
                
                <!-- Results text -->
                <input id="result-age-1" type="hidden" value="<?php echo $this->lang->line('analyze_result_age_1'); ?>"/>
                <input id="result-age-2" type="hidden" value="<?php echo $this->lang->line('analyze_result_age_2'); ?>"/>
                <input id="result-no-age" type="hidden" value="<?php echo $this->lang->line('analyze_result_no_age'); ?>"/>
                
                <input id="result-epoch-1" type="hidden" value="<?php echo $this->lang->line('analyze_result_epoch_1'); ?>"/>
                <input id="result-epoch-2" type="hidden" value="<?php echo $this->lang->line('analyze_result_epoch_2'); ?>"/>
                <input id="result-epoch-3" type="hidden" value="<?php echo $this->lang->line('analyze_result_epoch_3'); ?>"/>
                <input id="result-no-epoch" type="hidden" value="<?php echo $this->lang->line('analyze_result_no_epoch'); ?>"/>
                
                <input id="result-style" type="hidden" value="<?php echo $this->lang->line('analyze_result_style'); ?>"/>
                <input id="result-no-style" type="hidden" value="<?php echo $this->lang->line('analyze_result_no_style'); ?>"/>
                
                <input id="result-similar" type="hidden" value="<?php echo $this->lang->line('analyze_result_similar'); ?>"/>
                <input id="result-no-similar" type="hidden" value="<?php echo $this->lang->line('analyze_result_no_similar'); ?>"/>
                
                <input id="how-button" type="hidden" value="<?php echo $this->lang->line('how_button'); ?>"/>
                <input id="how-age" type="hidden" value="<?php echo $this->lang->line('how_age'); ?>"/>
                <input id="how-style" type="hidden" value="<?php echo $this->lang->line('how_style'); ?>"/>
                <input id="how-epoch" type="hidden" value="<?php echo $this->lang->line('how_epoch'); ?>"/>
                <input id="how-similar" type="hidden" value="<?php echo $this->lang->line('how_similar'); ?>"/>
                
                <input id="musical-age" type="hidden" value="<?php echo $this->lang->line('musical_age'); ?>"/>
                <input id="you" type="hidden" value="<?php echo $this->lang->line('you'); ?>"/>
                <input id="try-music-analyzer" type="hidden" value="<?php echo $this->lang->line('try_music_analyzer'); ?>"/>
                
                <!-- End of hidden inputs -->
                
            </div>
            
            <!-- Results template -->
            <div class="hidden" id="results">
                
                <h1 class="text-center">
                    <?php echo $this->lang->line('analyze_results_title'); ?>
                </h1>
                <br/>
                <div class="jumbotron">
                    <p><?php echo $this->lang->line('your_musical_age'); ?></p>
                    <div id="chart"><?php echo $this->lang->line('you_are_the_first'); ?></div>
                    <span class="actions">
                        <button class="btn btn-primary btn-lg text-right" id="invite"><?php echo $this->lang->line('invite_friends'); ?></button>
                    </span>
                </div>

                 <div class="jumbotron">
                    <span class="icon"><span class="glyphicon glyphicon-user"></span></span>
                    <p id="age_result"></p>
                    <span class="actions">
                         <a id="howAge" href="#"><?php echo $this->lang->line('how_button'); ?></a>
                         <button id="share_age" class="btn btn-primary btn-lg"><?php echo $this->lang->line('share_button'); ?></button>
                     </span>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-tags"></span></span>
                     <p id="style_result"></p>
                     <span class="actions">
                         <a id="howStyle"href="#"><?php echo $this->lang->line('how_button'); ?></a>
                         <button id="share_style" class="btn btn-primary btn-lg"><?php echo $this->lang->line('share_button'); ?></button>
                     </span>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-calendar"></span></span>
                     <p id="epoch_result"></p>
                     <span class="actions">
                         <a id="howEpoch" href="#"><?php echo $this->lang->line('how_button'); ?></a>
                         <button id="share_epoch" class="btn btn-primary btn-lg"><?php echo $this->lang->line('share_button'); ?></button>
                     </span>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-heart"></span></span>
                     <p id="similar_result"></p>
                     <span class="actions">
                         <a id="howSimilar" href="#"><?php echo $this->lang->line('how_button'); ?></a>
                         <button id="share_similar" class="btn btn-primary btn-lg"><?php echo $this->lang->line('share_button'); ?></button>
                     </span>
                </div>
                                
            </div>      
            
            <!-- Like button -->
            <div class="fb-like" data-href="https://apps.facebook.com/music-analyzer" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        
        </div>
        
        <!-- FB root -->
        <div id="fb-root"></div>
      
        <!-- Main -->
        <script data-main="assets/js/start.js" src="assets/js/require.js"></script>
        
        <!-- Google Charts -->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
      
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
       
        <!-- Charts -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
                
    </body>
    
</html>