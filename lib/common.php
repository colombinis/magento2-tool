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

function createFileComposer($MODULE_ROOT , $MODULE_NAME,$VENDOR , $MODULE){
    // create file composer.json from template
    $content = getTemplateContent('module/vendor/composer.json', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'MODULE_NAME' =>  $MODULE_NAME,
        'VENDOR_COMPOSER' =>  strtolower($VENDOR),
        'MODULE_NAME_COMPOSER' =>  str_replace("_","-",strtolower($MODULE_NAME))
    ]);

    $MODULE_FILE_NAME = join_path($MODULE_ROOT , "composer.json" );
    file_put_contents($MODULE_FILE_NAME, $content);
}

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

function createFileObserver($MODULE_ROOT, $VENDOR , $MODULE , $EVENT_CLASS)
{

    // create Observer Class file from template
    $content = getTemplateContent('module/vendor/Observer/ObserverClass.php', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'EVENT_CLASS' => $EVENT_CLASS
    ]);

    //Crear archivo de clase
    $MODULE_ETC_OBSERVER = join_path($MODULE_ROOT,"Observer");
    createFolder($MODULE_ETC_OBSERVER);

    $MODULE_FILE_NAME = join_path($MODULE_ETC_OBSERVER , $EVENT_CLASS.".php" );
    file_put_contents($MODULE_FILE_NAME, $content);
}

function createFileWebapi($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $nameEntity){

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/etc/webapi.xml', [
       'VENDOR' => $VENDOR,
       'MODULE' => $MODULE,
       'MODULE_NAME' => strtolower($MODULE_NAME),
       'ENTITY_NAME' => $nameEntity
   ]);

   $MODULE_FOLDER_ETC = join_path($MODULE_ROOT,"etc");
   createFolder($MODULE_FOLDER_ETC);
   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_ETC,"webapi.xml");
   file_put_contents($MODULE_FILE_NAME, $content);
}


function createModelStructure($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE ,$nameEntity,$colsEntity){
    $MODULE_FOLDER_MODEL = join_path($MODULE_ROOT,"Model");
    createFolder($MODULE_FOLDER_MODEL);
    $MODULE_FOLDER_MODEL_RESOURCE = join_path($MODULE_FOLDER_MODEL,"ResourceModel");
    createFolder($MODULE_FOLDER_MODEL_RESOURCE);
    $MODULE_FOLDER_MODEL_RESOURCE_ENTITY = join_path($MODULE_FOLDER_MODEL_RESOURCE,$nameEntity);
    createFolder($MODULE_FOLDER_MODEL_RESOURCE_ENTITY);

//////////////////
$content = getTemplateContent('module/vendor/Model/ResourceModel/Obj/Collection.php', [
    'VENDOR' => $VENDOR,
    'MODULE' => $MODULE,
    'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
    'ENTITY_NAME' => $nameEntity
]);
$MODULE_FILE_NAME = join_path($MODULE_FOLDER_MODEL_RESOURCE_ENTITY, "Collection.php");
file_put_contents($MODULE_FILE_NAME, $content);

//////////////////

//////////////////
$content = getTemplateContent('module/vendor/Model/ResourceModel/Obj.php', [
    'VENDOR' => $VENDOR,
    'MODULE' => $MODULE,
    'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
    'ENTITY_NAME' => $nameEntity
]);
$MODULE_FILE_NAME = join_path($MODULE_FOLDER_MODEL_RESOURCE, $nameEntity.".php");
file_put_contents($MODULE_FILE_NAME, $content);

//////////////////

    $content = getTemplateContent('module/vendor/Model/ObjSearchResult.php', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'ENTITY_NAME' => $nameEntity
    ]);
   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_MODEL, $nameEntity."SearchResult.php");
   file_put_contents($MODULE_FILE_NAME, $content);

