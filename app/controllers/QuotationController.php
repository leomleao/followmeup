<?php 

class QuotationController extends \HXPHP\System\Controller
	{	

		
		public function __construct($configs)
				{
					parent::__construct($configs);

					$this->load(
						'Services\Auth',
						$configs->auth->after_login,
						$configs->auth->after_logout,	
						true
						);
					$this->load('Storage\Session'); 
					$this->auth->redirectCheck(false);
					function cmp($a, $b)
						{
						    return strcmp($a->username, $b->username);
						}

					function getAncestry($id)
						{
							$join = 'LEFT JOIN users ON users.userID = user_reports.userReportID';
							$reports = UserReport::find('all', array('select' => 'userReportID, userName','joins' => $join, 'conditions' => array('userReportTo = ?', $id)));								
			                return $reports;
			            }	                

					$reports = getAncestry($this->session->get('userID'));		
					usort($reports, "cmp");
					$CurrentUser = User::find('all', array('select' => 'userID as UserReportID, userName', 'conditions' => array('userID = ?', $this->session->get('userID'))));
					$reports = array_merge($CurrentUser, $reports);
					$reports = array_map("unserialize", array_unique(array_map("serialize", $reports)));					
					$this->ancestry = $reports;	
				}


						
				

	public function indexAction()
	{		
		
//#BEGIN selection of sidebar, topbar and pic.
	 $usuarioID = $this->session->get('userID');
	 $usuarioUser = $this->session->get('userUser');
	 $skins = User::find_by_sql("SELECT roleDesc from roles LEFT JOIN users ON 
 	(followmeup.users.userroleid = followmeup.roles.roleID) where userID = ?", array($usuarioID));

		$skinName = $skins[0];
		//#END selection of sidebar, topbar and pic.


		$count = count(Quotation::find('all'));
		$this->view->setFile('index')
					->setAssets('css', array(
						            	'public/css/libs/bootstrap-datepicker/datepicker3.css',
								   		'public/css/libs/DataTables/jquery.dataTables.css',
								   		'public/css/libs/DataTables/extensions/dataTables.colVis.css',
								   		'public/css/libs/DataTables/extensions/dataTables.tableTools.css',
								   		// 'public/css/libs/DataTables/extensions/Buttons/buttons.dataTables.min.css',								   		
								   		'public/css/libs/easy-autocomplete/easy-autocomplete.css',
								   		'public/css/libs/toastr/toastr.css',
								   		'public/css/custom.min.css'
								   	))

					->setAssets('js', array(
								   		'public/js/libs/DataTables/jquery.dataTables.min.js',
								   		'public/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js',
								   		'public/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js',
								   		// 'public/js/libs/DataTables/extensions/Buttons/dataTables.buttons.min.js',
								   		'public/js/libs/bootstrap-datepicker/bootstrap-datepicker.js',
								   		'public/js/libs/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.js',
								   		'public/js/libs/jeditable/jquery.jeditable.js',
								   		'public/js/libs/easy-autocomplete/jquery.easy-autocomplete.js',
								   		'public/js/libs/inputmask/jquery.inputmask.bundle.min.js',
								   		'public/js/libs/jquery-validation/dist/jquery.validate.js',
								   		'public/js/libs/jquery-validation/dist/localization/messages_pt_BR.js',
								   		'public/js/libs/moment/moment.min.js',
								   		'public/js/libs/toastr/toastr.js',								   		
								   		'public/js/_build/quotationScript.min.js',
								   		'public/js/_build/topbarScript.min.js',
								   		'public/js/_build/sidebarScript.min.js'))				
				
		            ->setVars(array(
				                'count' => $count, 
				                'skin' => $skinName, 
				                'user' => $usuarioUser,
				                'reportTo' =>$this->ancestry
								 ));
					
			
	}
public function version (){
	phpinfo();
}

public function dataRequestAction(){
	$this->view->setFile('noView');
	if ($this->request->post() && isset($this->request->post()['dataType']) && ($this->request->post()['dataType'] == 'customerTerminalNumber')){
		$data = Customer::find('all', array('select' => 'customerCode', 'order' => 'customerCode asc'));		
		$json = $this->arrayToJson($data,null,null,true);        
        echo $json;
	} else if ($this->request->post() && $this->request->post()['quotationCustomerID']){
			$data = Customer::find('all', array('select' => 'customerCode', 'order' => 'customerCode asc'));
			$customerID = $this->request->post()['quotationCustomerID'];
			$out='"Esse cliente não existe!"';
	        foreach($data as $row) { 
					if ($row->customercode == $customerID){
						$out = '"true"';
						break;
					}
			}
	        echo $out;
		} 

	else {	
		$conditions[0] = 'quotationUserID = ?';
 		$conditions[1] = $this->session->get('userID');

		foreach($this->ancestry as $row)
              {
              	$conditions[0] .= ' OR quotationDealerUserID = ?';
              	array_push($conditions, $row->userreportid);                
              }


		$join = 'LEFT JOIN followmeup.customers ON (quotations.quotationCustomerID = followmeup.customers.customerID)		LEFT JOIN followmeup.follow_ups ON (quotations.quotationID = followmeup.follow_ups.followUpQuotationID) LEFT JOIN followmeup.users as DealerName ON (followmeup.quotations.quotationDealerUserID = DealerName.userID)		LEFT JOIN followmeup.users as user1 ON (followmeup.follow_ups.followUpUserID1 = user1.userID)LEFT JOIN followmeup.users as user2 ON (followmeup.follow_ups.followUpUserID2 = user2.userID) LEFT JOIN followmeup.users as user3 ON (followmeup.follow_ups.followUpUserID3 = user3.userID)';
		$data = Quotation::find('all', array('select' => '
			quotationID, 
			quotationNumber, 
			quotationValue, 
			quotationFinalValue, 
			quotationState, 
			quotationCreationDate,
			quotationInsertionDate,
			quotationPriority,
			quotationUserID, 
			quotationDealerUserID,
			DealerName.userName as dealerName,
				customerCode, 
				customerName, 
				customerStatus, 
				customerContactName, 
			quotationCommuWay, 
			quotationReceivedConf, 
			quotationStatus, 
				followUpID, 
				followUpDesc1, 
				followUpInsertionDate1, 
				followUpUserID1, 
					user1.userName as userName1, 
				followUpDesc2, 
				followUpInsertionDate2, 
				followUpUserID2, 
					user2.userName as userName2, 
				followUpDesc3, 
				followUpInsertionDate3, 
				followUpUserID3,
					user3.userName as userName3',
		'joins' => $join, 'order' => 'quotationID desc','conditions' => $conditions));

		$today = strtotime(date("d/m/Y H:i:s"));

		foreach($data as $row) { 
			if ($row->quotationstate != 'Aberta') continue;
			if ($row->quotationstatus != true) continue;
			if ($row->quotationinsertiondate) { $followup = array(($today - strtotime($row->quotationinsertiondate)));
				if ($row->followupinsertiondate1) { $followup = array_merge($followup,array($today - strtotime($row->followupinsertiondate1)));}
				if ($row->followupinsertiondate2) { $followup = array_merge($followup,array($today - strtotime($row->followupinsertiondate2)));}
				if ($row->followupinsertiondate3) { $followup = array_merge($followup,array($today - strtotime($row->followupinsertiondate3)));}
			}

			if (isset($followup) && (min($followup) > 432000)){
					$row->set_overdue(true);
				} else {
					$row->set_overdue('0');
				}
			if (isset($followup)) unset($followup);	
		}

		#If quotation status = 0/false it will exclude row of JSON object
		$property = 'quotationstatus';
        $json = $this->arrayToJson($data,$property);    
        echo $json;
    }
}

public function dataRequestTestAction(){
	$this->view->setFile('noView');
	if ($this->request->post() && isset($this->request->post()['dataType']) && ($this->request->post()['dataType'] == 'customerTerminalNumber')){
		$data = Customer::find('all', array('select' => 'customerCode', 'order' => 'customerCode asc'));		
		$json = $this->arrayToJson($data,null,null,true);        
        echo $json;
	} else if ($this->request->post() && $this->request->post()['quotationCustomerID']){
			$data = Customer::find('all', array('select' => 'customerCode', 'order' => 'customerCode asc'));
			$customerID = $this->request->post()['quotationCustomerID'];
			$out='"Esse cliente não existe!"';
	        foreach($data as $row) { 
					if ($row->customercode == $customerID){
						$out = '"true"';
						break;
					}
			}
	        echo $out;
		} 

	else {	
		// $conditions[0] = 'quotationUserID = ?';
 	// 	$conditions[1] = $this->session->get('userID');

		// foreach($this->ancestry as $row)
  //             {
  //             	$conditions[0] .= ' OR quotationDealerUserID = ?';
  //             	array_push($conditions, $row->userreportid);                
  //             }
// $servername = "localhost";
// $username = "root";
// $password = "cp1205rm28f-";
// $dbname = "followmeup";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 

// $sql = "SELECT quotationCreationDate, quotationStatus, quotationInsertionDate FROM quotations";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "quotationCreationDate: " . $row["quotationCreationDate"].
//              " - quotationStatus: " . $row["quotationStatus"].
//              " - quotationInsertionDate: " . $row["quotationInsertionDate"]. "<br>";
//     }
// } else {
//     echo "0 results";
// }
// $conn->close();




		$conditions[0] = 'quotationID = ?';
 		$conditions[1] = '4262';


		$data = Quotation::find('all', array('select' => '			
			quotationCreationDate,
			quotationStatus',

		 'order' => 'quotationID desc','conditions' => $conditions));


		#If quotation status = 0/false it will exclude row of JSON object
		$property = 'quotationstatus';
        $json = $this->arrayToJson($data,$property);    
        echo $json;
    }
}


	public function salvarAction(){		
			$salvar = Quotation::saveQuotation($this->request->post(),$this->session->get('userID'));
		$this->view->setFile('noView');
	}
	public function editarAction(){
		$editar = Quotation::editQuotation($this->request->post(),$this->session->get('userID'));
		$this->view->setFile('noView');

	}
	public function deleteAction(){
		$deletar = Quotation::deleteQuotation($this->request->post(),$this->session->get('userID'));
		$this->view->setFile('noView');
	}
	public function saveFollowUpAction(){
		$salvar = FollowUp::saveFollowUp($this->request->post(),$this->session->get('userID'));
		// $this->view->setFile('noView');
		$this->redirectTo('../quotation');
	}
	public function editFollowUpAction(){
		$editar = FollowUp::editFollowUp($this->request->post(),$this->session->get('userID'));
		$this->view->setFile('noView');
	}


}	