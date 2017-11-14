# Versão Beta 1.7
# Começando
- Editar as configurações no arquivo config.php
```php
	$config["LANGUAGE"]         = "eng";
	$config["DEBUG"]        = true;
	$config["USE_HTACCESS"] = true;
	$config["LOG"]          = false;
	$config["URL_BASE"]     = "http://myapp.com";
	$config["BASE_PATH"]    = '\var\html\apppath';

```
- Editar o banco de dados em database.php
`Pode haver mais de um banco de dados`

```php
$database['default'] = array(
	'driver'   => 'mysql',
	'host'     => 'localhost',
	'port'     => '3306',
	'schema'   => 'mydb',
	'username' => 'root',
	'password' => 'root'
);

$database['anotherDB'] = array(
	'driver'   => 'mysql',
	'host'     => 'localhost',
	'port'     => '3306',
	'schema'   => 'mydb2',
	'username' => 'root',
	'password' => 'root'
);

```

#Criando Rotas
- As rotas ficam no arquivo app/routes.php
- A criação de rotas é simples, começa chamanda a função estatica get da classe Route e passa dois parametros, $route e $callback
- $route é o caminho que ele vai ler 
- $callback é o que fazer com esse caminho 
- Para o home do seu site ( yourapp.com/ ) use /index como caminho
- Para o $callback temos duas opções, usar string ou uma função sem nome.
- Se for usado uma string vai ser procurado um controller com o mesmo nome
- Se for usado uma função sem nome sera executado tudo que estiver dentro desta função
```php 
Route::get( "/index", "IndexController" );
Route::get( "/index", function(){
	echo "Index Page";
});
```

- Se quiser usar uma função especifica do controller é só por o nome dela depois do nome do controller separado por um ponto "."
```php 
Route::get( "/anotherfunc", "IndexController.anotherFunction" );
```

- Para a passagem de parametros GET tem que especificar no caminho que sera passado parametros botando `<int>` para ints `<string>` para string e `<any>` se não fizer diferença qual for
	- O numero de parametros é ilimitado
```php 
Route::get( "/index/<int>/<string>/<any>", "IndexController" );

```
- Se estiver usando função sem nome, tem que espeficiar nos argumentos da função os parametros para usar
```php
Route::get( "/index/<int>/<string>/<any>", function($param1, $param2, $param3){
	echo $param1, $param2, $param3;
});

```
- Depois de passar parametros não da para usar caminho absoluto denovo
```php
Route::get( "/index/<int>/dontWork", "IndexController" );

```

# Controllers
- Os controllers devem ficar na pasta app/controller
- O nome do arquivo deve ser igual ao nome da classe
- Quando um controller é chamado sem a especificação de função ele executa a função index()
```php
//IndexController.php
class IndexController{
	public function index(){
		// do something
	}
}

```
- Caso seja passado parametros GET para uma função do controller, ele recebera ela como Array em uma unica variavel
```php
Route::get( "/testfunc/<int>/<string>/<any>", "IndexController.testfunc" );

public function testfunc($data){
	$param1 = $data[0];
	$param2 = $data[1];
	$param3 = $data[2];
}
```
- Caso queira espeficiar o nome da variavel ponha o nome de cada uma depois do nome da função nas rotas e seperados por um ponto "."
```php
Route::get( "/testfunc/<int>/<string>/<any>", "IndexController.testfunc.int.string.anything" );

public function testfunc($data){
	$param1 = $data['int'];
	$param2 = $data['string'];
	$param3 = $data['anything'];
}

```

# Views
- Os Views ficam na pasta app/views
- Os views são chamados pela função load_view($viewFile, $data = null);
- $viewFile é string e pode ser só o nome do arquivo, e caso o arquivo esteja dentro de uma subpasta, o mesmo deve ser especificado com o nome da subpasta e separado por uma barra "/"
- $data tem que sera uma array ou null, sendo a key o nome da string e value o valor da string;
```php
$data = array( 'data' => "Value of \$data", 'data2' => "Value of \$data2" );

load_view("indexview", $data);
load_view("subfolder/indexview", $data);

//file indexview.php or subfolder/indexview.php
echo $data;
echo $data2;

```

# Models
- Os Models ficam na pasta app/model
- O Model é chamado pela função load_model($modelFile, $initParam);
- load_model Tem dois parametros o primeiro é o nome do model. Sendo uma classe, o Model deve ter o mesmo nome no arquivo como na classe, o segundo é o parametro inicial da classe se tiver, pode ser deixado em branco, e deve ser string ou array, passando um unico parametro, e caso seja chamado o `__construct()` deve ser chemado também a função `parent::__construct();`, vale também para destruct;

