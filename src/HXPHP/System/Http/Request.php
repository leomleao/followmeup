<?php

namespace HXPHP\System\Http;

use HXPHP\System\Tools;

class Request
{
	
	/**
	 * Atributos
	 * @var null
	 */
	public  $controller;
	public  $action;
	public  $params = array();

	/**
	 * Filtros customizados de tratamento
	 * @var array
	 */
	public $custom_filters = array();

	/**
	 * Método construtor
	 */
	public function __construct($baseURI = '')
	{
		$this->initialize($baseURI);
		return $this;
	}

	/**
	 * Define os parâmetros do mecanismo MVC
	 * @return object Retorna o objeto com as propriedades definidas
	 */
	public function initialize($baseURI)
	{
		if ( ! empty($baseURI)) {
			$explode = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));

			if (isset($explode[0]) && $explode[0] == str_replace('/', '', $baseURI)) {
				unset($explode[0]);
				$explode = array_values($explode);
			}

			if (count($explode) == 0) {
				$this->controller = 'IndexController';
				$this->action = 'indexAction';

				return $this;
			}

			if (count($explode) == 1) {
				$this->controller = Tools::filteredName($explode[0]).'Controller';
				$this->action = 'indexAction';

				return $this;
			}

			$this->controller = Tools::filteredName($explode[0]).'Controller';
			$this->action = lcfirst(Tools::filteredName($explode[1])).'Action';
			
			unset($explode[0], $explode[1]);

			$this->params = array_values($explode);
		}
	}

	/**
	 * Define filtros/flags customizados (http://php.net/manual/en/filter.filters.sanitize.php)
	 * @param array $custom_filters Array com nome do campo e seu respectivo filtro
	 */
	public function setCustomFilters(array $custom_filters = array())
	{
		return $this->custom_filters = $custom_filters;
	}

	/**
	 * Realiza o tratamento das super globais
	 * @param  array $request 		  Array nativo com campos e valores passados
	 * @param  const $data    		  Constante que será tratada
	 * @param  array $custom_filters  Filtros customizados para determinados campos
	 * @return array                  Constate tratada
	 */
	public function filter(array $request, $data, array $custom_filters = array())
	{
		$filters = array();

		foreach ($request as $key => $value) {
			if ( ! array_key_exists($key, $custom_filters)) {
				$filters[$key] = constant('FILTER_SANITIZE_STRING');
			}
		}

		if (is_array($custom_filters) && is_array($custom_filters))
			$filters = array_merge($filters,$custom_filters);

		return filter_input_array($data, $filters);
	}

	/**
	 * Obtém os dados enviados através do método GET
	 * @param  string $name Nome do parâmetro
	 * @return null         Retorna o array GET geral ou em um índice específico
	 */
	public function get($name = null)
	{
		$get = $this->filter($_GET, INPUT_GET, $this->custom_filters);

		if ( ! $name) {
			return $get;
		}

		if ( ! isset($get[$name])) {
			return null;
		}

		return $get[$name];
	}

	/**
	 * Obtém os dados enviados através do método POST
	 * @param  string $name Nome do parâmetro
	 * @return null         Retorna o array POST geral ou em um índice específico
	 */
	public function post($name = null)
	{
		$post = $this->filter($_POST, INPUT_POST, $this->custom_filters);

		if ( ! $name) {
			return $post;
		}

		if ( ! isset($post[$name])) {
			return null;
		}

		return $post[$name];
	}
        
    /**
	 * Obtém os dados da superglobal $_SERVER
	 * @param  string $name Nome do parâmetro
	 * @return null         Retorna o array $_SERVER geral ou em um índice específico
	 */     
    public function server($name = null)
    {
        $server = $this->filter($_SERVER, INPUT_SERVER, $this->custom_filters);
        
        if(!$name)
            return $server;
        
        if(!isset($server[$name]))
            return NULL;
        
        return $server[$name];
    }

	/**
	 * Retorna o método da requisição
	 * @param  string $value Nome do método
	 * @return null          Retorna um booleano ou o método em si
	 */
	public function getMethod($value = null)
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if ($value) {
			return $method == $value;
		}

		return $method;
	}

	/**
	 * Verifica se o método da requisição é POST
	 * @return boolean Status da verificação
	 */
	public function isPost()
	{
		return $this->getMethod('POST');
	}

	/**
	 * Verifica se o método da requisição é GET
	 * @return boolean Status da verificação
	 */
	public function isGet()
	{
		return $this->getMethod('GET');
	}

	/**
	 * Verifica se o método da requisição é PUT
	 * @return boolean Status da verificação
	 */
	public function isPut()
	{
		return $this->getMethod('PUT');
	}

	/**
	 * Verifica se o método da requisição é HEAD
	 * @return boolean Status da verificação
	 */
	public function isHead()
	{
		return $this->getMethod('HEAD');
	}
}