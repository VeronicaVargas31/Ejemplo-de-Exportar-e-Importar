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

$rows = $result -> fetch_all(MYSQLI_ASSOC);




// Sección para descargar el archivo CSV 

    // Definir el nombre del archivo 
    $filename = "exportar_usuarios.csv" ; 

    // Define el delimitador (carácter separador) 
    $delimiter = "," ; 

    // Crea un puntero de archivo 
    $f = fopen ( 'php://memory' , 'w' ); 

    // Obtiene los nombres de las columnas 
    $fields = array_keys ( current ( $rows )); 

    // Escribe los nombres de las columnas en el archivo CSV 
    fputcsv ( $f , $fields , $delimiter ); 

    // Escribe todos los registros de usuario en el archivo CSV 
    
    foreach ( $rows  as  $row ) { 
        fputcsv ( $f , $row , $delimiter ); 
    } 

    // Mueve el puntero del archivo al principio del archivo 
    fseek ( $f , 0 ); 

    // Establece los encabezados HTTP para descargar el archivo CSV en lugar de mostrarlo 
    header ( 'Content-Type: text/csv'); 
    header ( 'Content-Disposition: attached; filename="' . $filename . '";' ); 

    // Mostrar todos los datos restantes en un puntero de archivo 
    fpassthru ( $f ); 

    // Cerrar el puntero de archivo 
    fclose ( $f ); 

    // Detener el script PHP 
    exit ; 

?>