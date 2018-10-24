<?php

$user = 'root';
$pass = '';
$db = 'the_provider';

$db = new mysqli ('localhost', $user, $pass, $db) or die("Unabble To Connect");

echo"bra jobbat!!";

?>