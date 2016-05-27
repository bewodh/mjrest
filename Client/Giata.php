<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Giata extends BaseClient {
    
    /*
	 * mobile: GIATA Daten des Vorgangs laden
	 */
	public function getGiataDetails($unit=0, $id=0)
	{
	    $recource = "/service/mobile/folder/giata/information/".$id;
	    $clientUrl = $this->getClientUri($recource);
	    
	    $header['agency'] = $unit;
	    $response = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);

	    return $response;
	}
	
	/*
	 * mobile: GIATA Daten der Leistung laden
	 */
	public function getGiataDetailsService($unit=0, $id=0)
	{
	    $recource = "/service/mobile/reservationdetails/giata/information/".$id;
	    $clientUrl = $this->getClientUri($recource);
	
	    $header['agency'] = $unit;
	    $response = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
	
	    return $response;
	}
}