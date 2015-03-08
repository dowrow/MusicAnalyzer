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
            
            <!-- Generic modal window -->
            <div id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button id="modalClose" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 id="modalTitle" class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <p id="modalText"></p>
                        </div>
                        <div class="modal-footer">
                            <button id="modalOk" button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            
            <br/>
            <div class="progress">
                <div id="appProgress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            
            <br/>
            <div id="process" class="jumbotron">
                
                <h1 id="title" class="text-center">
                    <?php echo $this->lang->line('analyze_title'); ?>
                </h1>
                <br/> 
                
                <!-- Hidden inputs to store location-dependent text -->
                
                <!-- Static text -->
                <input id="initial-status" type="hidden" value="<?php echo $this->lang->line('analyze_status'); ?>"/>
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
                <input id="result-epoch-1" type="hidden" value="<?php echo $this->lang->line('analyze_result_epoch_1'); ?>"/>
                <input id="result-epoch-2" type="hidden" value="<?php echo $this->lang->line('analyze_result_epoch_2'); ?>"/>
                <input id="result-epoch-3" type="hidden" value="<?php echo $this->lang->line('analyze_result_epoch_3'); ?>"/>
                <input id="result-style" type="hidden" value="<?php echo $this->lang->line('analyze_result_style'); ?>"/>
                <input id="result-no-style" type="hidden" value="<?php echo $this->lang->line('analyze_result_no_style'); ?>"/>
                <input id="result-similar" type="hidden" value="<?php echo $this->lang->line('analyze_result_similar'); ?>"/>
                
                <!-- End of hidden inputs -->
                
                <p class="text-center" id="status"></p>
                <img id="loading" class="center-block" src="assets/img/loading.gif" alt="Loading..."/>
            </div>
            <!-- TEMPLATE -->
            
            <div class="hidden" id="results">
                 <div class="jumbotron">
                    <span class="icon"><span class="glyphicon glyphicon-user"></span></span>
                    <p id="age_result"></p>
                    <span class="actions">
                         <a href="#">¿Cómo funciona?</a>
                         <button id="share_age" class="btn btn-primary btn-lg">Compartir</button>
                     </span>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-tags"></span></span>
                     <p id="style_result"></p>
                     <span class="actions">
                         <a href="#">¿Cómo funciona?</a>
                         <button id="share_style" class="btn btn-primary btn-lg">Compartir</button>
                     </span>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-calendar"></span></span>
                     <p id="epoch_result"></p>
                     <span class="actions">
                         <a href="#">¿Cómo funciona?</a>
                         <button id="share_epoch" class="btn btn-primary btn-lg">Compartir</button>
                     </span>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-heart"></span></span>
                     <p id="similar_result"></p>
                     <span class="actions">
                         <a href="#">¿Cómo funciona?</a>
                         <button id="share_similar" class="btn btn-primary btn-lg">Compartir</button>
                     </span>
                </div>
            </div>
            
             <!-- Like button -->
            <div class="fb-like" data-href="https://apps.facebook.com/music-analyzer" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                
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