<?php 

namespace HXPHP\System;
use HXPHP\System\Http as Http;

class Controller
{
	/**
	 * Injeção das Configurações
	 * @var object
	 */
	public $configs = null;

	/**
	 * Injeção do Http Request
	 * @var object
	 */
	private $request;

	/**
	 * Injeção do Http Response
	 * @var object
	 */
	private $response;

	/**
	 * Injeção da View
	 * @var object
	 */
	public $view;

	public function __construct($configs = null)
	{
		//Injeção da VIEW
		$this->view = new View;
		$this->response = new Http\Response;
		
		if (!is_null($configs) && $configs instanceof Configs\Config)
			$this->setConfigs($configs);
	}

	/**
	 * Injeta as configurações
	 * @param  Config $configs Objeto com as configurações da aplicação
	 * @return object
	 */
	public function setConfigs(Configs\Config $configs)
	{
		//Injeção das dependências
		$this->configs  = $configs;
		$this->request  = new Http\Request($configs->baseURI);

		return $this;
	}

	/**
	 * Default Action
	 */
	public function indexAction()
    {
    	
    }

	/**
	 * Carrega serviços, módulos e helpers
	 * @param  string $object Nome da classe
	 * @param  string|array  $params Parâmetros do método construtor
	 * @return object         Objeto injetado
	 */
	public function load()
	{
		$total_args = func_num_args();

		if ($total_args == 0)
			throw new \Exception("Nenhum objeto foi definido para ser carregado.", 1);
			

		/**
		 * Retorna todos os argumentos e define o primeiro como
		 * o objeto que será injetado
		 * @var array
		 */
		$args = func_get_args();
		$object = $args[0];

		/**
		 * Define os demais argumentos passados como
		 * parâmetros para o construtor do objeto injetado
		 */
		unset($args[0]);
		$params = empty($args) ? array() : array_values($args);

		/**
		 * Tratamento que adiciona a pasta do módulo
		 */
		$explode = explode('\\', $object);
		$object = ($explode[0] === 'Modules' ? $object . '\\' . end($explode) : $object);
		$object = 'HXPHP\System\\' . $object;

		if (class_exists($object)) {
			$name = end($explode);
			$name = strtolower(Tools::filteredName($name));

			if ( ! empty($params)) {
				$ref = new \ReflectionClass($object);
  				$this->view->$name = $ref->newInstanceArgs($params);
			}
			else{
				$this->view->$name = new $object();
			}

			return $this->view->$name;
		}
	}

	/**
	 * Método mágico para atalho de objetos injetados na VIEW
	 * @param  string $param Atributo
	 * @return mixed         Conteúdo do atributo ou Exception
	 */
	public function __get($param)
	{
		if (isset($this->view->$param)) {
			return $this->view->$param;
		}
		elseif (isset($this->$param)) {
			return $this->$param;
		}
		else {
			throw new \Exception("Parametro <$param> nao encontrado.", 1);
		}

	}
	
	/**
	 * Redirecionamento
	 * @param  string $url Link de redirecionamento
	 */
	public function redirectTo($url)
	{
		return $this->response->redirectTo($url);
	}
	
	/**
	 * Conversion of a Array of data to a JSON
	 * @param  Array of data to be converted
	 * @param  Optional - additionall options
	 * @param  Optional - when set it will exclude from the JSON row the object which has the specified property set as null || false || 0 
	 * @param  Optional - Indicates if the JSON should be an Array of Array or an Array of Objects
	 */

	public function arrayToJson($data,$exclude = null,$options = null,$isArray = null) 
	{
		
		if($isArray) {$out = '[';} else {$out = '{"data": [';}
			foreach($data as $row) { 
				if ($exclude != null) if ($row->{$exclude} == 0 || $row->{$exclude} == false || $row->{$exclude} == null) continue;
					{
						if ($options != null)
							$out .= $row->to_json($options);
						else 
							$out .= $row->to_json();
							$out .= ",";
					}	
				}
			$out = rtrim($out, ',');
			if($isArray) {$out .=']';} else {$out .= "]}";}
		return $out;
	}
}