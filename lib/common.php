<?php

require_once(dirname(__FILE__)."/M2.php");

//////////////// GLOBALS
$CURRENT= dirname(__FILE__);

//Magento
$MAGENTO_ROOT = realpath(join_path($CURRENT,"..",".."));
M2::init( $MAGENTO_ROOT);

$MAGENTO_APP        = M2::getFolder("app");
$MAGENTO_APP_ETC    = M2::getFolder("etc");
$MAGENTO_APP_CODE   = M2::getFolder("code");

//Modulo
$gVENDOR="";
$gMODULE="";
$gMODULE_NAME="";
$gMODULE_ROOT="";

//APP
$TEMPLATE_PATH_ROOT = realpath(dirname(__FILE__) . "/../templates/");

//////////////// fin GLOBALS

function createFileAction($MODULE_ROOT, $VENDOR , $MODULE , $CONTROLLER, $ACTION)
{

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/Controller/Page/View.php', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'CONTROLLER' => $CONTROLLER,
        'ACTION' => $ACTION
    ]);

    $MODULE_FOLDER_CONTROLLER = join_path($MODULE_ROOT,"Controller", $CONTROLLER);
    createFolder($MODULE_FOLDER_CONTROLLER);
    $MODULE_FILE_NAME = join_path($MODULE_FOLDER_CONTROLLER , $ACTION.".php" );
    file_put_contents($MODULE_FILE_NAME, $content);
}

function createFileRoutes($MODULE_ROOT, $MODULE_NAME, $AREA, $ROUTE_FRONTNAME)
{

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/etc/'.$AREA.'/routes.xml', [
        'MODULE_NAME' => $MODULE_NAME,
        'ROUTE_ID' => strtolower($MODULE_NAME."_". $ROUTE_FRONTNAME) ,
        'ROUTE_FRONTNAME' => strtolower($ROUTE_FRONTNAME)
    ]);

    $MODULE_FOLDER_AREA = join_path($MODULE_ROOT,"etc", $AREA);
    createFolder($MODULE_FOLDER_AREA);
    $MODULE_FILE_NAME = join_path($MODULE_FOLDER_AREA,"routes.xml");
    file_put_contents($MODULE_FILE_NAME, $content);
}

function createFileRegistration($MODULE_ROOT, $MODULE_NAME)
{
    // create file registration.php from template
    $content = getTemplateContent('module/vendor/registration.php', [
        'MODULE_NAME' => $MODULE_NAME
    ]);

    $MODULE_FILE_NAME = join_path($MODULE_ROOT, "registration.php");

    file_put_contents($MODULE_FILE_NAME, $content);
}

function createFileModule($MODULE_ETC, $MODULE_NAME)
{
    // create file module.xml from template
    $content = getTemplateContent('module/vendor/etc/module.xml', [
        'MODULE_NAME' => $MODULE_NAME
    ]);

    $MODULE_FILE_NAME = join_path($MODULE_ETC, "module.xml");

    file_put_contents($MODULE_FILE_NAME, $content);
}

/**
 * Eg:
 * join_path("home", "alice", "Documents", "example.txt");
 * -> home/alice/Documents/example.php
 */
function join_path(...$segments)
{
    return join(DIRECTORY_SEPARATOR, $segments);
}

function createFolder($pathToFolder)
{
    if (!file_exists($pathToFolder)) {
        mkdir($pathToFolder, 0777, true);
    }
}

function fixName($name2Normalice)
{
    //eg: HELLO WORLD -> Hello World
    return ucwords(strtolower($name2Normalice));
}

function menuQuestion($title, $arrayValorPosibles)
{
    $menuOptions=[];
    //create menu from optiones
    foreach ($arrayValorPosibles as $key => $label) {
        $menuOptions[]=[$key , $label];
    }

    do {
        
        echo "\n --------------------------------------";
        echo "\n ".$title;
        echo "\n ". str_pad("",count($title),".");

        //muestro menu numerico para facilitar el imput
        foreach ($menuOptions as $idMenu => $item) {
            echo "\n ".$idMenu. " - "  . $item[1] . "(".$item[0].")";
        }
    
        $idCurrentMenu = (int)_readline("Opcion del menu (numero): ");
    } while (!array_key_exists($idCurrentMenu,$menuOptions));
    
    return $menuOptions[$idCurrentMenu][0];
}


function yesNoQuestion($pregunta,$valorYes,$valorNo)
{
    $confirm = _readline($pregunta . " [ Y: ".$valorYes." | n: ".$valorNo."] ");
    if (strtolower($confirm) == 'n') {
        return $valorNo;
    }
    return $valorYes;
}

function preguntaAvanzarProceso($pregunta)
{
    $confirm = _readline($pregunta . " confirma Y/n: ");
    if (strtolower($confirm) == 'n') {
        die("Proceso cancelado por el usuario \n");
    }
}

function getTemplateContent($pathToFile, $arraValues)
{
    global $TEMPLATE_PATH_ROOT;

    $contentTemplate = file_get_contents(join_path($TEMPLATE_PATH_ROOT, $pathToFile));

    foreach ($arraValues as $k => $v) {
        $contentTemplate = str_replace("[@" . strtoupper($k) . "]", $v, $contentTemplate);
    }
    return $contentTemplate;
}


function _readline($question="",$defaul=""){

    $confirm = readline($question);
    return $confirm != "" ? $confirm : $defaul;
}