<?php
include("conect.php");
session_start();

$email = $_POST["email"];
$senha = $_POST["password"];

if ($email == "" || $senha == "") {
    echo "<script>
        alert('Preencha todos os campos');
        window.location.href = 'login.html';
    </script>";
    exit;
}

$sql = "SELECT * FROM users WHERE email = ? AND password = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$resultado = $stmt->get_result();

// Verifica se encontrou algum usuário
if ($resultado && $resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc(); //  define $usuario corretamente
   // $_SESSION['usuario_id'] = $usuario['id_usuario']; //  salva ID na sessão
    echo "logado";
   // header("Location: dashboard.php");
    exit;
} else {
    echo "<script>
        alert('Login inválido. Verifique seus dados.');
        window.location.href = 'login.html';
    </script>";
}
?>