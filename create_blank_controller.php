#!/usr/bin/env php
<?php
/**
 * This scripts runs in a subfolder of Magento ROOT 
 */

// COMUNES
require_once dirname(__FILE__)."/lib/common.php";

// creacion/seleccion modulo
require_once(dirname(__FILE__)."/create_blank_module.php");


//ESPECIFICO de creacr controller
//creo arhivo action dentro de carpeta controllers
$MODULE_ETC_CONTROLLER = join_path($gMODULE_ROOT,"Controller");
createFolder($MODULE_ETC_CONTROLLER);

// Input section 

//create routes.xml segun area (frontend | adminhtml)
$area = yesNoQuestion("Area frontend ?","frontend","adminhtml");
//end point
$end_point= _readline('Url end-point frontname/controller/action (eg: test/page/view) ',"test/page/view"); 

list($frontname,$controller,$action) = explode("/",$end_point);

//TODO improve function to check valid names
$frontname= fixName($frontname);
$controller= fixName($controller);
$action= fixName($action);

createFileRoutes($gMODULE_ROOT , $gMODULE_NAME , $area , $frontname);
createFileAction($gMODULE_ROOT, $gVENDOR , $gMODULE , $controller , $action);