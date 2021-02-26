#!/usr/bin/env php
<?php
/**
 * This scripts runs in a subfolder of Magento ROOT 
 */

// COMUNES
require_once dirname(__FILE__)."/lib/common.php";

//Objetivo listar los modulos existentes en app/code
// y seleccionar existente o crear uno nuevo

$vendors = M2::getExistingsVendors();
print_r($vendors);