<?php
    header('Content-type: text/html');
    header('Access-Control-Allow-Origin: *');
include('../config/config.inc.php');
// Create connection
$conn = new mysqli($sqlhost, $sqluser, $sqlpassword, $dbname);
// Check connection
?>

<?php

$num_hashes_sql = "SELECT * FROM hashes";
$num_hashes =  mysqli_query($conn,$num_hashes_sql);

if($_GET['leaderboard_limit'] < 1){
	$leaderboard_limit = 5;
} else {
	$leaderboard_limit = $_GET['leaderboard_limit'];
}

$sql = "select user, count(*) as total from hashes group by user order by total desc limit ". $leaderboard_limit;
$leaderboard_query =  mysqli_query($conn,$sql);
$leaderboard_ID = 1;

while($row = $leaderboard_query->fetch_assoc()){
  ${"leaderboard_".$leaderboard_ID."_user"} = $row['user'];
  ${"leaderboard_".$leaderboard_ID."_total"} = $row['total'];
  $leaderboard_ID++;
}

$sql = "select ID from hashes WHERE `date`='".date("Y-m-d")."'";
$hashes_today =  mysqli_query($conn,$sql);

$sql = "select user, count(*) as total from hashes WHERE `date`='".date("Y-m-d")."' group by user order by total desc limit 1";
$top_hasher_today =  mysqli_query($conn,$sql);

$OUTPUT = array(
	  "hashes" => $num_hashes->num_rows,
	  "Leaderboard" => array(
	    "1" => array(
	    "place"=> "1",	
	      "user" => $leaderboard_1_user,
	    "total" => $leaderboard_1_total
	    ),
	    "2" => array(
	    	 "place"=> "2",
	      "user" => $leaderboard_2_user,
	    "total" => $leaderboard_2_total
	    ),
	    "3" => array(
	    	 "place"=> "3",
	    "user" => $leaderboard_3_user,
	    "total" => $leaderboard_3_total
	    ),
	    "4" => array(
	    	 "place"=> "4",
	    "user" => $leaderboard_4_user,
	    "total" => $leaderboard_4_total
	    ),
	    "5" => array(
	    	 "place"=> "5",
	    "user" => $leaderboard_5_user,
	    "total" => $leaderboard_5_total
	    )
	    ),
	    "hashes_today" => $hashes_today->num_rows,
	    "top_hasher_today" => $top_hasher_today->fetch_assoc()
    );
    
    echo json_encode($OUTPUT);
    ?>