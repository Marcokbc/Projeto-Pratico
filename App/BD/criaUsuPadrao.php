<?php

require_once "../includes/connectBD.php";

//md5 -> encriptar mais rapido e menos seguro
//sha1 -> encriptar um pouco mais lento mas mais seguro

$nome = "admin";
$login = "admin";
$senha = sha1("12345");

$sql = "INSERT INTO usuario(nome,login,senha) VALUES ('$nome','$login','$senha')";

$resultado = mysqli_query($con,$sql);

if(!$resultado){
    die("ERRO AO CRIAR USUARIO PADRÃO".mysqli_error($con));
}else{
    echo "Usuario padrão criado com sucesso";
}
