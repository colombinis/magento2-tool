#!/usr/bin/env php
<?php
/**
 * This scripts runs in a subfolder of Magento ROOT 
 */

// COMUNES
require_once dirname(__FILE__)."/lib/common.php";

// creacion/seleccion modulo
require_once dirname(__FILE__)."/create_blank_module.php";


//ESPECIFICO de crear evento
//- obtener el/los eventos a escuchar
//- crear clase que maneje el evento
//- crear archivo events.xml en el area global/adminhtml/frontend

//Inputs
//Magento event
$magento_event_to_listen= _readline('Magento Event (eg: sales_order_place_after) ',"sales_order_place_after"); 
//create segun area (frontend | adminhtml)
$area = yesNoQuestion("Area frontend ?","frontend","adminhtml");
$eventClassName= fixNameClass($magento_event_to_listen);


createFileEvent($gMODULE_ROOT , $gMODULE_NAME, $gVENDOR , $gMODULE , $area ,$eventClassName,$magento_event_to_listen);
createFileObserver($gMODULE_ROOT, $gVENDOR , $gMODULE , $eventClassName);