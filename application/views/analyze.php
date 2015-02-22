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
                <input id="initial-status" type="hidden" value="<?php echo $this->lang->line('analyze_status'); ?>"/>
                <input id="initial-status-album" type="hidden" value="<?php echo $this->lang->line('analyze_status_album'); ?>"/>
                <input id="initial-status-fan" type="hidden" value="<?php echo $this->lang->line('analyze_status_fan'); ?>"/>
                <input id="initial-status-tag" type="hidden" value="<?php echo $this->lang->line('analyze_status_tag'); ?>"/>
                <input id="initial-status-similar" type="hidden" value="<?php echo $this->lang->line('analyze_status_similar'); ?>"/>
                <input id="error-title" type="hidden" value="<?php echo $this->lang->line('analyze_error_title'); ?>"/>
                <input id="error-status" type="hidden" value="<?php echo $this->lang->line('analyze_error_status'); ?>"/>
                
                <p class="text-center" id="status"></p>
                <img id="loading" class="center-block" src="assets/img/loading.gif" alt="Loading..."/>
            </div>
            <!-- TEMPLATE -->
            
            <div class="hidden" id="results">
                <div class="jumbotron">
                    <span class="icon"><span class="glyphicon glyphicon-user"></span></span>
                    <p></p>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-tags"></span></span>
                     <p></p>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-calendar"></span></span>
                     <p></p>
                </div>

                <div class="jumbotron">
                     <span class="icon"><span class="glyphicon glyphicon-heart"></span></span>
                     <p></p>
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