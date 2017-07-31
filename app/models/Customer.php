<?php 

class Customer extends \HXPHP\System\Model {

static $validates_uniqueness_of = array(
    array(
      'customercode',
      'message' => 'Já existe um usuário com este nome de usuário cadastrado.'
    )
  );

			public static function newCustomer(array $customer, $user){

	$callbackObj = new \stdClass;
    $callbackObj->user = null;
    $callbackObj->status = false;
    $callbackObj->code = null;
    $callbackObj->errors = array();
			
				$customer['customerContactName'] = ucwords($customer['customerContactName']);
				$customer['customerCNPJ']		 = "NE";

				$insertCustomer = self::create(array(
					'customerCode' => $customer['customerCode'],
					'customerCNPJ' => $customer['customerCNPJ'],
					'customerName' => $customer['customerName'],
					'customerContactName' => $customer['customerContactName'],
					'customerSalesManID' => $customer['customerSalesManID'],
					'customerEmail' => $customer['customerEmail'],
					'customerZipCode' => $customer['customerZipCode'],
					'customerStreet' => $customer['customerStreet'],
					'customerStreetNumber' => $customer['customerStreetNumber'],
					'customerState' => $customer['customerState'],
					'customerNeighborhood' => $customer['customerNeighborhood'],
					'customerCity' => $customer['customerCity'],
					'customerIBGE' => $customer['customerIBGE'],
					'customerDiscountGroupID' => $customer['customerDiscountGroup'],
					'customertel' => $customer['customertel'],
					'customercel' => $customer['customercel'],
					'customerLastModBy' => $user
					));

			if($insertCustomer){
				$callbackObj->customer = $insertCustomer;
				$callbackObj->status = true;

			} else {
				$callbackObj->code = 'customer-existente';
			}
		  return $callbackObj;
	   }
}