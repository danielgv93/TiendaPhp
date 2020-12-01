<?php

function guardarImagenDispositivo($nombreImagen, $archivoImagen)
{
    $targetFile = "img/dispositivos/" . $nombreImagen . "." . getExtension($archivoImagen["type"]);
    if (!file_exists($archivoImagen["tmp_name"])) {
        throw new Exception("Elige imagen para subir");
    }
    if (move_uploaded_file($archivoImagen["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    return false;
}

function guardarImagenUsuario($nombreUsuario, $archivoImagen)
{
    $targetFile = "img/usuarios/" . $nombreUsuario . "." . getExtension($archivoImagen["type"]);
    if (!file_exists($archivoImagen["tmp_name"])) {
        throw new Exception("Elige imagen para subir");
    }
    if (move_uploaded_file($archivoImagen["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    return false;
}

function getExtension($tipoImagen)
{
    try {
        if ($tipoImagen == null) {
            throw new Exception("Elige una imagen");
        }
        return explode("/", $tipoImagen)[1];
    } catch (Exception $e) {
    }
}