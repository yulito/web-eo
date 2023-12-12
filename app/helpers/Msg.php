<?php

namespace App\Helpers;

class Msg{
    //register
    const EMPTY_FIELD   = "Debes rellenar los campos obligatorios.";
    const ALL_FIELDS    = "Debes rellenar todos los campos.";
    const EMAIL_FORMAT  = "Formato de correo incorrecto.";
    const EMAIL_INVALID = "Correo invalido.";
    const FILE_DATA     = "Tipo de archivo incorrecto.";
    const PASS_LENGTH   = "La contraseña no cumple con los requisitos.";
    const PASS_INVALID  = "Contraseña invalida.";
    //login
    const MSG_SUCCESS   = "Operación realizada correctamente!.";
    const EMAIL_EXIST   = "Ya existe este correo registrado.";
    const NAME_EXIST    = "El nombre de usuario ya esta registrado.";
    const AUTH_ERROR    = "Idenficación fallida!!.";
    const WELCOME       = "Bienvenid@";
    //recovery
    const EMAIL_SEND    = "Se envio un link a tu correo para el cambio de contraseña!.";
    const ERR_MAIL_SEND = "Error al enviar solicitud a tu correo.";
    const PASS_NOTMATCH = "Las contraseñas no coinciden";
    const FAILED_OPERATION = "La operación a fallado!.";
    //http
    const ERROR_404 = "ERROR 404. la página no encontrada";
}