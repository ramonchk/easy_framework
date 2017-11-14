<?php 
	DEFINE("DIR_SEPARATOR"    , "\\");
	DEFINE("URL_BASE"         , $config["URL_BASE"]);
	DEFINE("BASE_PATH"        , $config["BASE_PATH"].DIR_SEPARATOR);
	DEFINE("PUBLIC_PATH"      , DIR_SEPARATOR."public".DIR_SEPARATOR); // public
	DEFINE("CORE_PATH"        , "core".DIR_SEPARATOR);
	DEFINE("LANGUAGE_DEFAULT" , $config["LANGUAGE"]); // eng
	DEFINE("DEBUG"            , $config["DEBUG"]); // false
	DEFINE("USE_HTACCESS"     , $config["USE_HTACCESS"]); // true
	DEFINE("LOG"              , $config["LOG"]); // false
	DEFINE("EF_V"             , "Beta 1.8");
	DEFINE("LOG_PATH"         , "log".DIR_SEPARATOR);
	DEFINE("VIEWS_PATH"       , "app".DIR_SEPARATOR."views".DIR_SEPARATOR);
	DEFINE("MODEL_PATH"       , "app".DIR_SEPARATOR."model".DIR_SEPARATOR);
	DEFINE("CONTROLLER_PATH"  , "app".DIR_SEPARATOR."controller".DIR_SEPARATOR);
	DEFINE("HELPERS_PATH"     , CORE_PATH."helpers".DIR_SEPARATOR);
	DEFINE("LANG_PATH"        , "lang".DIR_SEPARATOR);
	DEFINE("LANG_FILE"        , "lang.php");
?>