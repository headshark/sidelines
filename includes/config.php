<?php
ob_start(); // Turns on output buffering
session_start();
date_default_timezone_set("America/Chicago");

try {
    $conn = new PDO("mysql:dbname=sidelines;host=localhost", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
?>