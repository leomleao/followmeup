<?php 

class Quotation extends \HXPHP\System\Model
{		

		public function set_overdue($value) 
		{
	    	$this->assign_attribute('isoverdue',strtoupper($value));
	  	}	

		public static function saveQuotation(array $quotation, $userID)
		{	
		if (isset($quotation['quotationReceivedConf']) && $quotation['quotationReceivedConf'] != null){
			$receivedConfirmation = 1;
		} else {
			$receivedConfirmation = 0;
		}

		if (isset($quotation['quotationStatus']) && $quotation['quotationStatus'] != "Fechada"){
			$closingDate = NULL;
		} else {
			$closingDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
		}		

		$customerID = Customer::find('all', array('select' => 'customerID, customerCode', 'conditions' => array('customerCode = ?', $quotation['quotationCustomerID'])));

		$creationDate = DateTime::createFromFormat('d/m/Y', $quotation['quotationCreationDate']);
		
								self::create(array(
						'quotationNumber' => $quotation['quotationNumber'],
						'quotationCustomerID' => (string)$customerID[0]->customerid,
						'quotationValue' => str_replace(',','.',$quotation['quotationValue']),
						'quotationFinalValue' => str_replace(',','.',$quotation['quotationFinalValue']),
						'quotationState' => $quotation['quotationState'],
						'quotationCommuWay' => $quotation['quotationCommuWay'],
						'quotationReceivedConf' => $receivedConfirmation,
						'quotationDealerUserID' => $quotation['quotationDealerUserID'],
						'quotationCreationDate' => $creationDate,
						'quotationClosingDate' => $closingDate,
						'quotationUserID' => $userID,
						'quotationPriority' => $quotation['quotationPriority']						
											));

	}	
	public static function editQuotation(array $quotationData, $userID){
		if (isset($quotationData['quotationReceivedConf']) && $quotationData['quotationReceivedConf'] != NULL){
			$receivedConfirmation = 1;
		}
		else {
			$receivedConfirmation = 0;
		}
		$quotation = self::find_by_quotationID($quotationData['quotationID']);
		$customerID = Customer::find('all', array('select' => 'customerID, customerCode', 'conditions' => array('customerCode = ?', $quotationData['quotationCustomerID'])));

		$creationDate = DateTime::createFromFormat('d/m/Y', $quotationData['quotationCreationDate']);
		$currentQuotationCreationDate = $quotation->quotationcreationdate ? $quotation->quotationcreationdate->format('d/m/Y') : "" ;

		if (isset($quotation->quotationclosingdate) && $quotation->quotationclosingdate != NULL){
			$closingDate = $quotation->quotationclosingdate;
		} else {
			$closingDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
		}

		$quotationNumber 		= $quotationData['quotationNumber'] 		? $quotationData['quotationNumber'] 		: $quotation->quotationnumber ;
		$quotationCustomerID 	= (string)$customerID[0]->customerid 		? (string)$customerID[0]->customerid 		: $quotation->quotationcustomerid ;
		$quotationValue 		= $quotationData['quotationValue'] 			? $quotationData['quotationValue']			: $quotation->quotationvalue ;
		$quotationFinalValue	= $quotationData['quotationFinalValue'] 	? $quotationData['quotationFinalValue']		: $quotation->quotationfinalvalue ;
		$quotationState 		= $quotationData['quotationState'] 			? $quotationData['quotationState']			: $quotation->quotationstate ;
		$quotationCommuWay		= $quotationData['quotationCommuWay'] 		? $quotationData['quotationCommuWay'] 		: $quotation->quotationcommuway ;
		$quotationReceivedConf	= $receivedConfirmation;
		$quotationDealerUserID 	= $quotationData['quotationDealerUserID']	? $quotationData['quotationDealerUserID'] 	: $quotation->quotationdealeruserid ;
		$quotationCreationDate  = $quotationData['quotationCreationDate']	? $creationDate 							: $currentQuotationCreationDate;
		$quotationUserID 		= $userID 									? $userID 									: $quotation->quotationuserid ;
		$quotationPriority		= $quotationData['quotationPriority'] 		? $quotationData['quotationPriority'] 		: $quotation->quotationpriority ;

		// var_dump($quotationData['quotationCreationDate']);
		// var_dump($creationDate );
		// var_dump($currentQuotationCreationDate);
		// var_dump($quotationCreationDate);


		// exit;

		echo ($quotation->update_attributes(array(
						'quotationNumber' => $quotationNumber,
						'quotationCustomerID' => $quotationCustomerID,
						'quotationValue' => $quotationValue ,
						'quotationFinalValue' => $quotationFinalValue,
						'quotationState' => $quotationState,
						'quotationCommuWay' => $quotationCommuWay,
						'quotationReceivedConf' => $quotationReceivedConf,
						'quotationDealerUserID' => $quotationDealerUserID,
						'quotationCreationDate' => $quotationCreationDate,
						'quotationClosingDate' => $closingDate,
						'quotationUserID' => $quotationUserID,
						'quotationPriority' => $quotationPriority
					)));
	}	
	public static function deleteQuotation($quotation, $userID){
		$quotation = self::find_by_quotationID($quotation['quotationid']);
		echo ($quotation->update_attributes(array(						
						'quotationUserID' => $userID,
						'quotationStatus' => 0
					)));
	}	

}