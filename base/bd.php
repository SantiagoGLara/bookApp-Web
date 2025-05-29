<?php
function bd_consulta($query)
{
	$hostname="localhost";
	$user="Santiago";
	$password="ani56santi";
	$bd="books";
	$connection = mysqli_connect($hostname, $user, $password,$bd);
	if($connection == false){
		echo 'Ha habido un error <br>'.mysqli_connect_error();
		exit();
	}
    try{
	    $result = mysqli_query($connection, $query);
	    mysqli_close($connection);
    }
    catch(mysqli_sql_exception $e){
        var_dump($e);
        exit;
    }
	
	return $result;
}
?>