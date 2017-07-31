<?php

namespace HXPHP\System;

class Tools
{
	/**
	 * Exibe os dados
	 * @param  mist $data Variável que será "debugada"
	 */
	static function dd($data, $dump = false)
	{
		echo '<pre>';

		if ($dump)
			var_dump($data);
		else
			print_r($data);
		
		echo '</pre>';
	}

	/**
	 * Criptografa a senha do usuário no padrão HXPHP
	 * @param  string $userPassword Senha do usuário
	 * @param  string $userSalt     Código alfanumérico
	 * @return array            Array com o userSalt e a SENHA
	 */
	static function hashHX($userPassword, $userSalt = null)
	{
		
		if (is_null($userSalt))
			$userSalt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

		$userPassword = hash('sha512', $userPassword.$userSalt);
		
		return array(
			'userSalt' => $userSalt,
			'userPassword' => $userPassword
		);
	}

	/**
	 * Processo de tratamento para o mecanismo MVC
	 * @param string $input     String que será convertida
	 * @return string           String convertida
	 */
	static function filteredName($input)
	{
		$input = explode('?', $input);
		$input = $input[0];
		
		$find    = array(
			'-',
			'_'
		);
		$replace = array(
			' ',
			' '
		);
		return str_replace(' ', '', ucwords(str_replace($find, $replace, $input)));
	}
}