<?php
//create handler file for grid view/adminhtml/layout/ menuid_grid_entityname.xml
function createControllerGrid($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $nameEntity){
    $MODULE_FOLDER_CONTROLLER = join_path($MODULE_ROOT,"Controller");
    createFolder($MODULE_FOLDER_CONTROLLER);
    $MODULE_FOLDER_CONTROLLER_ADMINHTML = join_path($MODULE_FOLDER_CONTROLLER,"Adminhtml");
    createFolder($MODULE_FOLDER_CONTROLLER_ADMINHTML);

    $MODULE_FOLDER_CONTROLLER_ADMINHTML_GRID = join_path($MODULE_FOLDER_CONTROLLER_ADMINHTML,"Grid");
    createFolder($MODULE_FOLDER_CONTROLLER_ADMINHTML_GRID);


    // create file registration.php from template
    $content = getTemplateContent('module/vendor/Controller/Adminhtml/Grid/Obj.php', [
       'VENDOR' => $VENDOR,
       'MODULE' => $MODULE,
       'MODULE_NAME' => strtolower($MODULE_NAME),
       'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
       'ENTITY_NAME' => $nameEntity,
       'ENTITY_NAME_LOW' => strtolower($nameEntity)
   ]);

   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_CONTROLLER_ADMINHTML_GRID,$nameEntity.".php");
   file_put_contents($MODULE_FILE_NAME, $content);
}

//create uicomponent xml
function createUiGrid($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $nameEntity,$colsEntity){
    $MODULE_FOLDER_VIEW = join_path($MODULE_ROOT,"view");
    createFolder($MODULE_FOLDER_VIEW);
    $MODULE_FOLDER_VIEW_ADMINHTML = join_path($MODULE_FOLDER_VIEW,"adminhtml");
    createFolder($MODULE_FOLDER_VIEW_ADMINHTML);
    $MODULE_FOLDER_VIEW_ADMINHTML_UI = join_path($MODULE_FOLDER_VIEW_ADMINHTML,"ui_component");
    createFolder($MODULE_FOLDER_VIEW_ADMINHTML_UI);

    //////////////////
    $COLUMNSGRID='';
    $COLUMNSID='';
    $COLUMNS='';

    foreach ($colsEntity as $key => $value) {
        $name = $value['name'];
        $fixedName = fixNameClass($name);

        if(isset($value['identity'])){
            $COLUMNSID .="\n"."<column name=\"$name\">";
            $COLUMNSID .="\n"."    <argument name=\"data\" xsi:type=\"array\">";
            $COLUMNSID .="\n"."        <item name=\"config\" xsi:type=\"array\">";
            $COLUMNSID .="\n"."            <item name=\"filter\" xsi:type=\"string\">textRange</item>";
            $COLUMNSID .="\n"."            <item name=\"sorting\" xsi:type=\"string\">asc</item>";
            $COLUMNSID .="\n"."            <item name=\"label\" xsi:type=\"string\" translate=\"true\">$fixedName</item>";
            $COLUMNSID .="\n"."        </item>";
            $COLUMNSID .="\n"."    </argument>";
            $COLUMNSID .="\n"."</column>";
        }else{

            $COLUMNS .="\n"."<column name=\"$name\">";
            $COLUMNS .="\n"."    <argument name=\"data\" xsi:type=\"array\">";
            $COLUMNS .="\n"."        <item name=\"config\" xsi:type=\"array\">";
            $COLUMNS .="\n"."            <item name=\"filter\" xsi:type=\"string\">text</item>";
            $COLUMNS .="\n"."            <item name=\"editor\" xsi:type=\"array\">";
            $COLUMNS .="\n"."                <item name=\"editorType\" xsi:type=\"string\">text</item>";
            $COLUMNS .="\n"."                <item name=\"validation\" xsi:type=\"array\">";
            $COLUMNS .="\n"."                    <item name=\"required-entry\" xsi:type=\"boolean\">true</item>";
            $COLUMNS .="\n"."                </item>";
            $COLUMNS .="\n"."            </item>";
            $COLUMNS .="\n"."            <item name=\"label\" xsi:type=\"string\" translate=\"true\">$fixedName</item>";
            $COLUMNS .="\n"."        </item>";
            $COLUMNS .="\n"."    </argument>";
            $COLUMNS .="\n"."</column>";
        }

    }

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/view/adminhtml/ui_component/ui_component_name.xml', [
       'VENDOR' => $VENDOR,
       'MODULE' => $MODULE,
       'MODULE_NAME' => strtolower($MODULE_NAME),
       'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
       'ENTITY_NAME' => $nameEntity,
       'ENTITY_NAME_LOW' => strtolower($nameEntity),
       'COLUMNSGRID' => $COLUMNSID . "\n" . $COLUMNS
   ]);

   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_VIEW_ADMINHTML_UI, strtolower($MODULE_NAME . "_" . $nameEntity)."_grid.xml");
   file_put_contents($MODULE_FILE_NAME, $content);
}

