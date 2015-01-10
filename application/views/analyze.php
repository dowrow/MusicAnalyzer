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
        <br>
        <div class="container">
            
            <br/>
            
            <div class="progress">
                <div id="appProgress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                    <span class="sr-only">60% Complete</span>
                </div>
            </div>
            
            <br>
            <div class="row jumbotron">
                <h1>
                    Analyzing your likes<span id="loading"></span>
                </h1>
                <br/> 
                
                <div>
                    <p>Seems like you like Cher.</p>
                    <p>You may know the albums: Cher1, Cher2, Cher3.</p>
                    <p>I would says the styles of Cher are: pop, pop, pop.</p>
                    <p>The average fan of Cher is 18 years old.</p>
                </div>
            </div>
            
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