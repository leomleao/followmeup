window.onload = init;

function init(){

 document.getElementById('entrar').onclick = entrarFunction;


	function entrarFunction(e){

  			var user = document.getElementById('userUser').value,
 				password = document.getElementById('userPassword').value,
 				userError = document.getElementById('userError'),
 				passwordError = document.getElementById('passwordError');

 				if (!user || !password) {
 							e.preventDefault();
 						  !user ? userError.innerHTML  = 'Insira um usuário valido' : userError.innerHTML  = '';
 							 		!password ?  passwordError.innerHTML = 'Insira uma senha valida' : passwordError.innerHTML = '';
 								
				}

  }

	function incorrectUser(){

			console.log('oi');
		
	 }


}