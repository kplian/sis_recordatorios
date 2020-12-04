<?php
/***
 * Nombre: ActionSincronizarDestinatarios.php
 * Proposito:  Sincronizar los destinatarios
 * Autor:    valvarado
 * Fecha:    17-06-2020 22:13:29
 */
include_once(dirname(__FILE__) . "/../../lib/lib_control/CTSesion.php");
session_start();
$session = new CTSesion();
$session->setIdUsuario(1);
$_SESSION["_SESION"] = $session;
$_SESSION["ss_id_usuario"] = 1;
include(dirname(__FILE__) . '/../../lib/DatosGenerales.php');
include_once(dirname(__FILE__) . '/../../lib/lib_general/Errores.php');
ob_start();
$_SESSION["_CANTIDAD_ERRORES"] = 0;

include_once(dirname(__FILE__) . '/../../lib/lib_control/CTincludes.php');
include_once(dirname(__FILE__) . '/../../sis_recordatorios/control/ACTGenerico.php');

$objPostData = new CTPostData();
$arr_unlink = array();
$aPostData = $objPostData->getData();

$_SESSION["_PETICION"] = serialize($aPostData);
$objParam = new CTParametro($aPostData['p'], null, $aPostFiles);
$objParam->addParametro('id_usuario', 1);
$objParam->addParametro('cron', 1);
$recordatorio = new ACTGenerico($objParam);
$rs = $recordatorio->sincronizar();
print_r($rs);
?>