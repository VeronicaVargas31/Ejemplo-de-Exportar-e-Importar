<?php 
$user = "root";
$password = "123456789";
$database = "hello_mysql";
$host = "localhost";


$conection = mysqli_connect($host, $user, $password, $database);
if (!$conection) {
    die(json_encode(["error" => "Conexion fallida: " . mysqli_connect_error()]));
}


require 'vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST["importar"])) {
    if ($_FILES['excel']['size'] > 0) {
        if ($_FILES['excel']['type'] === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
    
        $ArchivoContent = $_FILES['excel']['tmp_name'];
        ImportarDatos($ArchivoContent, $conection);

     } else {
       echo "Error, el archivo seleccionado no es un Excel.";
      }
    } else {
     echo "Error, No existe archivo seleccionado";
     }
 }

function ImportarDatos($archivoExcel, $conection)
{
 $Documento = IOFactory::load($archivoExcel);
 $HojaExcel = $Documento->getActiveSheet();
 $FilasDeHojaExcel =$HojaExcel->getHighestDataRow();

 for($fila = 2;$fila <= $FilasDeHojaExcel;$fila++) {

    $usuario_id = $HojaExcel->getCell("A". $fila)->getValue();
    $nombre_completo = $HojaExcel->getCell("B". $fila)->getValue();
    $flor_favorita = $HojaExcel->getCell("C". $fila)->getValue(); 

//   echo "Usuario ID: $usuario_id, Nombre: $nombre_completo, Flor favorita: $flor_favorita<br>";


  if (empty($nombre_completo) || empty($flor_favorita)) {
    continue;
}



 if (RegistroPersona($usuario_id, $nombre_completo, $flor_favorita, $conection)) {
    echo "Usuario registrado correctamente.<br>";
} else {
    echo "Error al registrar usuario.<br>";
}

}

}

 function RegistroPersona($usuario_id_, $nombre_completo_, $flor_favorita_, $conection)
 {
  

    $sql = "INSERT INTO usuarios (usuario_id, nombre_completo, flor_favorita) VALUES (?, ?, ?)";
    try {
        if ($stmt = mysqli_prepare($conection, $sql)) {
            $stmt->bind_param('iss', $usuario_id_, $nombre_completo_, $flor_favorita_);
            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error al insertar usuario" . $stmt->error . "<br>";
                return false;
            }
        } else {
            echo "Error al preparar la consulta: " . mysqli_error($conection) . "<br>";
            return false;
        }
    } catch (\Throwable $th) {
        echo "Error: " . $th->getMessage() . "<br>";
        return false;
    }
}

?>