```php
// Controller File
$model1 = load_model("Model1");
$model1->do_something();

// file Model.php
class Model1 extends Model_class{

	public function do_something(){
		echo "do_something";
	}

}
// Controller File
$model2 = load_model("Model2");
$model2->do_something();

// file Model2.php
class Model2 extends Model_class{

	public function __construct(){
		parent::__construct();
	}

	public function do_something(){
		echo "do_something";
	}

	public function __destruct(){
		parent::__destruct();
	}

}
// Controller File
$data = array("id" => $id, "name" => $name);
$model3 = load_model("Model3", $data);
$model3->do_something();

// file Model3.php
class Model3 extends Model_class{
	private $id;
	private $name;

	public function __construct($data){
		parent::__construct();
		$this->id   = $data['id'];
		$this->name = $data['name'];
	}


	public function do_something(){
		echo $this->id;
		echo $this->name;
	}

}
```

# Funções Disponiveis
## load_view
- Carrega uma view, o primeiro parametro é o nome da View, e o segundo é as variaveis, que devem ser passadas como array, pode ser null
```php
//load_view($viewname, $data = null);
$data = array("var1" => "val1");
load_view("folder/to/view", $data);
```

## load_model
- Carrega um model, o primeiro parametro é o nome do Model, e o segundo é o parametro para `__construct()`, deve ser array, pode ser null
```php
//load_model($model, $initParam = null);
$data  = array("id" => $id, "name" => $name);
$model = load_model("folder/to/model", $data);
```

## load_controller
- Carrega um controller, o primeiro parametro é o nome do Controller, o segundo é o parametro para `__construct()`, deve ser array, pode ser null
```php
//load_controller($controller, $data = array());
$data  = array("id" => $id, "name" => $name);
load_controller("folder/to/controller", $data);
```

## load_helper
- Carrega um helper, o primeior parametro é o nome do Helper `Ver os helpers para informações`
```php
//load_helper($file);
$db  = load_helper("database");
$ini = load_helper("inifile");
$up  = load_helper("upload");
```

## message_page
- Carrega uma pagina de mensagem que interrompe o código, o primeirio parametro é o view, logalizado dentro de messages dentro de view, e o segundo parametro é array de data para o view
```php
//message_page($view = "message", $data = array("class" => "error", "title" => "Message Page", "message" => "Without Message!"));
$data["error"]   = "error";
$data["title"]   = "Page not found";
$data["message"] = translate_message("viewnotfound", array("'{viewName}'" => ""));

message_page("message", $data);
```

## translate_message
- Traduz a variavel definidade no lang.php da lingua definida no APP, o segundo parametro é uma array para trocar alguma parte do texto se quiser
```php
//translate_message($which, $var = null);
translate_message("viewnotfound", array("{viewName}" => "viewfile"));
```

## base_url
- Retonar o link base do APP
```php
base_url();
// http://myapp.com
```

## redirect_to
- Redireciona o usuário para uma rota especifica dentro do APP
```php
//redirect_to($url);
redirect_to("/another/route");
// http://myapp.com/another/route
```

## redirect_link
- Se passar só o primeiro parametro volta o caminho para a rota, se passar o segundo retorna a tag html `<a>` com o link e o texto definido, os outros parametros passam a classe e o id para a tag `<a>`
```php
//redirect_link($to = "", $title = "", $class = "", $id = "");

redirect_link("/another/route");
// http://myapp.com/another/route

redirect_link("/another/route", "Button", "btn", "button_id_1");
// <a href="http://myapp.com/another/route" class="btn" id="button_id_1" title="Button">Button</a>
```

## load_css
- Carrega um arquivo css dentro de public
```php
//load_css($cssFile);
load_css("css/app.js");
```

## load_js
- Carrega um arquivo jss dentro de public
```php
//load_js($jsFile);
load_js("/js/app.js");
```

## create_log
- Se o log estiver ativado ele grava na pasta `log` qualquer mensagem, pode ser String ou Array
```php
//create_log($message);
$data = "Error to connect to Database";
create_log($data);

$data = array("Error to connect to Database", "Incorrect Pass");
create_log($data);
```

## get_client_ip
- Retorna o IP do cliente;
```php
get_client_ip();
// 192.168.0.1
```

## get_difference_between
- Retorna uma array com a diferença entre duas strings
```php
//get_difference_between($old, $new);
$string1 = "Hi, I am a string!";
$string2 = "Hi, I'm a string!";

$diff = get_difference_between($string1, $string2);

echo $diff['old']; // I am
echo $diff['new']; // I'm
```

#Helpers

## Database
## Inifile
## Security
## Text
## Upload
## XSS Clean

#Traduzindo o Sistema
- Para traduzir ou criar novas opções de mensagens basta editar o arquivo `lang.php` dentro da pasta lang
- A pasta lang é dividida em subpastas com o nome abreviado da linguá para usar
- `eng`
	- `lang.php`
- `pt_BR`
	- `lang.php`
- `your_lang`
	- `lang.php`

