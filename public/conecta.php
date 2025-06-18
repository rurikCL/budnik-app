<?php
$serverName = "GPDESAMIGRA\\GP2015"; // Reemplazar con el nombre del servidor y la instancia
$connectionOptions = array(
    "Database" => "BUD01", // Reemplazar con el nombre de la base de datos
//    "Uid" => "BUDNET\Desarrollo", // Reemplazar con el nombre de usuario
//    "PWD" => "4Q#%(SnpW2r$", // Reemplazar con la contraseña
//    "CharacterSet" => "UTF-8",
    "TrustServerCertificate" => true,
);

// Establecer la conexión
$conn = sqlsrv_connect($serverName, $connectionOptions);

if($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "Conexión establecida correctamente.";
    // Aquí puedes ejecutar tus consultas SQL
    sqlsrv_close($conn); // Cerrar la conexión
}

phpinfo();
?>
