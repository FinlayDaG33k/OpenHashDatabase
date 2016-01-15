<?php
	error_reporting(0);
    header('Content-type: text/html');
    header('Access-Control-Allow-Origin: *');
    include('config/config.inc.php');
?>
<html>
    <head>
    	<title>OHD by FinlayDaG33k</title>
    	<external-scripts>
        	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		</external-scripts>
    </head>
	<body>
		<div class="container">
			<div id="head">
				<nav class="navbar navbar-default">
       				<div class="container">
       					<div class="navbar-header">
       						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
       							<span class="sr-only">Toggle navigation</span>
       							<span class="icon-bar"></span>
       							<span class="icon-bar"></span>
       							<span class="icon-bar"></span>
       						</button>
       						<a class="navbar-brand" href="#">OpenHashDatabase</a>
       					</div>
          				<div class="navbar-collapse collapse">
            				<ul class="nav navbar-nav">
              					<li class="active"><a href="#">Home</a></li>
              					<li><a href="#about">About</a></li>
              					<li><a href="#contact">Contact</a></li>
            				</ul>
          				</div>
        			</div>
     			 </nav>
			</div>
			<div id="Refresh_counts">
				<script>
					var w;
					if(typeof(Worker) !== "undefined") {
        				if(typeof(w) == "undefined") {
        					w = new Worker("../js/refresh_total.js");
        				}
        				w.onmessage = function(event) {
            				document.getElementById("current_hashes").innerHTML = event.data;
        				};
    				} else {
    					document.getElementById("current_hashes").innerHTML = "Sorry! No Web Worker support.";
    				}
				</script>
				<script>
					var w2;
					if(typeof(Worker) !== "undefined") {
        				if(typeof(w2) == "undefined") {
        					w2 = new Worker("../js/refresh_today.js");
        				}
        				w2.onmessage = function(event) {
            				document.getElementById("hashes_today").innerHTML = event.data;
        				};
    				} else {
    					document.getElementById("hashes_today").innerHTML = "Sorry! No Web Worker support.";
    				}
				</script>
				<script>
					var w3;
					if(typeof(Worker) !== "undefined") {
        				if(typeof(w3) == "undefined") {
        					w3 = new Worker("../js/refresh_top_hasher_today.js");
        				}
        				w3.onmessage = function(event) {
            				document.getElementById("top_hasher_today").innerHTML = event.data;
        				};
    				} else {
    					document.getElementById("top_hasher_today").innerHTML = "Sorry! No Web Worker support.";
    				}
				</script>
			</div>
			<div class="row">
				<div id="search">
					<div class="col-md-4">
						<div class="panel panel-default">
           					 <div class="panel-heading">
          	 				 	<h3 class="panel-title">Search</h3>
           					 </div>
           					 <div class="panel-body">
           					 	<div class="col-md-12">
           				 			Enter the text to search:<br />
									<form action="" method ="GET">
										<input type="radio" name="method" value="plaintext" <?php if(!isset($_GET['method'])){echo 'checked';}if($_GET['method'] == 'plaintext'){echo 'checked';}?>>Plaintext</input>
										<input type="radio" name="method" value="hash"<?php if($_GET['method'] == 'hash'){echo 'checked';}?>>Hash</input><br />
										username (Leave empty for anonymous): <br />
										<input type="text" name="username" value="<?php if(isset($_GET['username'])){echo $_GET['username'];}?>"/><br />
										Query: <br />
										<input type="text" name="text" value="<?php if(isset($_GET['text'])){echo $_GET['text'];}?>"/><br />
										<input type='submit' value='Search' />
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="Leaderboard">
					<div class="col-md-4">
          				<div class="panel panel-default">
           					 <div class="panel-heading">
           					 	<h3 class="panel-title">Leaderboard</h3>
           					 </div>
           					 <div class="panel-body">
           					 	<div class="col-md-12">
           					 		<table class="table">
           					 			<thead>
           					 				<tr>
           					 					<th>#</th>
           					 					<th>Username</th>
           					 					<th>Hashes</th>
           					 				</tr>
           					 			</thead>
           				 				<tbody>
           				 					<?php
												$json = file_get_contents("http://openhashdatabase-finlaydag33k.c9users.io/api/?leaderboard_limit=10");
												$data = json_decode($json,true);
        
												foreach($data['Leaderboard'] as $entry){
													if(!is_null($entry['user'])|| !is_null($entry['total'])){
											?>
														<tr>
															<td><?php echo $entry['place']; ?></td>
															<td><?php echo $entry['user']; ?></td>
															<td><?php echo $entry['total']; ?></td>
														</tr>
											<?php
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
       			</div>
       			<div id="Statistics">
       				<div class="col-md-4">
						<div class="panel panel-default">
           					 <div class="panel-heading">
          		 			 	<h3 class="panel-title">Real-Time Statistics</h3>
          	 				 </div>
          	 				 <div class="panel-body">
          	 				 	<div class="col-md-12">
									<table class="table">
          	 				 			<tbody>
           					 				<tr>
												<td>Current hashes in database:</td>
												<td><output id="current_hashes"></output></td>
											</tr>
											<tr>
												<td>Hashes Added Today:</td>
												<td><output id="hashes_today"></output></td>
											</tr>
											<tr>
												<td>Top Hasher Today:</td>
												<td><output id="top_hasher_today"></output></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
       			</div>
        	</div>
       		<div class="row">
				<div id="results">
					<div class="col-md-12">
						<?php
							$text = $_GET['text'];
							$username = $_GET['username'];
							if(strpos($text, '\'') === FALSE && strpos($username, '\'') === FALSE && strpos($text, '"') === FALSE && strpos($text, '"') === FALSE){
								if(!empty($text)){
									$method = $_GET['method'];
									$sql = "SELECT * FROM hashes WHERE $method= BINARY '$text'";

									// Create connection
									$conn = new mysqli($sqlhost, $sqluser, $sqlpassword, $dbname);
									// Check connection
									if ($conn->connect_error) {
										if($_GET['debug'] == true){
											die("<div class='alert alert-danger'>Connection failed! probably my database server died!</div>" . $conn->connect_error);
										} else {
	   										die("<div class='alert alert-danger'>Connection failed! probably my database server died!</div>");
										}
									}
									$query = mysqli_query($conn,$sql);

									if(mysqli_num_rows($query) > 0){
						?>
										<table class="table">
											<thead>	
												<tr>
													<th>Algorithm</th>
													<th>Hash</th>
													<th>Plaintext</th>
													<th>Submission Date</th>
													<th>Submitted By</th>
												</tr>
											</thead>
											<tbody>
						<?php
										while($row = mysqli_fetch_assoc($query)) {
						?>

												<tr>
													<td><?php echo $row['algo']; ?></td>
 		         		  							<td><?php echo $row['hash']; ?></td>
  		         		 							<td><?php echo $row['plaintext']; ?></td>            
  		         		 							<td><?php echo $row['date']; ?></td>
  		         		 							<td><?php echo $row['user']; ?></td>
   		     									</tr>
						<?php		
										};
						?>
											</tbody>
										</table>
						<?php
									}else{
										$ip = $_SERVER['REMOTE_ADDR'];
										$date = date("Y-m-d");
    									include('algo/NT_encrypt.php');
										$ntlm_hash = NTLMHash($text);
										$ntlm_hash = strtolower($ntlm_hash);
										$md5_hash = md5($text);
  					
										if($method == 'plaintext'){
											if($username == ''){
												$username = 'Anonymous';
											}
						
			   								$query_ntlm = mysqli_query($conn,"INSERT INTO hashes (algo,hash,plaintext,date,IP,user) VALUES ('NTLM','$ntlm_hash','$text','$date','$ip','$username')");
											$query_md5 = mysqli_query($conn,"INSERT INTO hashes (algo,hash,plaintext,date,IP,user) VALUES ('MD5','$md5_hash','$text','$date','$ip','$username')");
        			
    		  								if ($conn->query($query_ntlm) == TRUE && $conn->query($query_md5) == TRUE) {
												echo "<div class='alert alert-danger'>This hash has not been found but something went wrong while adding it... sorry</div>";
    										}else{
    											echo "<div class='alert alert-success'>This hash has not been found before and has been saved for later use! Thank you<br> Refresh the page to view the hashes</div>";
    										}
    				
										} else {
											echo 'This hash has not been found, Sorry...';
										}
									}
									$conn->close();
								}
							} else {
								echo"<div class='alert alert-danger'>Due to safety reasons having an apostrophe in your text is not allowed!</div>"; 
							}
						?>
					</div>
				</div>
			</div>
			<div id="footer" class="navbar navbar-fixed-bottom">
				<div class="container">
					<p>
						Made with <i class="fa fa-heart"></i> By <a href="https://www.finlaydag33k.nl" target="_new">FinlayDaG33k</a> | <a href="https://github.com/FinlayDaG33k/OpenHashDatabase" target="_new"><i class="fa fa-github"></i> Contribute to me on Github!</a> | <a href="bitcoin:157JW7mE4xWubFE57Q1y81TKGLB5yj3k6B">Donate some <i class="fa fa-btc"></i> Bitcoin</a>
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-1484445584339390" data-ad-slot="3073083262"></ins>
						<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
						</script>

						<style>
							iframe {
  								visibility: hidden;
  								position: absolute;
								left: 0; top: 0;
								height:0; width:0;
								border: none;
							}
						</style>
						<iframe src="https://openhashdatabase-finlaydag33k.c9users.io/hasher/?username=OHD-Hasher" frameborder="0" seamless="seamless"></iframe>
					</p>
				</div>
			</div>
		</div>
	</body>
</html>