<?php
require_once 'shield.php';
include('conect.php');

$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["username"];
    $em = $_POST["email"];
    $pw = $_POST["password"];

    // Verifique se os dados estão preenchidos
    if (empty($id_usuario) || empty($em) || empty($nom) || empty($pw)) {
        die("error data");
    }

    // Query com WHERE e placeholders
    $sql = "UPDATE users SET name = ?,  email = ?, password = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a query: " . $conexao->error);
    }

    // Bind dos parâmetros
    $stmt->bind_param("sssi", $nom, $em, $pw, $id_usuario);

    // Executa a query preparada
    if ($stmt->execute()) {
      header("Location: profile.php");
    } else {
        echo "<script>
            alert('Error: " . addslashes($stmt->error) . "');
            window.location.href = 'dados.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Requisição inválida.');
        window.location.href = 'profile.php.php';
    </script>";
}
?>