<?php

class M2
{

    public static $MAGE_ROOT = "";
    public static $cache = [
        "folder" => [],
        "modules" => []
    ]; 

    public static function init($MAGE_ROOT){
        self::$MAGE_ROOT = $MAGE_ROOT;
        self::$cache["folder"]['app'] = join_path( $MAGE_ROOT,"app");
        self::$cache["folder"]['etc'] = join_path( $MAGE_ROOT,"app","etc");
        self::$cache["folder"]['code'] = join_path( $MAGE_ROOT,"app","etc","code");

    }
    

    public static function getFolder($key){
        return self::$cache['folder'][$key];
    }

    public static function getExistingsVendors(){
        $codeDir = self::$cache['folder']['code'];
        $vendors=[];
        if( file_exists($codeDir)){
            $vendors = scandir($codeDir);
        }
        return $vendors;
    }
}