//////////////////
   $content = getTemplateContent('module/vendor/Model/ObjRepository.php', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'ENTITY_NAME' => $nameEntity
    ]);
    $MODULE_FILE_NAME = join_path($MODULE_FOLDER_MODEL, $nameEntity."Repository.php");
    file_put_contents($MODULE_FILE_NAME, $content);

//////////////////

$CONSTANTES = '';
$GETTERS = '';
$SETTERS = '';
foreach ($colsEntity as $key => $value) {
    $name = $value['name'];
    $upper_name = strtoupper($name);
    $fixedName = fixNameClass($name);
    $CONSTANTES .="\n"."const $upper_name = '$name'; ";

    $GETTERS .="\n";
    $GETTERS .="\n"."public function get$fixedName() ";
    $GETTERS .="\n"."{ ";
    $GETTERS .="\n"."    return \$this->_getData(self::$upper_name); ";
    $GETTERS .="\n"."} ";

    $SETTERS .="\n";
    $SETTERS .="\n"."public function set$fixedName(\$$name) ";
    $SETTERS .="\n"."{ ";
    $SETTERS .="\n"."    \$this->setData(self::$upper_name, \$$name); ";
    $SETTERS .="\n"."} ";
}
    $content = getTemplateContent('module/vendor/Model/Obj.php', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'ENTITY_NAME' => $nameEntity,
        'CONSTANTES' => $CONSTANTES,
        'GETTERS' => $GETTERS,
        'SETTERS' => $SETTERS
    ]);
    $MODULE_FILE_NAME = join_path($MODULE_FOLDER_MODEL, $nameEntity.".php");
    file_put_contents($MODULE_FILE_NAME, $content);

}

function createApiInterfacesDBSchema($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE ,$nameEntity,$colsEntity){
    $MODULE_FOLDER_API = join_path($MODULE_ROOT,"Api");
    createFolder($MODULE_FOLDER_API);
    $MODULE_FOLDER_API_DATA = join_path($MODULE_FOLDER_API,"Data");
    createFolder($MODULE_FOLDER_API_DATA);


    $content = getTemplateContent('module/vendor/Api/ObjRepositoryInterface.php', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'ENTITY_NAME' => $nameEntity
    ]);
   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_API, $nameEntity."RepositoryInterface.php");
   file_put_contents($MODULE_FILE_NAME, $content);

//////////////////
   $content = getTemplateContent('module/vendor/Api/Data/ObjSearchResultInterface.php', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'ENTITY_NAME' => $nameEntity
    ]);
    $MODULE_FILE_NAME = join_path($MODULE_FOLDER_API_DATA, $nameEntity."SearchResultInterface.php");
    file_put_contents($MODULE_FILE_NAME, $content);

//////////////////
$GETTERS='';
$SETTERS='';
    foreach ($colsEntity as $key => $value) {
        $name = $value['name'];
        $fixedName = fixNameClass($name);
        $GETTERS .="\n";
        $GETTERS .="\n"."/**";
        $GETTERS .="\n"." * @return string";
        $GETTERS .="\n"." */ ";
        $GETTERS .="\n"."public function get$fixedName(); ";

        $SETTERS .="\n";
        $SETTERS .="\n"."/** ";
        $SETTERS .="\n"." * @param string \$$name ";
        $SETTERS .="\n"." * @return void";
        $SETTERS .="\n"." */ ";
        $SETTERS .="\n"."public function set$fixedName(\$$name); ";
    }


    $content = getTemplateContent('module/vendor/Api/Data/ObjInterface.php', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'ENTITY_NAME' => $nameEntity,
        'GETTERS' => $GETTERS,
        'SETTERS' => $SETTERS
    ]);
    $MODULE_FILE_NAME = join_path($MODULE_FOLDER_API_DATA, $nameEntity."Interface.php");
    file_put_contents($MODULE_FILE_NAME, $content);
}

