<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define("FRONT_ROOT", "/TP-FINAL-2022/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
ini_set('xdebug.max_nesting_level', 600);


define("DB_HOST", "localhost");
define("DB_NAME", "pet_home");
define("DB_USER", "root");
define("DB_PASS", "1456");
?>




