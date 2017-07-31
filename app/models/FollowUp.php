<?php 

class FollowUp extends \HXPHP\System\Model
{					
		public static function saveFollowUp(array $followUp, $userID)
	{	$quotationID = $followUp['quotationID'];
		$which = $followUp['which'];
		if ($which == 1)
		{
				self::create(array(
						'followUpQuotationID' => $followUp['quotationID'],
						'followUpDesc1' => $followUp['followUpDesc1'],
						'followUpUserID1' => $userID,						
					));
		} else if ($which == 2)
		{
		$newFollowUp = self::find_by_followUpQuotationID($followUp['quotationID']);
		$newFollowUp->update_attributes(array(
						'followUpDesc2' => $followUp['followUpDesc2'],
						'followUpInsertionDate2' => date("Y-m-d H:i:s"),
						'followUpUserID2' => $userID,
					));		
		} else if ($which == 3)
		{
		$newFollowUp = self::find_by_followUpQuotationID($followUp['quotationID']);
		$newFollowUp->update_attributes(array(
						'followUpDesc3' => $followUp['followUpDesc3'],
						'followUpInsertionDate3' => date("Y-m-d H:i:s"),
						'followUpUserID3' => $userID,
					));		
		}

	}	


	public static function editFollowUp(array $followUp, $userID){
		$quotationID = $followUp['quotationID'];
		$newFollowUp = self::find_by_followUpQuotationID($quotationID);		
		$which = $followUp['which'];
		$data = ['followUpQuotationID' => $quotationID];
		if ($which == 1)
		{
		$newFollowUp = self::find_by_followUpQuotationID($followUp['quotationID']);
		$newFollowUp->update_attributes(array(
						'followUpDesc1' => $followUp['followUpDesc1'],
						'followUpUserID1' => $userID,
					));		
		} else if ($which == 2)
		{
		$newFollowUp = self::find_by_followUpQuotationID($followUp['quotationID']);
		$newFollowUp->update_attributes(array(
						'followUpDesc2' => $followUp['followUpDesc2'],
						'followUpUserID2' => $userID,
					));		
		} else if ($which == 3)
		{
		$newFollowUp = self::find_by_followUpQuotationID($followUp['quotationID']);
		$newFollowUp->update_attributes(array(
						'followUpDesc3' => $followUp['followUpDesc3'],
						'followUpUserID3' => $userID,
					));		
		}
	}

}