<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>LogIn</title>  
</head>
<body>
    <h1>List of artists</h1>
    <ul>
        <?php foreach ($artists as $a):?>
        
        <li><?php echo $a; ?></li>
        
        <?php endforeach; ?>
    </ul>
    <script src="/assets/js/main.js"></script>
</body>
</html>
