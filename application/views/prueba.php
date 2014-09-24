<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>LogIn</title>  
</head>
<body>
    <h1>Prueba</h1>
    <ul>
        <?php
        
        foreach ($videos as $video) {
            echo($video['title'] . '<br>');
        }
        
        ?>
    </ul>
    <script src="/assets/js/main.js"></script>
</body>
</html>
