<?php 
	$message["viewnotfound"]            = "View '{viewName}' não encontrada!";
	$message["modelnotfound"]           = "Model '{modelName}' não encontrado!";
	$message["controllernotfound"]      = "Controller '{controllName}' não encontrado!";
	$message["helpernotfound"]          = "Helper '{modelName}' não encontrado!";
	$message["noroute"]                 = "Rota '{routeName}' não definida!";
	$message["newroutesuccess"]         = "Rota '{routeName}' criada com sucesso!";
	$message["welcometitleindex"]       = "Bem-vindo ao Easy Framework!";
	$message["welcomeloadindex"]        = "Página carregada em";
	$message["welcomesecondsindex"]     = "segundos";
	$message["welcomemessageindex"]     = "Fácil e bonito!<br/><pre><code>//app/routes.app\nRoute::get( '/rota', 'ClasseController.Func');\n\n//app/controller/ClasseController.php\nclass ClasseController{\n\tpublic function index(){\n\t\techo 'Index Page';\n\t}\n\tpublic function Func(){\n\t\techo '/Route Page';\n\t}\n}\n</code></pre><small>Highlights por <a href = \"https://highlightjs.org/\" target = \"_blank\">Highlight.js</a></small>";
	$message['uploaderror']             = "Extenção não permitida!";
	$message['uploadsuccess']           = "Upload foi realizado com sucesso!";
	$message['uploaderror1']            = "O upload excede a diretriz upload_max_filesize em php.ini!";
	$message['uploaderror2']            = "O upload excede a diretriz MAX_FILE_SIZE que foi especificada no formulário HTML!";
	$message['uploaderror3']            = "O upload só foi parcialmente carregado!";
	$message['uploaderror4']            = "Nenhum arquivo foi carregado!";
	$message['uploaderror6']            = "Faltando uma pasta temporária!";
	$message['uploaderror7']            = "Falha ao gravar arquivo no disco!";
	$message['uploaderror8']            = "Uma extensão do PHP interrompeu o upload do arquivo!";
	$message['restrictedaccesstitle']   = "Acesso Restrito!";
	$message['restrictedaccessmessage'] = "O acesso a esta parte do site é restrito!<br/><a href=\"".base_url()."\">Voltar para a Home Page</a>"
?>