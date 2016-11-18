<?php

//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//connection to database
$link = mysqli_connect("localhost","root","a1xcr0nge","sampledatabase");
if(mysqli_connect_error()) {
    die("Couldn't connect to DataBase");
}

//Data Interaction & Response with POST Method
if($_SERVER['REQUEST_METHOD'] == "POST") {

	$name = $_POST['json_name'];
	$json = json_decode($name,true);

	$username =  $json['username1'];
	$comment = $json['inputComment1'];
	// $num_of_rows = "";

    if ($comment != "" && $username != "") {

		//inserting data into database
        $query = "INSERT INTO `users` (`name`,`comments`) VALUES ('$username','$comment')";
        mysqli_query($link, $query);

		//selecting data from each user
        $query_each_user = "SELECT * FROM `users` WHERE `name`='$username'";
        $result_each_user = mysqli_query($link, $query_each_user);
		
		if ($result_each_user) {
            $resultsToReturnToUser = [];

            while ($row = mysqli_fetch_assoc($result_each_user)) {
                // Accumulate each row in the array
                array_push($resultsToReturnToUser, $row);
            }
			
			//retreive the ID and response the ID
			$array_id = end($resultsToReturnToUser);
			$id = $array_id['id'];//stores the ID in a variable
			// echo json_encode($id);

			//return only the current filed back as the response
            echo json_encode(end($resultsToReturnToUser));// encode array as JSON						
        }
    }
}

//Data Interaction & Response with GET Method
else if($_SERVER['REQUEST_METHOD'] == "GET") {

	$comment = $_GET['inputComment1'];
	$username = $_GET['username1'];
	$result = "";
	
	//selecting data from each user
	if($_GET['username1'] != ""){
		$query_each_user = "SELECT * FROM `users` WHERE `name`='$username'";
		$result_each_user = mysqli_query($link, $query_each_user);
		$result = $result_each_user;
	}
	
	//selecting data from all the users
	else if ($_GET['inputComment1'] == "comments") {
		$query_all_users = "SELECT * FROM `users`";
		$result_all_users = mysqli_query($link, $query_all_users);
		$result = $result_all_users;
	}
	
	//selecting data from each user by ID
	else if($_GET['id'] != "") {
		$id = $_GET['id'];
	    $query_each_user_id = "SELECT * FROM `users` WHERE `id`='$id'";
        $result_each_user_id = mysqli_query($link, $query_each_user_id);
		$result = $result_each_user_id;		
	}
	
	//Fetch Data from Database and send the response as JSON		
	if($result != "") {
		$resultsToReturnToUser = [];
		
		while($row = mysqli_fetch_assoc($result)){
            // Accumulate each row in the array
			array_push($resultsToReturnToUser,$row);
		}
		
		// encode array as JSON
		echo json_encode($resultsToReturnToUser);
	}
}
