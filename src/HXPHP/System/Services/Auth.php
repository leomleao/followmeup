<?php

namespace HXPHP\System\Services;

use HXPHP\System\Storage as Storage;
use HXPHP\System\Http as Http;
use HXPHP\System\Modules\Messages\Messages;


class Auth
{

	/**
	 * Injeção do Request
	 * @var object
	 */
	public $request;

	/**
	 * Injeção do Response
	 * @var object
	 */
	public $response;

	/**
	 * Injeção do controle de sessão
	 * @var object
	 */
	public $storage;

	/**
	 * Injeção do módulo de Mensagens
	 * @var object
	 */
	public $messages;

	private $url_redirect_after_login;
	private $url_redirect_after_logout;
	private $redirect;

	
	/**
	 * Método construtor
	 */
	public function __construct($url_redirect_after_login, $url_redirect_after_logout, $redirect = false)
	{
		//Instância dos objetos injetados
		$this->request = new Http\Request;
		$this->response = new Http\Response;
		$this->storage  = new Storage\Session;
		$this->messages = new Messages('auth');
		$this->messages->setBlock('alerts');

		//Configuração
		$this->url_redirect_after_login = $url_redirect_after_login;
		$this->url_redirect_after_logout = $url_redirect_after_logout;
		$this->redirect = $redirect;

		return $this;
	}

	/**
	 * Autentica o usuário
	 * @param  integet $userID  ID do usuário
	 * @param  string $userUser  Nome de usuário
	 */
	public function login($userID, $userUser, $userSalt, $userPassword, $senha, $userName, $userDepartment)
	{
		$userID = intval(preg_replace("/[^0-9]+/", "", $userID));
		$userUser = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $userUser);
		$login_string = hash('sha512', $userUser . $this->request->server('REMOTE_ADDR') . $this->request->server('HTTP_USER_AGENT'));

		$Password = \HXPHP\System\Tools::hashHX($userPassword, $userSalt);
		
		if ($Password['userPassword'] === $senha) {

		$this->storage->set('userID', $userID);
		$this->storage->set('userUser', $userUser);
		$this->storage->set('login_string', $login_string);
		$this->storage->set('userName', $userName);
		$this->storage->set('userDepartment', $userDepartment);

		if ($this->redirect === true)
			return $this->response->redirectTo($this->url_redirect_after_login);
		}
	}

	/**
	 * Método de logout de usuários
	 */
	public function logout()
	{
		$this->storage->clear('userID');
		$this->storage->clear('userUser');
		$this->storage->clear('login_string');

		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		session_destroy();

		$this->response->redirectTo($this->url_redirect_after_logout);
	}

	/**
	 * Valida a autenticação e redireciona mediante o estado do usuário
	 * @param  boolean $redirect Parâmetro que define se é uma página pública ou não
	 */
	public function redirectCheck($redirect = false)
	{
		if ($redirect && $this->login_check()) {
			$this->response->redirectTo($this->url_redirect_after_login);
		}
		elseif (!$this->login_check()) {
			if (!$redirect)
				$this->logout();
		}
	}

	/**
	 * Verifica se o usuário está logado
	 * @return boolean Status da autenticação
	 */
	public function login_check()
	{
		if ( $this->storage->exists('userID') &&
			 $this->storage->exists('userUser') &&
			 $this->storage->exists('login_string') ) {

			$login_string = hash('sha512', $this->storage->get('userUser') . $this->request->server('REMOTE_ADDR') . $this->request->server('HTTP_USER_AGENT'));
			
	     	return ($login_string == $this->storage->get('login_string') ? true : false);
		}
	}	

	/**
	 * Retorna a ID do usuário autenticado
	 * @return integer ID do usuário
	 */
	public function getUserId()
	{
		return $this->storage->get('userID');
	}

}