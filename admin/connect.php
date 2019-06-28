

<?php
//	$dsn = 'mysql:host=localhost;dbname=shop'; //data source name
//	$user = 'root'; //the user to connect
//	$pass = ''; //password of the user
//	$options = array(
//		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
//	);
//
//	try{
//		$con = new PDO($dsn, $user, $pass, $options);
//		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//	}
//
//	catch(PDOException $e){
//		echo 'Failed'. $e->getMessage();
//	}

    $con = mysqli_connect("localhost", "root", "", "shop");
    if (!$con){
        die("error : ".$con);
}

?>