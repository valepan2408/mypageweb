<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        
        // Validar teléfono (10 dígitos)
        if (!preg_match('/^\d{10}$/', $telefono)) {
            throw new Exception('El teléfono debe tener exactamente 10 dígitos');
        }
        
        $sql = "INSERT INTO pacientes (nombre, edad, sexo, correo, telefono, direccion) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $edad, $sexo, $correo, $telefono, $direccion]);
        
        echo json_encode(['success' => true, 'message' => 'Paciente registrado exitosamente']);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>