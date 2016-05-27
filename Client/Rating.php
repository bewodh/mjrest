<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Rating extends BaseClient {
    
    /*
	 * Bewertung für Vorgang anlegen
	*/
	public function createRating($unit="", $webCode="", $data=array())
	{
		$resource = "/service/folder/".$webCode."/rate?agencyId=".$unit;
		$clientUrl = $this->getClientUri($resource);

		$xml = new \XMLWriter();
		$xml->openMemory();
		$xml->setIndent(false);
		$xml->startDocument();
		$xml->startElementNS("v1", "ImportableCustomerRatings", "http://www.webtravel.de/schema/myjack/v1");
		
		$xml->startElementNS("v1", "ratings", null );
		
		foreach ($data as $keyDate => $valueData) {
			$xml->startElementNS("v1", "rating", null );
			$xml->writeElementNS("v1", "questionClassifier", null , $valueData['questionClassifier']);
			$xml->writeElementNS("v1", "questionId", null , $valueData['questionId']);
			$xml->writeElementNS("v1", "questionText", null , $valueData['questionText']);
			$xml->writeElementNS("v1", "ratingMark", null , $valueData['ratingMark']);
			$xml->writeElementNS("v1", "ratingText", null , $valueData['ratingText']);
			$xml->endElement(); // Ende rating
		}
		
		$xml->endElement(); // Ende ratings
		$xml->endElement(); // Ende ImportableCustomerRatings
		
		$sendData = $xml->outputMemory();
		//\Zend\Debug\Debug::dump($sendData);
		$xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $sendData);
		
		return $xml;
	}
    
}