#!/usr/bin/env php
<?php
/**
 * This scripts runs in a subfolder of Magento ROOT 
 */


require_once dirname(__FILE__)."/lib/common.php";
// print_r($argv);



// Input section 
$vendor= _readline('Enter Vendor name (eg: Vendor) ',"Vendor"); 
$module = _readline('Enter Module name (eg: MyModule) ',"MyModule");
//TODO improve function to check valid names

$gVENDOR=fixName($vendor);
$gMODULE=fixName($module);

// Entered integer is 10 and 
// entered float is 9.78 
$gMODULE_NAME = $gVENDOR . "_" . $gMODULE ;

preguntaAvanzarProceso("Continuar con la creacion del modulo? " . $gMODULE_NAME);

createModule();

function createModule(){
    global $MAGENTO_APP_CODE,$gVENDOR,$gMODULE,$gMODULE_NAME,$gMODULE_ROOT;

    //if not exist create code folder
    createFolder(join_path($MAGENTO_APP_CODE,$gVENDOR));
    $gMODULE_ROOT =  join_path($MAGENTO_APP_CODE,$gVENDOR,$gMODULE);
    $MODULE_ETC = join_path($gMODULE_ROOT,"etc"); 
    createFolder($gMODULE_ROOT);
    createFolder($MODULE_ETC);
    
    createFileModule($MODULE_ETC , $gMODULE_NAME);
    createFileRegistration($gMODULE_ROOT , $gMODULE_NAME);
    
    //TODO: implementar composer.json
}