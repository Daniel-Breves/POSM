<?php
include("conect.php");

//pegando do formulario e jogando no banco

$nom = $_POST["name"];
$email = $_POST["email"];
$pw = $_POST["password"];

//adicionando na tabela
$sql = "INSERT INTO users (name, email, password)
        VALUES (?,?,?)";

if ($nom == "" || $email == "" || $pw == "") {
    echo "<script>
        alert('Preencha todos os campos');
        window.location.href = 'signup.html';
    </script>";
    exit;
}

//traz segurança evitando erros
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sss",$nom, $email, $pw);


if($stmt->execute()){
    header("Location: login.html");
       
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $stmt->error . "');</script>";
    }
    

    $stmt->close();
    $conexao->close();

?>