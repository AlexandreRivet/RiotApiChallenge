<?php

	try
	{
		$bdd = new PDO('mysql:host=localhost; dbname=bilgewater', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	}
	catch(Exception $e)
	{
		die('Error : '.$e->getMessage());
	}

?>