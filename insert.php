<?php
	$dbServername = "localhost";
	$dbUsername = "root";
	$dbPassword = "icando1006";
	$dbName = "reviews_info";

	$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
	
	if(isset($_POST['submit'])){
		$song_title = $_POST['song-names'];
		$composer = $_POST['composer-names'];
		$singer = $_POST['singer-names'];
		$genre = $_POST['genre'];
		$user_id = $_POST['userID'];
		$rating = $_POST['rating'];
		$review = $_POST['review'];
		
		$query = "INSERT INTO reviews_info_table(song_title, composer, singer, genre, user_id, review, rating) values ('$song_title', '$composer', '$singer', '$genre', '$user_id', '$review', '$rating')";
		
		$run = mysqli_query($conn, $query) or die(mysqli_error($conn));
		
		if($run){
			echo "Form submitted successfully!";
		}
		else{
			echo "Form not submitted.";
		}
	}
	else{
		echo "All fields required.";
	}
?>