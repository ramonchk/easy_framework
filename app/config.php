<?php 
	DEFINE("DIR_SEPARATOR"    , "\\");
	DEFINE("URL_BASE"         , "http://localhost/framework");
	DEFINE("BASE_PATH"        , 'C:\wamp64\www\framework'.DIR_SEPARATOR);
	DEFINE("PUBLIC_PATH"      , DIR_SEPARATOR."public".DIR_SEPARATOR); // public
	DEFINE("LANGUAGE_DEFAULT" , "pt_BR"); // eng
	DEFINE("DEBUG"            , TRUE); // false
	DEFINE("USE_HTACCESS"     , TRUE); // true
	DEFINE("LOG"              , FALSE); // false
	DEFINE("EF_V"             , "Beta 1.5");

	DEFINE("LOG_PATH"         , "log".DIR_SEPARATOR);
	DEFINE("VIEWS_PATH"       , "app".DIR_SEPARATOR."views".DIR_SEPARATOR);
	DEFINE("MODEL_PATH"       , "app".DIR_SEPARATOR."model".DIR_SEPARATOR);
	DEFINE("CONTROLLER_PATH"  , "app".DIR_SEPARATOR."controller".DIR_SEPARATOR);
	DEFINE("HELPERS_PATH"     , "core".DIR_SEPARATOR."helpers".DIR_SEPARATOR);
	DEFINE("LANG_PATH"        , "lang".DIR_SEPARATOR);
	DEFINE("LANG_FILE"        , "lang.php");
?>