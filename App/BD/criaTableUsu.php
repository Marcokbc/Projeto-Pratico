<?php

require_once "../includes/connectBD.php";

$sql = "CREATE TABLE usuario(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200),
    login VARCHAR (100),
    senha VARCHAR (200)
    )";

$resultado = mysqli_query($con,$sql);

if(!$resultado){
    die("ERRO AO CRIAR A TABELA USUARIO".mysqli_error($con));
}else{
    echo "Tabela criada com sucesso!";
}