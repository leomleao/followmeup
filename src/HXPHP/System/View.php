<?php

namespace HXPHP\System;

class View
{	public function minify($input) {
    if(trim($input) === "") return $input;
    // Remove extra white-space(s) between HTML attribute(s)
    $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function($matches) {
        return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
    }, str_replace("\r", "", $input));
    // Minify inline CSS declaration(s)
    if(strpos($input, ' style=') !== false) {
        $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function($matches) {
            return '<' . $matches[1] . ' style=' . $matches[2] . minify_css($matches[3]) . $matches[2];
        }, $input);
    }
    return preg_replace(
        array(
            // t = text
            // o = tag open
            // c = tag close
            // Keep important white-space(s) after self-closing HTML tag(s)
            '#<(img|input)(>| .*?>)#s',
            // Remove a line break and two or more white-space(s) between tag(s)
            '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
            '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s', // t+c || o+t
            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s', // o+o || c+c
            '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s', // c+t || t+o || o+t -- separated by long white-space(s)
            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s', // empty tag
            '#<(img|input)(>| .*?>)<\/\1\x1A>#s', // reset previous fix
            '#(&nbsp;)&nbsp;(?![<\s])#', // clean up ...
            // Force line-break with `&#10;` or `&#xa;`
            '#&\#(?:10|xa);#',
            // Force white-space with `&#32;` or `&#x20;`
            '#&\#(?:32|x20);#',
            // Remove HTML comment(s) except IE comment(s)
            '#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
        ),
        array(
            "<$1$2</$1\x1A>",
            '$1$2$3',
            '$1$2$3',
            '$1$2$3$4$5',
            '$1$2$3$4$5$6$7',
            '$1$2$3',
            '<$1$2',
            '$1 ',
            "\n",
            ' ',
            ""
        ),
    $input);
	}

	/**
	 * Título da página
	 * @var string
	 */
	public $title = null;

	/**
	 * Injeção das Configurações
	 * @var object
	 */
	private $configs;
	
	/**
	 * Injeção do Http Request
	 * @var object
	 */
	private $request;

	/**
	 * Parâmetros de configuração da VIEW
	 * @var string
	 */
	protected $path = null;
	protected $template = null;
	protected $header = null;
	protected $file = null;
	protected $footer = null;
	protected $vars = array();
	protected $assets = array(
		'css' => array(),
		'js' => array()
	);

	public function setConfigs(Configs\Config $configs, $controller, $action)
	{
		/**
		 * Injeção das Configurações
		 * @var object
		 */
		$this->configs = $configs;
		$this->request  = new Http\Request($configs->baseURI);

		/**
		 * Tratamento das variáveis
		 */
		$controller = strtolower(str_replace('Controller', '', $controller));
		$action = ($controller == $configs->controllers->notFound
					 ? 'indexAction' : $action);
		$action = str_replace('Action', '', $action);

		/**
		 * Verifica se os valores padrão foram alterados no construtor do Controller.
		 */
		$view_settings = new \stdClass;

		$default_values = array(
			'path' => $controller,
			'template' => true,
			'header' => 'header',
			'file' => $action,
			'footer' => 'footer',
			'title' => $this->configs->title
		);

		foreach ($default_values as $setting => $value) {
			if(is_null($this->$setting)) {
				$view_settings->$setting = $value;
				continue;
			}

			$view_settings->$setting = $this->$setting;
		}

		$this->setPath($view_settings->path)
				->setTemplate($view_settings->template)
				->setHeader($view_settings->header)
				->setFile($view_settings->file)
				->setFooter($view_settings->footer)
				->setTitle($view_settings->title);	
	}

	/**
	 * Define o título da página
	 * @param string  $title  Título da página
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * Define a pasta da view
	 * @param string  $path  Caminho da View
	 */
	public function setPath($path)
	{
		$this->path = $path;
		return $this;
	}

	/**
	 * Define se o arquivo é miolo (Inclusão de Cabeçalho e Rodapé) ou único
	 * @param bool  $template  Template ON/OFF
	 */
	public function setTemplate($template)
	{
		$this->template = $template;
		return $this;
	}


	/**
	 * Define o cabeçalho da view
	 * @param string  $header  Cabeçalho da View
	 */
	public function setHeader($header)
	{
		$this->header = $header;
		return $this;
	}

	/**
	 * Define o arquivo da view
	 * @param string  $file  Arquivo da View
	 */
	public function setFile($file)
	{
		$this->file = $file;
		return $this;
	}

	/**
	 * Define o rodapé da view
	 * @param string  $footer  Rodapé da View
	 */
	public function setFooter($footer)
	{
		$this->footer = $footer;
		return $this;
	}

	/**
	 * Define um conjunto de variáveis para a VIEW
	 * @param array  $vars  Array com variáveis
	 */
	public function setVars(array $vars)
	{
		$this->vars = array_merge($this->vars, $vars);
		return $this;
	}

	/**
	 * Define uma variável única para a VIEW
	 * @param string  $name  Nome do índice
	 * @param string  $value  Valor
	 */
	public function setVar($name, $value)
	{
		$this->vars[$name] = $value;
		return $this;
	}

	/**
	 * Define os arquivos customizáveis que serão utilizados
	 * @param string  $type  Tipo do arquivo
	 * @param string|array  $assets  Arquivo Único | Array com os arquivos
	 */
	public function setAssets($type, $assets)
	{
		if (is_array($assets)) {
			$this->assets[$type] = array_merge($this->assets[$type], $assets);
		} 
		else {
			array_push($this->assets[$type], $assets);
		}
		 
		return $this;
	}

	/**
	 * Inclui os arquivos customizados
	 * @param  string $type          Tipo de arquivo incluso, como: css ou js
	 * @param  array  $custom_assets Links dos arquivos que serão incluídos
	 * @return string                HTML formatado de acordo com o tipo de arquivo
	 */

	private function assets($type, array $custom_assets = array())
	{
		$baseURI  = $this->configs->baseURI;
		$add_assets = '';

		switch ($type) {
			case 'css':
				$tag = '<link type="text/css" rel="stylesheet" href="%s">'."\n\r";
				break;

			case 'js':
				$tag = '<script type="text/javascript" src="%s"></script>'."\n\r";
				break;
		}
		
		if (count($custom_assets) > 0)
			foreach ($custom_assets as $file)
				$add_assets .= sprintf($tag,$baseURI.$file);

		return $add_assets;
	}

	/**
	 * Renderiza a VIEW
	 * @param  string  $view  Nome do arquivo, sem extensão, a ser utilizado como VIEW
	 */
	public function flush()
	{

		$default_data = array(
			'title' => $this->title
		);

		$data = array_merge($default_data, $this->vars);
		
		//Extract que transforma os parâmetros em variáveis disponíveis para a VIEW
		extract($data, EXTR_PREFIX_ALL, 'view');

		//Variáveis
		$baseURI  = $this->configs->baseURI;
		$viewsDir = $this->configs->views->directory;
		$viewsExt = $this->configs->views->extension;

		//Atribuição das constantes
		define('BASE',   $baseURI);
		define('ASSETS', $baseURI . 'public/assets');
		define('IMG',    $baseURI . 'public/img/');
		define('CSS',    $baseURI . 'public/css');
		define('JS',     $baseURI . 'public/js');

				//Inclusão de ASSETS

		$add_css = $this->minify($this->assets('css', $this->assets['css']));
		$add_js  = $this->minify($this->assets('js', $this->assets['js']));

		//Verifica a existência da VIEW
		if ($this->file != 'noView'){
		$view = $viewsDir . $this->path . DS . $this->file . $viewsExt;
		if ( $view != 'zueira' && !file_exists($view) )
			throw new \Exception("Erro fatal: A view <'$view'> não foi encontrada. Por favor, crie a view e tente novamente.", 1);

		//Mecanismo de template
		if ($this->template === false) {
			//Inclusão da view
			require_once($view);
			exit();
		}

		//Verifica a existência do Header e Footer customizado
		$header = $viewsDir . $this->header . $viewsExt;
		$footer = $viewsDir . $this->footer . $viewsExt;

		if ( ! file_exists($header) || ! file_exists($footer))
			throw new \Exception("Erro fatal: O header <$header> ou o footer <$footer> não existe. Por favor, verifique e tente novamente.");

		//Inclusão dos arquivos
		require_once($header);
		require_once($view);
		require_once($footer);
	}

		exit();
	}	
}

