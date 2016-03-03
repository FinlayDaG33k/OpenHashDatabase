<div id="Refresh_counts">
				<script>
					var w;
					if(typeof(Worker) !== "undefined") {
        				if(typeof(w) == "undefined") {
        					w = new Worker("<?php echo $SERVER_URL;?>/js/refresh_total.js");
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
        					w2 = new Worker("<?php echo $SERVER_URL;?>/js/refresh_today.js");
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
        					w3 = new Worker("<?php echo $SERVER_URL;?>/js/refresh_top_hasher_today.js");
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
												$json = file_get_contents($SERVER_URL."/api/?leaderboard_limit=10");
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
										$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
										$date = date("Y-m-d");
    									include('algo/NT_encrypt.php');
										$ntlm_hash = NTLMHash($text);
										$ntlm_hash = strtolower($ntlm_hash);
										$md5_hash = md5($text);
										$sha1_hash = sha1($text);
  					
										if($method == 'plaintext'){
											if($username == ''){
												$username = 'Anonymous';
											}
						
			   								$query_ntlm = mysqli_query($conn,"INSERT INTO hashes (algo,hash,plaintext,date,IP,user) VALUES ('NTLM','$ntlm_hash','$text','$date','$ip','$username')");
											$query_md5 = mysqli_query($conn,"INSERT INTO hashes (algo,hash,plaintext,date,IP,user) VALUES ('MD5','$md5_hash','$text','$date','$ip','$username')");
											$query_sha1 = mysqli_query($conn,"INSERT INTO hashes (algo,hash,plaintext,date,IP,user) VALUES ('SHA1','$sha1_hash','$text','$date','$ip','$username')");
											
    		  								if ($conn->query($query_ntlm) == TRUE && $conn->query($query_md5) == TRUE && $conn->query($query_sha1) == TRUE) {
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