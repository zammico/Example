<?php
//Koneksi ke database
if(!defined("LOGIN")){
	echo "<h1>area terlarang untuk umum</h1>";
}
$server   = "localhost";
$usernames = "root";
$passwords = "";
$database = "kredit_mobil_uas"; // nama database
 
$connect = mysqli_connect($server, $usernames, $passwords, $database);

//Check error, jikalau error tutup koneksi dengan mysql
if (mysqli_connect_errno()) {
	echo 'Koneksi gagal, ada masalah pada : '.mysqli_connect_error();
	exit();
	mysqli_close($connect);
}
// mysqli_close($mysqli)
?>