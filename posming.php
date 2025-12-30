<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];



//pegando do formulario e jogando no banco

$ct = $_POST["content"];

//adicionando na tabela
$sql = "INSERT INTO posmings (content, id_author)
        VALUES (?,?)";

//traz segurança evitando erros
$stmt = $conexao->prepare($sql);
$stmt->bind_param("si",$ct, $id_usuario);


if($stmt->execute()){
    header("Location: profile.php");
       
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    

    $stmt->close();
    $conexao->close();

?>