//create handler file for grid view/adminhtml/layout/ menuid_grid_entityname.xml
function createHandlerLayoutGrid($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $nameEntity){
    $MODULE_FOLDER_VIEW = join_path($MODULE_ROOT,"view");
    createFolder($MODULE_FOLDER_VIEW);
    $MODULE_FOLDER_VIEW_ADMINHTML = join_path($MODULE_FOLDER_VIEW,"adminhtml");
    createFolder($MODULE_FOLDER_VIEW_ADMINHTML);
    $MODULE_FOLDER_VIEW_ADMINHTML_LAYOUT = join_path($MODULE_FOLDER_VIEW_ADMINHTML,"layout");
    createFolder($MODULE_FOLDER_VIEW_ADMINHTML_LAYOUT);


    // create file registration.php from template
    $content = getTemplateContent('module/vendor/view/adminhtml/layout/menuid_grid_entityname.xml', [
       'VENDOR' => $VENDOR,
       'MODULE' => $MODULE,
       'MODULE_NAME' => strtolower($MODULE_NAME),
       'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
       'ENTITY_NAME' => $nameEntity,
       'ENTITY_NAME_LOW' => strtolower($nameEntity)
   ]);

   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_VIEW_ADMINHTML_LAYOUT,strtolower($MODULE_NAME)."_grid_" .strtolower($nameEntity) .".xml");
   file_put_contents($MODULE_FILE_NAME, $content);
}

//create /adminhtml/menu.xml
function createMenuGrid($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $nameEntity){

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/etc/adminhtml/menu.xml', [
       'VENDOR' => $VENDOR,
       'MODULE' => $MODULE,
       'MODULE_NAME' => strtolower($MODULE_NAME),
       'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
       'ENTITY_NAME' => $nameEntity,
       'ENTITY_NAME_LOW' => strtolower($nameEntity)
   ]);

   $MODULE_FOLDER_ETC = join_path($MODULE_ROOT,"etc");
   createFolder($MODULE_FOLDER_ETC);
   $MODULE_FOLDER_ETC_ADMIHTML = join_path($MODULE_FOLDER_ETC,"adminhtml");
   createFolder($MODULE_FOLDER_ETC_ADMIHTML);
   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_ETC_ADMIHTML,"menu.xml");
   file_put_contents($MODULE_FILE_NAME, $content);
}

//create /adminhtml/routes.xml
function createRoutesGrid($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $nameEntity){

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/etc/adminhtml/routes.xml', [
       'VENDOR' => $VENDOR,
       'MODULE' => $MODULE,
       'MODULE_NAME' => strtolower($MODULE_NAME),
       'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
       'ENTITY_NAME' => $nameEntity,
       'ENTITY_NAME_LOW' => strtolower($nameEntity)
   ]);

   $MODULE_FOLDER_ETC = join_path($MODULE_ROOT,"etc");
   createFolder($MODULE_FOLDER_ETC);
   $MODULE_FOLDER_ETC_ADMIHTML = join_path($MODULE_FOLDER_ETC,"adminhtml");
   createFolder($MODULE_FOLDER_ETC_ADMIHTML);
   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_ETC_ADMIHTML,"routes.xml");
   file_put_contents($MODULE_FILE_NAME, $content);
}

//create di.xml
function createDiGrid($MODULE_ROOT , $MODULE_NAME, $VENDOR , $MODULE , $nameEntity){

    // create file registration.php from template
    $content = getTemplateContent('module/vendor/etc/di.xml', [
       'VENDOR' => $VENDOR,
       'MODULE' => $MODULE,
       'MODULE_NAME' => strtolower($MODULE_NAME),
       'TABLE_NAME' => strtolower($MODULE_NAME . "_" . $nameEntity),
       'ENTITY_NAME' => $nameEntity,
       'ENTITY_NAME_LOW' => strtolower($nameEntity)
   ]);

   $MODULE_FOLDER_ETC = join_path($MODULE_ROOT,"etc");
   createFolder($MODULE_FOLDER_ETC);
   $MODULE_FILE_NAME = join_path($MODULE_FOLDER_ETC,"di.xml");
   file_put_contents($MODULE_FILE_NAME, $content);
}


//create db_schema.xml
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



//create webapi.xml
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

//create API folders and Interfaces
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

//create Model folder and models


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
