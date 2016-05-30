<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Foldergroups extends BaseClient {
    
    /*
	 * Verfügbare Gruppen aus dem Bereich Buchhaltung - Kostenstellen laden,
	 * bei denen eine Empfehlung existiert
	 */
	public function get($unit="0")
	{
	    if($unit != "undefined") {
    	    $recource = "/service/mobile/folder/offer/groups/";
    	    $clientUrl = $this->getClientUri($recource);
    	
    	    $header['agency'] = $unit;
    	    
    	    $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
	    } else {
	        $xml = "";
	    }
	    return $xml;
	}   
}