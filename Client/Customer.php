<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Customer extends BaseClient {
    
    /*
     * Vorgänge einse Kunden laden
     */
    public function getClientFolders($unit=0, $id=0, $type="")
	{
	    if ($type == "") {
	        $recource = "/service/mobile/folder/customer/".$id;
	    } else {
	        $recource = "/service/mobile/folder/customer/".$id."?type=".$type;
	    }
	    
	    $clientUrl = $this->getClientUri($recource);
	
	    $header['agency'] = $unit;
	    $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);

	    return $xml;
	}
	
	/*
	 * mobile: Endkunden Login
	 */
	public function customerLogin($unit=0, $email="", $webcode=0)
	{
	    $recource = "/service/mobile/customer/header/webcode/".$webcode."?email=".$email;
	    $clientUrl = $this->getClientUri($recource);
	
	    $header['agency'] = $unit;
	    $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
	
	    return $xml;
	}
	
	/*
	 * Lade aktuelle Reise
	 */
	public function getCurrentTrip($id=0, $unit=0)
	{
	    $recource = "/service/mobile/folder/current/customer/".$id;
	    $clientUrl = $this->getClientUri($recource);
	
	    $header['agency'] = $unit;
	    $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
	
	    return $xml;
	}
	
	/*
	 * Vorgänge eines Kunden abrufen
	 */
	public function customerFolders($unit=0, $customerNumber=0)
	{
	    $resource = "/service/customer/".$customerNumber."/folders?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false);
	
	    return $xml;
	}
	
	/*
	 * Kundendaten abrufen
	 * inkl. activities und memos
	 */
	public function customerDatas($unit=0, $customerNumber=0)
	{
	    $resource = "/service/customer/".$customerNumber."?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false);
	
	    return $xml;
	}
	
	/*
	 * Kunde suchen
	 */
	public function customerSearch($unit=0, $data=array(), $disclose=FALSE)
	{
	     
	    $resource = "/service/customer/search?agencyId=".$unit;
	
	    // Liefert das APP-Passwort des Kunden (Kunden WEB-Code) mit
	    if ($disclose == TRUE) {
	        $resource = $resource."&disclose=true";
	    }
	
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = new \XMLWriter();
	    $xml->openMemory();
	    $xml->setIndent(true);
	    $xml->startDocument();
	
	    $xml->startElementNS("v1", "CustomerSearchParameters", "http://www.webtravel.de/schema/myjack/v1");
	
	    if (isset($data['name'])) { $xml->writeElementNS("v1", "name", null , $data['name']); };
	    if (isset($data['place'])) { $xml->writeElementNS("v1", "password", null , $data['place']); };
	    if (isset($data['zipCode'])) { $xml->writeElementNS("v1", "zipCode", null , $data['zipCode']); };
	    if (isset($data['phone'])) { $xml->writeElementNS("v1", "phone", null , $data['phone']); };
	    if (isset($data['email'])) { $xml->writeElementNS("v1", "email", null , $data['email']); };
	    if (isset($data['customerNumber'])) { $xml->writeElementNS("v1", "customerNumber", null , $data['customerNumber']); };
	
	    $xml->endElement(); //End the element
	
	    $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $xml->outputMemory());
	
	    return $xml;
	}
	
	/*
	 * Kunde für Zugriff auf geschützten Kundenbereich registrieren
	 */
	public function customerRegister($unit=0, $data=array())
	{
	    $resource = "/service/customer/register?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = new \XMLWriter();
	    $xml->openMemory();
	    $xml->setIndent(true);
	    $xml->startDocument();
	
	    $xml->startElementNS("v1", "CustomerRegistration", "http://www.webtravel.de/schema/myjack/v1");
	
	    if (isset($data['type'])) { $xml->writeAttributeNS("v1", "type", null , $data['type']); };
	    if (isset($data['title'])) { $xml->writeAttributeNS("v1", "title", null , $data['title']); };
	    if (isset($data['dueDate'])) { $xml->writeAttributeNS("v1", "dueDate", null , $data['dueDate']); };
	    if (isset($data['assignee'])) { $xml->writeAttributeNS("v1", "assignee", null , $data['assignee']); };
	    if (isset($data['notification'])) { $xml->writeAttributeNS("v1", "notification", null , $data['notification']); };
	
	    if (isset($data['email'])) { $xml->writeElementNS("v1", "email", null , $data['email']); };
	    if (isset($data['password'])) { $xml->writeElementNS("v1", "password", null , $data['password']); };
	
	    $xml->startElementNS("v1", "customer", null);
	    if (isset($data['salutation'])) { $xml->writeElementNS("v1", "salutation", null , $data['salutation']); };
	    if (isset($data['title'])) { $xml->writeElementNS("v1", "title", null , $data['title']); };
	    if (isset($data['firstName'])) { $xml->writeElementNS("v1", "firstName", null , $data['firstName']); };
	    if (isset($data['lastName'])) { $xml->writeElementNS("v1", "lastName", null , $data['lastName']); };
	    if (isset($data['dateOfBirth'])) { $xml->writeElementNS("v1", "dateOfBirth", null , $data['dateOfBirth']); };
	    if (isset($data['addressLine1'])) { $xml->writeElementNS("v1", "addressLine1", null , $data['addressLine1']); };
	    if (isset($data['addressLine2'])) { $xml->writeElementNS("v1", "addressLine2", null , $data['addressLine2']); };
	    if (isset($data['zipCode'])) { $xml->writeElementNS("v1", "zipCode", null , $data['zipCode']); };
	    if (isset($data['place'])) { $xml->writeElementNS("v1", "place", null , $data['place']); };
	    if (isset($data['country'])) { $xml->writeElementNS("v1", "country", null , $data['country']); };
	    if (isset($data['postbox'])) { $xml->writeElementNS("v1", "postbox", null , $data['postbox']); };
	    if (isset($data['postboxZipCode'])) { $xml->writeElementNS("v1", "postboxZipCode", null , $data['postboxZipCode']); };
	    if (isset($data['postboxCountry'])) { $xml->writeElementNS("v1", "postboxCountry", null , $data['postboxCountry']); };
	    if (isset($data['letterSalutation'])) { $xml->writeElementNS("v1", "letterSalutation", null , $data['letterSalutation']); };
	
	    if (isset($data['communications']) && count($data['communications']) > 0) {
	        $xml->startElementNS("v1", "communications", null );
	        foreach ($data['communications'] as $key => $value) {
	            $xml->startElementNS("v1", "communication", null);
	            //$xml->writeAttributeNS("v1", 'id', null, "");
	            $xml->writeAttributeNS("v1", 'type', null, $value['type']);
	            //$xml->writeAttributeNS("v1", 'default', null, "");
	            $xml->writeElementNS("v1", "value", null , $value['value']);
	            $xml->writeElementNS("v1", "comment", null , $value['comment']);
	            $xml->endElement(); // Ende communication
	        }
	        $xml->endElement(); // Ende communications
	    }
	    $xml->endElement(); //End the element
	
	    $xml->endElement(); //End the element
	    $xml->endElement(); //End the element
	    //echo htmlentities($xml->outputMemory());
	    $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $xml->outputMemory());
	
	    return $xml;
	}
	
	/*
	 * Kunde Authentifizieren
	 */
	public function customerAuthenticate($unit=0, $data=array())
	{
	    $resource = "/service/customer/authenticate?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = new \XMLWriter();
	    $xml->openMemory();
	    $xml->setIndent(true);
	    $xml->startDocument();
	
	    $xml->startElementNS("v1", "CustomerAuthentication", "http://www.webtravel.de/schema/myjack/v1");
	
	    if (isset($data['email'])) { $xml->writeElementNS("v1", "email", null , $data['email']); };
	    if (isset($data['password'])) { $xml->writeElementNS("v1", "password", null , $data['password']); };
	
	    $xml->endElement(); //End the element
	
	    $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $xml->outputMemory());
	
	    return $xml;
	}
	
	/*
	 * Kunde anlegen
	 * personType: CUSTOMER, CANDIDATE, ASSOCIATION, ADDRESS, OPERATOR, AGENCY_ADDRESS, CHAIN_ADDRESS, CUSTOMER_EXTERN
	 * CommunicationType: TELEPHONE, MOBILE, MAIL, WEB, FAX, TELEPHONE_BUSINESS
	 * ActivityType: BOOKING, OFFER, OPTION, CUSTOMER, BIRTHDAY, DEPOSIT_PAYMENT, FINAL_PAYMENT, WEDDINGDAY, REQUEST, AGENCY
	 * ActivityInterval: ONCE, ANNUALLY
	 * PersonSalutation: MALE, FEMALE, COMPANY, GROUP, CHILD, INFANT, COUPLE, FAMILY
	 */
	public function customerNew($unit=0, $data=array())
	{
	    $recource = "/service/customer/new?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($recource);
	
	    $xml = new \XMLWriter();
	    $xml->openMemory();
	    $xml->setIndent(false);
	    $xml->startDocument();
	    $xml->startElementNS("v1", "ImportableCustomer", "http://www.webtravel.de/schema/myjack/v1");
	
	    $xml->startElementNS("v1", "customer", null );
	
	    //$xml->writeAttributeNS("v1", 'id', null, "");
	    if (isset($data['personType'])) { $xml->writeAttributeNS("v1", 'personType', null, $data['personType']); };
	    if (isset($data['customerNumber'])) { $xml->writeAttributeNS("v1", 'customerNumber', null, $data['customerNumber']); };
	
	    if (isset($data['salutation'])) { $xml->writeElementNS("v1", "salutation", null , $data['salutation']); };
	    if (isset($data['title'])) { $xml->writeElementNS("v1", "title", null , $data['title']); };
	    if (isset($data['firstName'])) { $xml->writeElementNS("v1", "firstName", null , $data['firstName']); };
	    if (isset($data['lastName'])) { $xml->writeElementNS("v1", "lastName", null , $data['lastName']); };
	    if (isset($data['dateOfBirth'])) { $xml->writeElementNS("v1", "dateOfBirth", null , $data['dateOfBirth']); };
	    if (isset($data['addressLine1'])) { $xml->writeElementNS("v1", "addressLine1", null , $data['addressLine1']); };
	    if (isset($data['addressLine2'])) { $xml->writeElementNS("v1", "addressLine2", null , $data['addressLine2']); };
	    if (isset($data['zipCode'])) { $xml->writeElementNS("v1", "zipCode", null , $data['zipCode']); };
	    if (isset($data['place'])) { $xml->writeElementNS("v1", "place", null , $data['place']); };
	    if (isset($data['country'])) { $xml->writeElementNS("v1", "country", null , $data['country']); };
	    if (isset($data['postbox'])) { $xml->writeElementNS("v1", "postbox", null , $data['postbox']); };
	    if (isset($data['postboxZipCode'])) { $xml->writeElementNS("v1", "postboxZipCode", null , $data['postboxZipCode']); };
	    if (isset($data['postboxCountry'])) { $xml->writeElementNS("v1", "postboxCountry", null , $data['postboxCountry']); };
	    //if (isset($data['letterSalutation'])) { $xml->writeElementNS("v1", "letterSalutation", null , $data['letterSalutation']); };
	
	    if (isset($data['communications']) && count($data['communications']) > 0) {
	        $xml->startElementNS("v1", "communications", null );
	        foreach ($data['communications'] as $key => $value) {
	            $xml->startElementNS("v1", "communication", null);
	            //$xml->writeAttributeNS("v1", 'id', null, "");
	            $xml->writeAttributeNS("v1", 'type', null, $value['type']);
	            if (isset($value['isDefault']) && $value['isDefault'] == TRUE) {
	                $xml->writeAttributeNS("v1", "default", null , TRUE);
	            }
	            //$xml->writeAttributeNS("v1", 'default', null, "");
	            $xml->writeElementNS("v1", "value", null , $value['value']);
	            $xml->writeElementNS("v1", "comment", null , $value['comment']);
	
	            $xml->endElement(); // Ende communication
	        }
	        $xml->endElement(); // Ende communications
	    }
	
	    /*
	     $xml->startElementNS("v1", "activities", null );
	     $xml->startElementNS("v1", "activity", null);
	     $xml->writeAttributeNS("v1", 'id', null, "");
	     $xml->writeAttributeNS("v1", 'type', null, "");
	     $xml->writeAttributeNS("v1", 'closed', null, "");
	     $xml->writeAttributeNS("v1", 'deleted', null, "");
	     $xml->writeElementNS("v1", "title", null , "");
	     $xml->writeElementNS("v1", "description", null , "");
	     $xml->writeElementNS("v1", "dueDate", null , "");
	     $xml->writeElementNS("v1", "interval", null , "");
	     $xml->writeElementNS("v1", "notification", null , "");
	     $xml->startElementNS("v1", "assignee", null );
	     $xml->writeAttributeNS("v1", 'id', null, "");
	     $xml->writeAttributeNS("v1", 'login', null, "");
	     $xml->writeAttributeNS("v1", 'expedient', null, "");
	     $xml->writeElementNS("v1", "gender", null , "");
	     $xml->writeElementNS("v1", "title", null , "");
	     $xml->writeElementNS("v1", "firstName", null , "");
	     $xml->writeElementNS("v1", "lastName", null , "");
	     $xml->writeElementNS("v1", "email", null , "");
	     $xml->endElement(); // Ende assignee
	     $xml->endElement(); // Ende activitie
	     $xml->endElement(); // Ende activities
	
	     $xml->startElementNS("v1", "memos", null );
	     $xml->startElementNS("v1", "memo", null );
	     $xml->writeAttributeNS("v1", 'id', null, "");
	     $xml->writeElementNS("v1", "text", null , "");
	     $xml->endElement(); // Ende memo
	     $xml->endElement(); // Ende memos
	
	     $xml->startElementNS("v1", "agency", null );
	
	     $xml->writeAttributeNS("v1", 'id', null, "");
	
	     $xml->writeElementNS("v1", "name", null , "");
	     $xml->writeElementNS("v1", "description", null , "");
	     $xml->writeElementNS("v1", "addressLine1", null , "");
	     $xml->writeElementNS("v1", "addressLine2", null , "");
	     $xml->writeElementNS("v1", "zipCode", null , "");
	     $xml->writeElementNS("v1", "place", null , "");
	     $xml->writeElementNS("v1", "country", null , "");
	
	     $xml->endElement(); // Ende agency
	     */
	    $xml->endElement(); // Ende customer
	
	    $xml->endElement();
	
	    //echo htmlentities($xml->outputMemory());
	
	    $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $xml->outputMemory());
	
	    //return $xml->outputMemory();
	    return $xml;
	}
	
	/*
	 * Kunde Adresse ändern
	 * Termin bei Kunde zur Adressänderung anlegen
	 */
	public function customerUpdate($unit=0, $customerNumber=0, $data=array())
	{
	    $resource = "/service/customer/".$customerNumber."/update/address?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = new \XMLWriter();
	    $xml->openMemory();
	    $xml->setIndent(true);
	    $xml->startDocument();
	
	    $xml->startElementNS("v1", "CustomerAddressUpdate", "http://www.webtravel.de/schema/myjack/v1");
	
	    if (isset($data['type'])) { $xml->writeAttributeNS("v1", "type", null , $data['type']); };
	    if (isset($data['title'])) { $xml->writeAttributeNS("v1", "title", null , $data['title']); };
	    if (isset($data['dueDate'])) { $xml->writeAttributeNS("v1", "dueDate", null , $data['dueDate']); };
	    if (isset($data['assignee'])) { $xml->writeAttributeNS("v1", "assignee", null , $data['assignee']); };
	    if (isset($data['notification'])) { $xml->writeAttributeNS("v1", "notification", null , $data['notification']); };
	
	    if (isset($data['addressLine1'])) { $xml->writeElementNS("v1", "addressLine1", null , $data['addressLine1']); };
	    if (isset($data['addressLine2'])) { $xml->writeElementNS("v1", "addressLine2", null , $data['addressLine2']); };
	    if (isset($data['zipCode'])) { $xml->writeElementNS("v1", "zipCode", null , $data['zipCode']); };
	    if (isset($data['place'])) { $xml->writeElementNS("v1", "place", null , $data['place']); };
	    if (isset($data['country'])) { $xml->writeElementNS("v1", "country", null , $data['country']); };
	
	    $xml->endElement(); //End the element
	    $xml->endElement(); //End the element
	
	    //echo htmlentities($xml->outputMemory());
	
	    $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $xml->outputMemory());
	
	    return $xml;
	}
	
	/*
	 * Optin/Optout bei Kunde setzen
	 */
	public function customerSetMarketing($unit=0, $customer=0, $type="NEWSLETTER", $status="active" )
	{
	    if ($status == "active") {
	        $statusNew = "optin";
	    } else {
	        $statusNew = "optout";
	    }
	    $resource = "/service/customer/".$customer."/".$statusNew."?optInTarget=".$type."&agencyId=".$unit;
	
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false);
	
	    return $xml;
	}
}