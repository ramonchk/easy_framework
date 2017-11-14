<?php 
	$message["viewnotfound"]            = "View '{viewName}' not found!";
	$message["modelnotfound"]           = "Model '{modelName}' not found!";
	$message["controllernotfound"]      = "Controller '{controllName}' not found!";
	$message["helpernotfound"]          = "Helper '{modelName}' not found!";
	$message["noroute"]                 = "Route '{routeName}' not defined!";
	$message["newroutesuccess"]         = "Route '{routeName}' created successfully!";
	$message["welcometitleindex"]       = "Welcome to Easy Framework!";
	$message["welcomeloadindex"]        = "Page loaded in";
	$message["welcomesecondsindex"]     = "seconds";
	$message["welcomemessageindex"]     = "Easy and beautiful!<br/><pre><code>//app/routes.app\nRoute::get( '/route', 'ControllerClass.Func');\n\n//app/controller/ControllerClass.php\nclass ControllerClass{\n\tpublic function index(){\n\t\techo 'Index Page';\n\t}\n\tpublic function Func(){\n\t\techo '/Route Page';\n\t}\n}\n</code></pre><small>Highlights by <a href = \"https://highlightjs.org/\" target = \"_blank\">Highlight.js</a></small>";
	$message['uploaderror']             = "Extension not allowed!";
	$message['uploadsuccess']           = "Successfully uploaded!";
	$message['uploaderror1']            = "The uploaded file exceeds the upload_max_filesize directive in php.ini!";
	$message['uploaderror2']            = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form!";
	$message['uploaderror3']            = "The uploaded file was only partially uploaded!";
	$message['uploaderror4']            = "No file was uploaded!";
	$message['uploaderror6']            = "Missing a temporary folder!";
	$message['uploaderror7']            = "Failed to write file to disk!";
	$message['uploaderror8']            = "A PHP extension stopped the file upload!";
	$message['restrictedaccesstitle']   = "Restricted access!";
	$message['restrictedaccessmessage'] = "Access to this part of the website is restricted!<br/><a href=\"".base_url()."\">Back to Home Page</a>"
?>