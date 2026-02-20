<?php
//Archivo que inicia las sesiones y activa el autoload
require_once __DIR__ . '/autoload.php';

// Iniciamos la sesión si no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}