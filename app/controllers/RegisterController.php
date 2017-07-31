<?php 
		class RegisterController extends \HXPHP\System\Controller
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

					$this->auth->redirectCheck(true);
				}
				public function registerAction()
				{
					// $this->view->setFile('index');

				$this->request->setCustomFilters(array(
			'customeremail' => FILTER_VALIDATE_EMAIL));


// if(count(User::find_by_userName_and_userUser_and_userStatus($this->request->post('userName'),$this->request->post('userUser'),0))>0)
					// {
						$this->view->setFile('index');
 						$cadastrarUsuario = User::cadastrar($this->request->post());

 				if ($cadastrarUsuario->status === false) {
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Não foi possível efetuar seu cadastro. <br> Verifique os erros abaixo:',
					$cadastrarUsuario->errors
				));
			}
			else {
		$dadosUsuario = User::find_by_userUser($this->request->post('userUser'));

		$department = User::find_by_sql("SELECT departmentName from departments LEFT JOIN users ON 
			(followmeup.users.userDepartmentID = followmeup.departments.departmentID) where userID = ?", 
			array($dadosUsuario->userid)); $userDepartment = $department[0];

	$this->auth->login($dadosUsuario->userid, $dadosUsuario->useruser, $dadosUsuario->usersalt, $this->request->post('userPassword'), $dadosUsuario->userpassword, $dadosUsuario->username, $userDepartment->departmentname);
						
			}
		// }
	}

 						##$usuarioCadastrado = User::find_by_userName_and_userUser_and_userStatus($this->request->post('userName'),$this->request->post('userUser'),1);

				public function populateAction()
				{
					
				}

			}