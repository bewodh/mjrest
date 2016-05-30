<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Appointment extends BaseClient {
    
    /*
     * Termin anlegen
     */
    public function createDuedate($unit=0, $data=array())
    {
        $resource = "/service/activity?agencyId=".$unit;
        $clientUrl = $this->getClientUri($resource);
    
        $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $data);
    
        return $xml;
    }
    
    /*
     * Termin für Vorgang anlegen
     */
    public function createDuedateOffer($unit=0, $webcode=0, $data="")
    {
        $resource = "/service/folder/".$webcode."/activity?agencyId=".$unit;
        $clientUrl = $this->getClientUri($resource);
    
        $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $data);
    
        return $xml;
    }
    
}