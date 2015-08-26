<?php
	$config = parse_ini_file("config.ini", 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index File</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div id="fb-root"></div>
	<script src='https://connect.facebook.net/en_US/all.js#xfbml=1'></script>
	<script>
	    FB.init({
	        appId: '<?php echo $config['facebook']['facebook_id'] ?>',
	        status: true, // check login status
	        cookie: true, // enable cookies to allow the server to access the session
	        xfbml: true// parse XFBML
	    });

	    FB.Canvas.setAutoGrow();
	</script>

	<div class="container" id="enter">
		<img src="img/landing.jpg" alt="Click to Enter">
	</div>





	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="js/script.js"></script>
</body>
</html>