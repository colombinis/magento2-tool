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
//- obtener nombre Entidad
//- obtener los attributos separados por coma
//- Crea grid Backend?

//Inputs
$nameEntity= _readline('Name Entity (eg: Blog) ',"Blog");
$txtAttributes = _readline('Attributes (eg: [ { "name": "entity_id", "xsi:type": "int", "identity": true }, { "name": "title", "xsi:type": "varchar" }, { "name": "content", "xsi:type": "mediumtext" }, { "name": "created_at", "xsi:type": "timestamp" }, { "name": "updated_at", "xsi:type": "timestamp" } ]) ','[ { "name": "entity_id", "xsi:type": "int", "identity": true }, { "name": "title", "xsi:type": "varchar" }, { "name": "content", "xsi:type": "mediumtext" }, { "name": "created_at", "xsi:type": "timestamp" }, { "name": "updated_at", "xsi:type": "timestamp" } ]');
$createGrid = yesNoQuestion("Create backend grid ?","yes","no");

$attributesEntity = parseEntityAttributes($txtAttributes);

// foreach ($attributesEntity as $key => $value) {
//     echo "------------------";
//     echo var_dump($key);
//     echo "::";
//     echo var_dump($value);
//     echo "------------------";
// }

//create db_schema.xml
createFileDBSchema($gMODULE_ROOT , $gMODULE_NAME, $gVENDOR , $gMODULE ,$nameEntity,$attributesEntity);
//create webapi.xml
createFileWebapi($gMODULE_ROOT , $gMODULE_NAME, $gVENDOR , $gMODULE ,$nameEntity);

//create API folders and Interfaces
createApiInterfacesDBSchema($gMODULE_ROOT , $gMODULE_NAME, $gVENDOR , $gMODULE ,$nameEntity,$attributesEntity);

//create Model folder and models
createModelStructure($gMODULE_ROOT , $gMODULE_NAME, $gVENDOR , $gMODULE ,$nameEntity,$attributesEntity);

