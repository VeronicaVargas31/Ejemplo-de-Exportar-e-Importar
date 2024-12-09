<?php 
$user = "root";
$password = "123456789";
$database = "hello_mysql";
$host = "localhost";


$conection = mysqli_connect($host, $user, $password, $database);
if (!$conection) {
    die(json_encode(["error" => "Conexion fallida: " . mysqli_connect_error()]));
}

$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conection, $sql);


$usuario = [];
if (mysqli_num_rows($result) > 0) {
    while ($fila = mysqli_fetch_assoc($result)) {
        $usuario[] = $fila;
    }
}
header('Content-Type: application/json');
echo json_encode($usuario);

?>