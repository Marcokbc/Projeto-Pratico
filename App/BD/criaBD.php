<?php

require_once "../includes/config.php";

$con = mysqli_connect(SERVER,USER,PASS);

if(!$con) die("ERRO DE CONEXÃO".mysqli_connect_error());

$sql = "CREATE DATABASE ".BD;

$resultado = mysqli_query($con,$sql);

if($resultado){
    echo "BANCO DE DADOS CRIADO";
}else{
    die("BANCO DE DADOS NAO FOI CRIADO".mysqli_error($con));
}