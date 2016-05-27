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
    
        //create a new xmlwriter object
        $xml = new \XMLWriter();
        //using memory for string output
        $xml->openMemory();
        //set the indentation to true (if false all the xml will be written on one line)
        $xml->setIndent(true);
        //create the document tag, you can specify the version and encoding here
        $xml->startDocument();
        //Create an element
        $xml->startElementNS("v1", "ImportableActivity", "http://www.webtravel.de/schema/myjack/v1");
    
        if (isset($data['type'])) { $xml->writeAttributeNS("v1", "type", null , $data['type']); };
        if (isset($data['title'])) { $xml->writeAttributeNS("v1", "title", null , $data['title']); };
        if (isset($data['dueDate'])) { $xml->writeAttributeNS("v1", "dueDate", null , $data['dueDate']); };
        if (isset($data['assignee'])) { $xml->writeAttributeNS("v1", "assignee", null , $data['assignee']); };
        if (isset($data['notification'])) { $xml->writeAttributeNS("v1", "notification", null , $data['notification']); };
    
        if (isset($data['description'])) { $xml->writeElementNS("v1", "description", null , $data['description']); };
    
        $xml->endElement(); //End the element
        $xml->endElement(); //End the element
    
        //echo htmlentities($xml->outputMemory());
    
        $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $xml->outputMemory());
    
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