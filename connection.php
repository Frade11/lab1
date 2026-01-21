<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca_online";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$conn->set_charset("utf8");

function afiseazaMesaj($tip, $mesaj) {
    $clasa = ($tip == 'success') ? 'success' : 'error';
    echo '<div class="message ' . $clasa . '">' . $mesaj . '</div>';
}
?>