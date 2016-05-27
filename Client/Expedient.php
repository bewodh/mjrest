<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Expedient extends BaseClient {
    
    /*
     * mobile: Agentur Details laden
     */
    public function getExpedient($id=0)
    {
        $recource = "/service/expedient/".$id."/data";
        $clientUrl = $this->getClientUri($recource);
    
        $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true);
    
        return $xml;
    }
    
    public function getExpedientPic($id=0) {
        $recource = "/service/expedient/3663/image.jpg";
        $clientUrl = $this->getClientUri($recource);
    
        $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true);
    
        return $xml;
    }
    
    /*
     * Mitarbeiter abrufen
     */
    public function getAgent($userId=0)
    {
        $resource = "/service/cms/user/".$userId;
        $clientUrl = $this->getClientUri($resource);
    
        $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false);
    
        return $xml;
    }
}