<?php
try {
	$string = file_get_contents("C:\\xampp\htdocs\BookReviewApp\src\database\db-credentials.json");
	$s_json = json_decode($string,true);
	$pdo = new PDO('mysql:host=localhost;port=3307;dbname='.$s_json['dbname'],$s_json['username'],$s_json['password']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	print "Hata!: " . $e->getMessage() . "<br/>";
	die();
}