<?php 
		class LoginController extends \HXPHP\System\Controller
			{

		public function __construct($configs)
				{
					parent::__construct($configs);

					$this->load(
						'Services\Auth',
						$configs->auth->after_login,
						$configs->auth->after_logout,
						true ##se for bem sucedido, o usuario é redirecionado para a pagina home
						);
					$this->load('Storage\Session'); 
					$this->auth->redirectCheck(true); ##se true, a pagina é publica e o usuario consegue acesso sem estar logado, se falso a pagina é privada
				}



		public function indexAction(){

			$this->view->setAssets('js', array(
							'/public/js/_build/loginScript.min.js'

				))
					   ->setAssets('css', array(
							'/public/css/custom.min.css'
				));

		}



		public function logarAction()
				{

				$this->view->setAssets('js', array(
							'/public/js/_build/loginScript.min.js'

				));

		$this->auth->redirectCheck(true);
		$this->view->setFile('index');

					$logar = $this->request->post();
					if(!empty($logar)){
						$login = User::logar($logar);

		if ($login->status === true) {

		$dadosUsuario = User::find_by_userUser($this->request->post('userUser'));

		$department = User::find_by_sql("SELECT departmentName from departments LEFT JOIN users ON 
			(followmeup.users.userDepartmentID = followmeup.departments.departmentID) where userID = ?", 
			array($dadosUsuario->userid)); $userDepartment = $department[0];

	$this->auth->login($dadosUsuario->userid, $dadosUsuario->useruser, $dadosUsuario->usersalt, $this->request->post('userPassword'), $dadosUsuario->userpassword, $dadosUsuario->username, $userDepartment->departmentname);
						}
			else {
				$this->load('Modules\Messages', 'auth');
				$this->messages->setBlock('alerts');
				$error = $this->messages->getByCode($login->code, array(
					'message' => $login->tentativas_restantes
				));

				$this->load('Helpers\Alert', $error);
			}
		}
	}
}