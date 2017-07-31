<?php 

class User extends \HXPHP\System\Model
{

  static $validates_presence_of = array(
    array(
      'username',
      'message' => 'O nome é um campo obrigatório.'
    ),
    array(
      'useremail',
      'message' => 'O e-mail é um campo obrigatório.'
    ),
    array(
      'useruser',
      'message' => 'O nome de usuário é um campo obrigatório.'
    ),
    array(
      'userpassword',
      'message' => 'A senha é um campo obrigatório.'
    )
  );

  static $validates_uniqueness_of = array(
    array(
      'useruser',
      'message' => 'Já existe um usuário com este nome de usuário cadastrado.'
    )
  );

    public static function populate(array $user)
  {

  }


  	public static function cadastrar(array $user)
	{

    $callbackObj = new \stdClass;
    $callbackObj->user = null;
    $callbackObj->status = false;
    $callbackObj->code = null;
    $callbackObj->errors = array();


			$userPassword = \HXPHP\System\Tools::hashHX($user['userPassword']);
			$user = array_merge($user, $userPassword);
      
			($usuarioCadastrado = self::find_by_userName_and_userUser_and_userStatus($user['userName'],$user['userUser'],0)) ? $cadastrar = $usuarioCadastrado->update_attributes(array('userPassword' => $user["userPassword"],'userSalt' => $user["userSalt"], 'userStatus' => 1)) : $cadastrar = false;

      if ($cadastrar) {
      $callbackObj->user = $cadastrar;
      $callbackObj->status = true;
      return $callbackObj;
    } 
    else {
      $callbackObj->code = 'cadastro-falhou';
    }

    return $callbackObj;

 	}

 	public static function logar(array $post)
 	{		
    $callbackObj = new \stdClass;
    $callbackObj->user = null;
    $callbackObj->status = false;
    $callbackObj->code = null;
    $callbackObj->tentativas_restantes = null;

 			$user=self::find_by_userUser($post['userUser']);

  			if(!is_null($user)) {
  				$userPassword = \HXPHP\System\Tools::hashHX($post['userPassword'], $user->usersalt);

          if($user->userstatus === 1){
            if(loginAttempt::attempts($user->userid)) {
                    if ($userPassword['userPassword'] === $user->userpassword) {

            $callbackObj->user = $user;
            $callbackObj->status = true;

                           loginAttempt::clearAttempts($user->userid); 
                       }
          else {
            $callbackObj->code = 'dados-incorretos';
            loginAttempt::registerAttempts($user->userid);
        }
      }
      else {
        $callbackObj->code = 'usuario-bloqueado';

        $user->userstatus = 0;
        $user->save(false);
        }
      }
      else {
        $callbackObj->code = 'usuario-bloqueado';
      }
  	}
    else {
      $callbackObj->code = 'usuario-inexistente';
    }
    return $callbackObj;
	}
}