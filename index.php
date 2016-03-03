<?php
	error_reporting(0);
    header('Content-type: text/html');
    header('Access-Control-Allow-Origin: *');
    include('config/config.inc.php');
	//$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
	$SERVER_URL = "https://".$_SERVER['HTTP_HOST'];
	
	// don't touch this, it might break the site!
	$disallowed_paths = array('header', 'footer'); 
	if (!empty($_GET['action'])) {
		$tmp_action = basename($_GET['action']);
			if (!in_array($tmp_action, $disallowed_paths) && file_exists("pages/{$tmp_action}.php")) {
				$action = $tmp_action;
			} else {
				$action = error;
			}
	} else {
		$action = home;
	}
?>
<html>
    <head>
    	<title>OHD by FinlayDaG33k</title>
    	<external-scripts>
        	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
			<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
			<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		</external-scripts>
    </head>
	<body>
		<div class="container">
			<div id="head">
				<?php include('include/navbar.php');?>
			</div>
			<?php   
				include("pages/$action.php"); 
			?>
			<div id="footer" class="navbar navbar-fixed-bottom">
				<?php include('include/footer.php');?>
			</div>
		</div>
	</body>
</html>