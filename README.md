# Versão Beta 1.7
# Começando
- Editar as configurações no arquivo config.php
```php
	$config["lang"]         = "eng";
	$config["DEBUG"]        = true;
	$config["USE_HTACCESS"] = true;
	$config["LOG"]          = false;
	$config["URL_BASE"]     = "http://myapp.com";
	$config["BASE_PATH"]    = '\var\html\apppath';

```
- Editar o banco de dados em database.php
	- Pode haver mais de um banco de dados

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

#Controllers
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
	$param3 = $data[3];
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

#Views
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

#Models
