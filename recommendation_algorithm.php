<?php
	include('recommendation_main.css');
	
	$dbServername = "localhost";
	$dbUsername = "root";
	$dbPassword = "icando1006";
	$dbName = "reviews_info";

	$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
	$sql = "SELECT DISTINCT song_title, genre FROM reviews_info_table";
	$query_result = mysqli_query($conn, $sql);
	$ratings_info = array();
	
	if(mysqli_num_rows($query_result) > 0){
		while($row = mysqli_fetch_assoc($query_result)){
			$ratings_info[] = $row;
		}
	}
		
	for ($i = 0; $i < count($ratings_info); $i++){
		$song_title = $ratings_info[$i]['song_title'];
		$query_avg = "SELECT AVG(rating) AS avg FROM reviews_info_table WHERE song_title = '$song_title'";
		$query_result_avg = mysqli_query($conn, $query_avg);
		while($row_avg = mysqli_fetch_assoc($query_result_avg)){
			$output_avg = $row_avg['avg'];
		}
		$output_avg = round($output_avg,2);
		$ratings_info[$i]['average_rating'] = $output_avg;
		
		$query_num_rows = "SELECT COUNT(*) AS num_rows FROM reviews_info_table WHERE song_title = '$song_title'";
		$query_result_num_rows = mysqli_query($conn, $query_num_rows);
		while($row_num_rows = mysqli_fetch_assoc($query_result_num_rows)){
			$output_num_rows = $row_num_rows['num_rows'];
		}
		$ratings_info[$i]['number_of_ratings'] = $output_num_rows;
	}

	$popular = array();
	$underrated = array();
	for ($i = 0; $i < count($ratings_info); $i++){
		if($ratings_info[$i]['number_of_ratings'] > 5){
			$popular[] = $ratings_info[$i];
		}
	}
	
	for ($i = 0; $i < count($ratings_info); $i++){
		if($ratings_info[$i]['number_of_ratings'] > 1 AND $ratings_info[$i]['number_of_ratings'] <= 5 AND $ratings_info[$i]['average_rating'] >= 4){
			$underrated[] = $ratings_info[$i];
		}
	}
	
	$genre = $_POST['genre'];
	$mode = $_POST['mode'];
	
	function printArray($array, $genre){
		echo "<table>
		<tr>
		<th>Title</th>
		<th>Average Rating</th>
		<th>Number of ratings</th>
		</tr>";

		for ($i = 0; $i < count($array); $i++){
			if($array[$i]['genre'] == $genre){
				echo "<tr>";
				echo "<td>" . $array[$i]['song_title'] . "</td>";
				echo "<td>" . $array[$i]['average_rating'] . "</td>";
				echo "<td>" . $array[$i]['number_of_ratings'] . "</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}
	
	if($mode == 'popular'){
		printArray($popular, $genre);
	}
	if($mode == 'underrated'){
		printArray($underrated, $genre);
	}
?>