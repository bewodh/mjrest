<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Agency extends BaseClient {
    
    /*
	 * mobile: Agentur Daten laden
	 */
	public function getAgency($webcode=0)
	{
	    if($webcode != "undefined") {
    	    $recource = "/service/mobile/agency/webcode/".$webcode;
    	    $clientUrl = $this->getClientUri($recource);
    	
    	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true);
	    } else {
	        $xml = "";
	    }
	    return $xml;
	}
	
	/*
	 * mobile: Agentur Daten laden, anhand Vorgangs-WEB-Code
	 */
	public function getAgencyByWebCode($webcode=0)
	{
	    $recource = "/service/mobile/agency/folder/".$webcode;
	    $clientUrl = $this->getClientUri($recource);
	
	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true);
	     
	    return $xml;
	}
	
	/*
	 * mobile: Agentur Details laden
	 */
	public function getAgencyDetails($unit=0)
	{
	    $recource = "/service/mobile/agency/id/".$unit;
	    $clientUrl = $this->getClientUri($recource);
	
	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true);
	
	    return $xml;
	}
    
}