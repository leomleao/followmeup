<?php 

class HomeController extends \HXPHP\System\Controller
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
					$this->auth->redirectCheck(false);

			}

				public function deslogarAction(){

					$this->auth->logout();

				}

			public function indexAction(){	

		//#BEGIN selection of sidebar, topbar and pic.
	 $usuarioID = $this->session->get('userID');
	 $usuarioUser = $this->session->get('userUser');
	 $skins = User::find_by_sql("SELECT roleDesc from roles LEFT JOIN users ON 
 	(followmeup.users.userroleid = followmeup.roles.roleID) where userID = ?", array($usuarioID));


 		$skinName= $skins[0];
 		
		$this->view->setVars(array('skin' => $skinName, 
								   'user' => $usuarioUser
								  ))
		//#END selection of sidebar, topbar and pic.
				   ->setAssets('css', array(
				   			   'public/css/custom.min.css',
				   			   'public/plugin/svg/css/common.css',
				   			   ))

				   ->setAssets('js', array(
				   			   	'public/plugin/svg/jquery.lazylinepainter-1.7.0.js',
				   			   	'public/plugin/svg/js/svgdata.js',
				   			   	'public/js/_build/homeScript.min.js',
				   			   	'public/js/_build/sidebarScript.min.js',
				   			   	'public/js/_build/topbarScript.min.js',
				   			   	'public/js/_build/demo/Demo.min.js',
				   			   	'public/js/_build/demo/DemoDashboard.min.js',
				   			   	'public/js/libs/spin.js/spin.min.js',
				   			   	'public/js/libs/autosize/jquery.autosize.min.js',
				   			   	'public/js/libs/moment/moment.min.js',
				   			   	'public/js/libs/flot/jquery.flot.min.js',
				   			   	'public/js/libs/flot/jquery.flot.time.min.js',
				   			   	'public/js/libs/flot/jquery.flot.resize.min.js',
				   			   	'public/js/libs/flot/jquery.flot.orderBars.js',
				   			   	'public/js/libs/flot/jquery.flot.pie.js',
				   			   	'public/js/libs/flot/curvedLines.js',
				   			   	'public/js/libs/jquery-knob/jquery.knob.min.js',
				   			   	'public/js/libs/sparkline/jquery.sparkline.min.js',
				   			   	'public/js/libs/nanoscroller/jquery.nanoscroller.min.js',
				   			   	'public/js/libs/d3/d3.min.js',
				   			   	'public/js/libs/d3/d3.v3.js',
				   			   	'public/js/libs/rickshaw/rickshaw.min.js'
				   			   	));

				}
}