function createFileDBSchema($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $nameEntity,$colsEntity){

    $TABLE_COLUMNS = '';
    foreach ($colsEntity as $key => $attributes) {
        $TABLE_COLUMNS .= "\n".'<column ';

        //si es varchar asumo length 255
        if(isset($attributes['xsi:type']) && $attributes['xsi:type']=="varchar"){
            $TABLE_COLUMNS .= ' length="255" ';
        }

        //si no hay comentario agrego desde el name
        if(!isset($attributes['comment'])){
            $TABLE_COLUMNS .= "comment=\"". $attributes['name'] ."\" ";
        }

        //si no es identity asumo que es nullable
        if(isset($attributes['identity'])){
            $TABLE_COLUMNS .= ' nullable="false" ';
        }else{
            $TABLE_COLUMNS .= ' nullable="true" ';
        }

        foreach ($attributes as $key => $value) {
            $TABLE_COLUMNS .= " $key=\"$value\" ";
        }
        $TABLE_COLUMNS .= '/>';
    }

    $TABLE_CONSTRAINS ='<constraint xsi:type="primary" referenceId="PRIMARY">';
    foreach ($colsEntity as $key => $attributes) {
        if(isset($attributes['identity'])){
            $TABLE_CONSTRAINS .= '<column name="'.$attributes['name'].'" />';
        }
    }
    $TABLE_CONSTRAINS .='</constraint>';

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/etc/db_schema.xml', [
       'VENDOR' => $VENDOR,
       'MODULE' => $MODULE,
       'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
       'TABLE_COLUMNS' => $TABLE_COLUMNS,
       'TABLE_CONSTRAINS' => $TABLE_CONSTRAINS
   ]);

   $MODULE_FOLDER_ETC = join_path($MODULE_ROOT,"etc");
   createFolder($MODULE_FOLDER_ETC);
   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_ETC,"db_schema.xml");
   file_put_contents($MODULE_FILE_NAME, $content);
}

function createFileEvent($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $AREA ,$EVENT_CLASS, $MAGENTO_EVENT_TO_LISTEN){
     // create file registration.php from template
     $content = getTemplateContent('module/vendor/etc/events.xml', [
        'VENDOR' => $VENDOR,
        'MODULE' => $MODULE,
        'MAGENTO_EVENT_TO_LISTEN' => $MAGENTO_EVENT_TO_LISTEN,
        'EVENT_NAME' => strtolower($MODULE_NAME."_". $MAGENTO_EVENT_TO_LISTEN),
        'EVENT_CLASS' => $EVENT_CLASS
    ]);

    $MODULE_FOLDER_AREA = join_path($MODULE_ROOT,"etc", $AREA);
    createFolder($MODULE_FOLDER_AREA);
    $MODULE_FILE_NAME = join_path($MODULE_FOLDER_AREA,"events.xml");
    file_put_contents($MODULE_FILE_NAME, $content);
}

function createFileRoutes($MODULE_ROOT, $MODULE_NAME, $AREA, $ROUTE_FRONTNAME)
{

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/etc/routes.xml', [
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

function fixNameClass($name2Normalice)
{
    //eg: HELLO_WORLD -> HelloWorld
    $name2Normalice = str_replace("_"," ",$name2Normalice); //HELLO WORLD
    $name2Normalice = fixName($name2Normalice);             //Hello World
    $name2Normalice = str_replace(" ","",$name2Normalice);  //HelloWorld
    return ucwords(strtolower($name2Normalice));
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


/**
 * @param string $jsonAttributes
 *
 * @return array
 */
function parseEntityAttributes($jsonAttributes){
    $attributes= [];
//E.g
//  Input-> [ { "name": "entity_id", "type": "int", "primary": true }, { "name": "title", "type": "varchar" }, { "name": "content", "type": "mediumtext" }, { "name": "created_at", "type": "timestamp" }, { "name": "updated_at", "type": "timestamp" } ]
//  Output->
//          [
//              "entity_id" => "int",
//              "title" => "varchar",
//              "content" => "mediumtext",
//              "created_at" => "timestamp",
//              "updated_at" => "timestamp",
//          ]

    $values =  json_decode($jsonAttributes,true);

    return $values;
}
