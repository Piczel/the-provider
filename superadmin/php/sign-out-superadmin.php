<?php

    session_start();
    unset($_SESSION['superadmin']);
    header('Location: ../index.php');
?>