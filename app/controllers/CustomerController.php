<?php 
		class CustomerController extends \HXPHP\System\Controller
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

	public function newCustomerAction(){

		$customerInsert = Customer::newCustomer($this->request->post(), $this->session->get('userID'));

		if($customerInsert->status == true){
			$this->redirectTo('../customer');
		}else{
				$this->load('Modules\Messages', 'auth');
				$this->messages->setBlock('alerts');
				$error = $this->messages->getByCode($login->code);
				$this->load('Helpers\Alert', $error);
		}

	}

	public function populateContactsAction(){
		$this->view->setFile('noView');

 	$joinDiscountGroup = 'JOIN followmeup.discount_groups on customers.customerDiscountGroupID = discount_groups.discountGroupID';
	$data = Customer::find('all', array('select' => 'customerCode, customerName, customerContactName, customerEmail, customerTel, customerStreet, customerStreetNumber, customerState, discountGroupID', 'joins' => array($joinDiscountGroup), 'order' => 'customerCreationDate DESC'));
		$json = $this->arrayToJson($data,null,null,true);
		echo $json; //JSON para uso AJAX
	}

	public function indexAction(){	

		$salesJoin = 'JOIN followmeup.roles on users.userroleid = roles.roleid';
		$sales = User::find('all', array('select' => 'userid, roleDesc, username', 'joins'=> array($salesJoin), 'conditions'=>'roleDesc = "user"', 'order'=>'username ASC'));
	

		$discount = discountGroup::find('all', array('select' => 'discountGroupID, discountGroupName'));
		$states = FederationUnit::find('all', array('select' => 'fuID, fuName'));
 		$joinDiscountGroup = 'JOIN followmeup.discount_groups on customers.customerDiscountGroupID = discount_groups.discountGroupID';
		$data = Customer::find('all', array('select' => 'customerCode, customerCNPJ, customerName, customerContactName, customerSalesManID, customerEmail, customerZipCode, customerStreet, customerStreetNumber, customerState, customerNeighborhood, customerDiscountGroupID, customerCity, customerIBGE, discountGroupID', 'joins' => array($joinDiscountGroup), 'order' => 'customerCreationDate DESC'));

		$quantity = Customer::count();
		#If quotation status = 0/false it will exclude row of JSON object
		    //write to json file
		    // $fp = fopen('/../customer.json', 'w');
		    // fwrite($fp, $json);
		    // fclose($fp);
   
		//#BEGIN selection of sidebar, topbar and pic.
			 $usuarioID = $this->session->get('userID');
			 $usuarioUser = $this->session->get('userUser');
			 $skins = User::find_by_sql("SELECT roleDesc from roles LEFT JOIN users ON 
		 	(followmeup.users.userroleid = followmeup.roles.roleID) where userID = ?", array($usuarioID));

		 		$skinName= $skins[0];
		 		
				$this->view->setVars(array('skin' 		=> $skinName, 
										   'user' 		=> $usuarioUser,
										   'contactQtd' => $quantity,
										   'states' 	=> $states,
										   'discount'	=> $discount,
										   'data'		=> $data,
										   'sales'		=> $sales
										  ))

		//#END selection of sidebar, topbar and pic.
				   ->setAssets('css', array(
				   			   'public/css/custom.css',
				   			   'public/plugin/jplist/css/jplist.core.min.css',	
				   			   'public/plugin/jplist/css/jplist.pagination-bundle.min.css'
				   			   ))

				   ->setAssets('js', array(
				   			   	'public/js/_build/topbarScript.min.js',
				   			   	'public/js/_build/sidebarScript.min.js',
				   			   	'public/plugin/cpfcnpj/js/validate.js',
				   			   	'public/js/libs/inputmask/jquery.inputmask.bundle.min.js',
				   			   	'public/js/libs/hideseek/modernizr.custom.js',
				   			   	'public/js/libs/hideseek/rainbow-custom.min.js',
				   			  	'public/js/libs/hideseek/jquery.hideseek.js',
				   			   	'public/plugin/jplist/js/jplist.core.min.js',
				   			   	'public/plugin/jplist/js/jplist.textbox-filter.min.js',
				   			   	'public/plugin/jplist/js/jplist.sort-buttons.min.js',
				   			   	'public/plugin/jplist/js/jplist.pagination-bundle.min.js',
				   			   	'public/plugin/jplist/js/jplist.sort-bundle.min.js',
				   			   	'public/plugin/jplist/js/jplist.filter-toggle-bundle.min.js',
				   			   	'public/js/libs/hideseek/jquery.anchor.js',
				   			   	'public/js/_build/customerPagination.min.js',
				   			   	'public/js/libs/jquery-validation/dist/jquery.validate.js',
				   			   	'public/js/_build/customerScript.min.js',
							    'public/js/libs/jquery-validation/dist/localization/messages_pt_BR.js'
 								// '/public/js/libs/hideseek/initializer.js'
				   			   	));


				}
	}