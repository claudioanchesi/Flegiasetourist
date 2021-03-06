<?php

    session_start();
    if (!isset($_SESSION['id']) || $_SESSION['type'] !== 'amministratore') {
        header("location: login.php");
        exit;
    }

    require_once('config.php');

    /** @var MYSQLI $connection*/

    $id = $connection->real_escape_string($_GET['id']); //ID utente

    // Query che aggiorna il flag dell'utente eliminato
    $sql = "UPDATE users SET deleted = 1 WHERE id_code = '$id'";

    if ($connection->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $connection->error;
        die();
    }

$connection->close();
