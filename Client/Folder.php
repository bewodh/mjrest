<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Folder extends BaseClient {
    
    /*
     * mobile: Folder Header laden
     */
    public function getFolderHeader($unit=0, $id=0)
    {
        $recource = "/service/mobile/folder/header/".$id;
        $clientUrl = $this->getClientUri($recource);
    
        $header['agency'] = $unit;
        $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
    
        return $xml;
    }
    
    /*
     * mobile: Service Header laden
     */
    public function getReservationHeader($unit=0, $id=0, $picSize=320, $cf="", $showRequest=false, $showResponse=false)
    {
        $recource = "/service/mobile/reservation/headers/".$id."?giata=true&picSize=pic$picSize";
        $clientUrl = $this->getClientUri($recource);
    
        $header['agency'] = $unit;
    
        $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true, $showRequest, $showResponse);
         
        if(isset($xml['content']['headers'])) {
            if (is_array($xml['content']['headers'])) {
                $countContentHeader = 0;
                foreach($xml['content']['headers'] as $reservationHeaderKey => $reservationHeaderValue) {
                    if (isset($reservationHeaderValue['giataInformationList']) && !isset($reservationHeaderValue['giataInformationList'][0])) {
                        $xml['myJackRequest'] = $recource;
                    }
                    $countContentHeader++;
                }
                $xml['comeingFrom'] = $cf;
            }
        }
        //\Zend\Debug\Debug::dump($recource);
        return $xml;
    }
    
    /*
     * mobile: Service Header laden ohne Bilder
     */
    public function getReservationHeaderWithoutPic($unit=0, $id=0, $picSize=320, $cf="")
    {
        $recource = "/service/mobile/reservation/headers/".$id;
        $clientUrl = $this->getClientUri($recource);
    
        $header['agency'] = $unit;
    
        $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
        //\Zend\Debug\Debug::dump($recource);
        if (is_array($xml['content']['headers'])) {
            $countContentHeader = 0;
            foreach($xml['content']['headers'] as $reservationHeaderKey => $reservationHeaderValue) {
                if (isset($reservationHeaderValue['giataInformationList']) && !isset($reservationHeaderValue['giataInformationList'][0])) {
                    $xml['myJackRequest'] = $recource;
                }
                $countContentHeader++;
            }
            $xml['comeingFrom'] = $cf;
        }
    
        return $xml;
    }
    
    /*
     * mobile: Service Details laden
     */
    public function getReservationDetail($unit=0, $id=0)
    {
        $recource = "/service/mobile/reservation/details/".$id;
        $clientUrl = $this->getClientUri($recource);
    
        $header['agency'] = $unit;
        $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
    
        return $xml;
    }
    
    /*
	 * mobile: Agentur Daten laden
	 */
	public function getFolder($unit=0, $webcode=0)
	{
	    $recource = "/service/mobile/folder/webcode/".$webcode;
	    $clientUrl = $this->getClientUri($recource);
	
	    $header['agency'] = $unit;
	    $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
	
	    return $xml;
	}
	
	public function getOrderByWebcode($webcode=0)
	{
	    $recource = "/service/cms/folder/".$webcode."?disclose=true";
	    $clientUrl = $this->getClientUri($recource);
	
	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, true);
	
	    return $xml;
	}
    
	/*
	 * Globale Angebote laden
	 */
	public function getGlobalOffers($unit=0)
	{
	    $recource = "/service/mobile/folder/offers";
	    $clientUrl = $this->getClientUri($recource);
	
	    $header['agency'] = $unit;
	    $xml = $this->doRequest($clientUrl, 'GET', $header, array(), array(), null, false, true);
	
	    return $xml;
	}
	
	/*
	 * Vorgang suchen anhand von WEB-Code und Unit
	 * disclose: ture = mit Kundendaten, false = ohne Kundendaten
	 */
	public function folderFindWebcode($unit=0, $webCode, $disclose=FALSE)
	{
	    $resource = "/service/folder/".$webCode."?agencyId=".$unit."&disclose=".$disclose;
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, true);
	
	    return $xml;
	}
	
	/*
	 * Vorgang suchen
	 */
	public function folderFind($unit=0, $data=array())
	{
	    $resource = "/service/folder/find?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = new \XMLWriter();
	    $xml->openMemory();
	    $xml->setIndent(true);
	    $xml->startDocument();
	
	    $xml->startElementNS("v1", "FolderSearchParameters", "http://www.webtravel.de/schema/myjack/v1");
	
	    if (isset($data['folderNumber'])) { $xml->writeElementNS("v1", "folderNumber", null , $data['folderNumber']); };
	    if (isset($data['customerNumber'])) { $xml->writeElementNS("v1", "customerNumber", null , $data['customerNumber']); };
	    if (isset($data['reservationType'])) { $xml->writeElementNS("v1", "reservationType", null , $data['reservationType']); };
	    if (isset($data['reservationOperator'])) { $xml->writeElementNS("v1", "reservationOperator", null , $data['reservationOperator']); };
	    if (isset($data['reservationTravelType'])) { $xml->writeElementNS("v1", "reservationTravelType", null , $data['reservationTravelType']); };
	    if (isset($data['reservationNumber'])) { $xml->writeElementNS("v1", "reservationNumber", null , $data['reservationNumber']); };
	    if (isset($data['reservationStartDate'])) { $xml->writeElementNS("v1", "reservationStartDate", null , $data['reservationStartDate']); };
	    if (isset($data['reservationEndDate'])) { $xml->writeElementNS("v1", "reservationEndDate", null , $data['reservationEndDate']); };
	    if (isset($data['reservationExpedientNumber'])) { $xml->writeElementNS("v1", "reservationExpedientNumber", null , $data['reservationExpedientNumber']); };
	    if (isset($data['reservationTotalPrice'])) { $xml->writeElementNS("v1", "reservationTotalPrice", null , $data['reservationTotalPrice']); };
	    if (isset($data['openFolder'])) { $xml->writeElementNS("v1", "openFolder", null , $data['openFolder']); };
	
	    $xml->endElement(); //End the element
	    //echo htmlentities($xml->outputMemory());
	    $xml = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $xml->outputMemory());
	
	    return $xml;
	}
	
	/*
	 * Vorgang anlegen
	 */
	public function reservationNew($unit=0, $data=array()) {
	    $resource = "/service/reservation/new?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($resource);
	
	    $xml = new \XMLWriter();
	    $xml->openMemory();
	    $xml->setIndent(true);
	    $xml->startDocument();
	
	    $xml->startElementNS("v1", "ImportableReservation", "http://www.webtravel.de/schema/myjack/v1");
	
	    if (isset($data['targetWebCode'])) { $xml->writeAttributeNS("v1", "targetWebCode", null , $data['targetWebCode']); };
	
	    if (isset($data['destination'])) { $xml->writeElementNS("v1", "destination", null , $data['destination']); };
	    if (isset($data['typeOfProduct'])) { $xml->writeElementNS("v1", "typeOfProduct", null , $data['typeOfProduct']); };
	    if (isset($data['transport'])) { $xml->writeElementNS("v1", "transport", null , $data['transport']); };
	    if (isset($data['folderNumberCandidate'])) { $xml->writeElementNS("v1", "folderNumberCandidate", null , $data['folderNumberCandidate']); };
	
	    if (isset($data['customer'])) {
	        $xml->startElementNS("v1", "customer", null );
	        	
	        if (isset($data['customer']['salutation'])) { $xml->writeElementNS("v1", "salutation", null , $data['customer']['salutation']); };
	        if (isset($data['customer']['title'])) { $xml->writeElementNS("v1", "title", null , $data['customer']['title']); };
	        if (isset($data['customer']['firstName'])) { $xml->writeElementNS("v1", "firstName", null , $data['customer']['firstName']); };
	        if (isset($data['customer']['lastName'])) { $xml->writeElementNS("v1", "lastName", null , $data['customer']['lastName']); };
	        if (isset($data['customer']['dateOfBirth'])) { $xml->writeElementNS("v1", "dateOfBirth", null , $data['customer']['dateOfBirth']); };
	        if (isset($data['customer']['addressLine1'])) { $xml->writeElementNS("v1", "addressLine1", null , $data['customer']['addressLine1']); };
	        if (isset($data['customer']['addressLine2'])) { $xml->writeElementNS("v1", "addressLine2", null , $data['customer']['addressLine2']); };
	        if (isset($data['customer']['zipCode'])) { $xml->writeElementNS("v1", "zipCode", null , $data['customer']['zipCode']); };
	        if (isset($data['customer']['place'])) { $xml->writeElementNS("v1", "place", null , $data['customer']['place']); };
	        if (isset($data['customer']['country'])) { $xml->writeElementNS("v1", "country", null , $data['customer']['country']); };
	        if (isset($data['customer']['postbox'])) { $xml->writeElementNS("v1", "postbox", null , $data['customer']['postbox']); };
	        if (isset($data['customer']['postboxZipCode'])) { $xml->writeElementNS("v1", "postboxZipCode", null , $data['customer']['postboxZipCode']); };
	        if (isset($data['customer']['postboxCountry'])) { $xml->writeElementNS("v1", "postboxCountry", null , $data['customer']['postboxCountry']); };
	        if (isset($data['customer']['letterSalutation'])) { $xml->writeElementNS("v1", "letterSalutation", null , $data['customer']['letterSalutation']); };
	        	
	        if (isset($data['customer']['communications']) && count($data['customer']['communications']) > 0) {
	            $xml->startElementNS("v1", "communications", null );
	            foreach ($data['customer']['communications'] as $key => $value) {
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
	        	
	        $xml->endElement(); //End customer
	    } //End customer
	
	    if (isset($data['travellers'])) {
	        $xml->startElementNS("v1", "travellers", null );
	        foreach ($data['travellers'] as $keyTravellers => $valueTravellers) {
	            $xml->startElementNS("v1", "traveller", null);
	            if (isset($valueTravellers['salutation'])) { $xml->writeElementNS("v1", "salutation", null , $valueTravellers['salutation']); };
	            if (isset($valueTravellers['title'])) { $xml->writeElementNS("v1", "title", null , $valueTravellers['title']); };
	            if (isset($valueTravellers['firstName'])) { $xml->writeElementNS("v1", "firstName", null , $valueTravellers['firstName']); };
	            if (isset($valueTravellers['lastName'])) { $xml->writeElementNS("v1", "lastName", null , $valueTravellers['lastName']); };
	            if (isset($valueTravellers['dateOfBirth'])) { $xml->writeElementNS("v1", "dateOfBirth", null , $valueTravellers['dateOfBirth']); };
	            if (isset($valueTravellers['age'])) { $xml->writeElementNS("v1", "age", null , $valueTravellers['age']); };
	            if (isset($valueTravellers['quantity'])) { $xml->writeElementNS("v1", "quantity", null , $valueTravellers['quantity']); };
	            if (isset($valueTravellers['price'])) {
	                $xml->startElementNS("v1", "price", null);
	                if (isset($valueTravellers['currency'])) { $xml->writeAttributeNS("v1", "currency", null, $valueTravellers['currency']); };
	                $xml->text($valueTravellers['price']);
	                $xml->endElement(); // Ende price
	            };
	            $xml->endElement(); // Ende traveller
	        }
	        $xml->endElement(); // Ende travellers
	    }
	
	    if (isset($data['reservation']) && count($data['reservation']) > 0) {
	        foreach ($data['reservation'] as $keyReservation => $valueReservation) {
	
	            $xml->startElementNS("v1", "reservation", null );
	
	            if (isset($valueReservation['id'])) { $xml->writeAttributeNS("v1", "id", null , $valueReservation['id']); };
	            if (isset($valueReservation['crsBooking'])) { $xml->writeAttributeNS("v1", "crsBooking", null , $valueReservation['crsBooking']); };
	            if (isset($valueReservation['updateable'])) { $xml->writeAttributeNS("v1", "updateable", null , $valueReservation['updateable']); };
	            if (isset($valueReservation['disabled'])) { $xml->writeAttributeNS("v1", "disabled", null , $valueReservation['disabled']); };
	            if (isset($valueReservation['offer'])) { $xml->writeAttributeNS("v1", "offer", null , $valueReservation['offer']); };
	
	            if (isset($valueReservation['reservationType'])) { $xml->writeElementNS("v1", "reservationType", null , $valueReservation['reservationType']); };
	            if (isset($valueReservation['tourOperator'])) { $xml->writeElementNS("v1", "tourOperator", null , $valueReservation['tourOperator']); };
	            if (isset($valueReservation['travelType'])) { $xml->writeElementNS("v1", "travelType", null , $valueReservation['travelType']); };
	            if (isset($valueReservation['reservationNumber'])) { $xml->writeElementNS("v1", "reservationNumber", null , $valueReservation['reservationNumber']); };
	            if (isset($valueReservation['bookingState'])) { $xml->writeElementNS("v1", "bookingState", null , $valueReservation['bookingState']); };
	            if (isset($valueReservation['bookingDate'])) { $xml->writeElementNS("v1", "bookingDate", null , $valueReservation['bookingDate']); };
	            if (isset($valueReservation['startDate'])) { $xml->writeElementNS("v1", "startDate", null , $valueReservation['startDate']); };
	            if (isset($valueReservation['endDate'])) { $xml->writeElementNS("v1", "endDate", null , $valueReservation['endDate']); };
	            if (isset($valueReservation['paxCount'])) { $xml->writeElementNS("v1", "paxCount", null , $valueReservation['paxCount']); };
	            //if (isset($valueReservation['totalPrice'])) { $xml->writeElementNS("v1", "totalPrice", null , $valueReservation['totalPrice']); };
	
	            if (isset($valueReservation['totalPrice'])) {
	                $xml->startElementNS("v1", "totalPrice", null);
	                if (isset($valueReservation['currency'])) { $xml->writeAttributeNS("v1", "currency", null, $valueReservation['currency']); };
	                $xml->text($valueReservation['totalPrice']);
	                $xml->endElement(); // Ende price
	            };
	
	            if (isset($valueReservation['differingOperatorAddress'])) { $xml->writeElementNS("v1", "differingOperatorAddress", null , $valueReservation['differingOperatorAddress']); };
	            if (isset($valueReservation['targetAirport'])) { $xml->writeElementNS("v1", "targetAirport", null , $valueReservation['targetAirport']); };
	            if (isset($valueReservation['crsXmlContent'])) { $xml->writeElementNS("v1", "crsXmlContent", null , $valueReservation['crsXmlContent']); };
	            if (isset($valueReservation['country'])) { $xml->writeElementNS("v1", "country", null , $valueReservation['country']); };
	            if (isset($valueReservation['additionalText'])) { $xml->writeElementNS("v1", "additionalText", null , $valueReservation['additionalText']); };
	
	            if (isset($valueReservation['priceLines']) && count($valueReservation['priceLines']) > 0) {
	                $xml->startElementNS("v1", "priceLines", null );
	                	
	                foreach ($valueReservation['priceLines'] as $keyPriceLine => $valuePriceLine) {
	                    $xml->startElementNS("v1", "priceLine", null );
	                    if (isset($valuePriceLine['encashmentType'])) { $xml->writeElementNS("v1", "encashmentType", null , $valuePriceLine['encashmentType']); };
	                    //if (isset($valuePriceLine['price'])) { $xml->writeElementNS("v1", "price", null , $valuePriceLine['price']); };
	                    if (isset($valuePriceLine['price'])) {
	                        $xml->startElementNS("v1", "price", null);
	                        if (isset($valuePriceLine['currency'])) { $xml->writeAttributeNS("v1", "currency", null, $valuePriceLine['currency']); };
	                        $xml->text($valuePriceLine['price']);
	                        $xml->endElement(); // Ende price
	                    };
	                    if (isset($valuePriceLine['currency'])) { $xml->writeAttributeNS("v1", "currency", null , $valuePriceLine['currency']); };
	                    if (isset($valuePriceLine['multiplicator'])) { $xml->writeElementNS("v1", "multiplicator", null , $valuePriceLine['multiplicator']); };
	                    if (isset($valuePriceLine['totalAmount'])) {
	                        $xml->startElementNS("v1", "totalAmount", null);
	                        if (isset($valuePriceLine['currency'])) { $xml->writeAttributeNS("v1", "currency", null, $valuePriceLine['currency']); };
	                        $xml->text($valuePriceLine['totalAmount']);
	                        $xml->endElement(); // Ende price
	                    };
	                    if (isset($valuePriceLine['priceTypeQualifier'])) { $xml->writeElementNS("v1", "priceTypeQualifier", null , $valuePriceLine['priceTypeQualifier']); };
	                    if (isset($valuePriceLine['description'])) { $xml->writeElementNS("v1", "description", null , $valuePriceLine['description']); };
	                    $xml->endElement(); // Ende priceLine
	                }
	                	
	                $xml->endElement(); // Ende priceLines
	            }
	
	            if (isset($valueReservation['details']) && count($valueReservation['details']) > 0) {
	                $xml->startElementNS("v1", "details", null );
	                foreach ($valueReservation['details'] as $keyReservationDetails => $valueReservationDetails) {
	                    // Flug
	                    if ($valueReservationDetails['type'] == "flightDetails") {
	                        $xml->startElementNS("v1", "flightDetails", null );
	                        if (isset($valueReservationDetails['flightSegments']) && $valueReservationDetails['flightSegments'] > 0) {
	                            $xml->startElementNS("v1", "flightSegments", null );
	                            foreach ($valueReservationDetails['flightSegments'] as $keyFlightSegments => $valueFlightSegments) {
	                                $xml->startElementNS("v1", "flightSegment", null );
	                                if (isset($valueFlightSegments['departureAirport'])) { $xml->writeElementNS("v1", "departureAirport", null , $valueFlightSegments['departureAirport']); };
	                                if (isset($valueFlightSegments['arrivalAirport'])) { $xml->writeElementNS("v1", "arrivalAirport", null , $valueFlightSegments['arrivalAirport']); };
	                                if (isset($valueFlightSegments['departureTime'])) { $xml->writeElementNS("v1", "departureTime", null , $valueFlightSegments['departureTime']); };
	                                if (isset($valueFlightSegments['arrivalTime'])) { $xml->writeElementNS("v1", "arrivalTime", null , $valueFlightSegments['arrivalTime']); };
	                                if (isset($valueFlightSegments['carrier'])) { $xml->writeElementNS("v1", "carrier", null , $valueFlightSegments['carrier']); };
	                                if (isset($valueFlightSegments['flightNumber'])) { $xml->writeElementNS("v1", "flightNumber", null , $valueFlightSegments['flightNumber']); };
	                                if (isset($valueFlightSegments['seats'])) { $xml->writeElementNS("v1", "seats", null , $valueFlightSegments['seats']); };
	                                if (isset($valueFlightSegments['bookingClass'])) { $xml->writeElementNS("v1", "bookingClass", null , $valueFlightSegments['bookingClass']); };
	                                if (isset($valueFlightSegments['filekey'])) { $xml->writeElementNS("v1", "filekey", null , $valueFlightSegments['filekey']); };
	                                if (isset($valueFlightSegments['state'])) { $xml->writeElementNS("v1", "state", null , $valueFlightSegments['state']); };
	                                if (isset($valueFlightSegments['remark'])) { $xml->writeElementNS("v1", "remark", null , $valueFlightSegments['remark']); };
	                                $xml->endElement(); // Ende flightSegment
	                            }
	                            $xml->endElement(); // Ende flightSegments
	                        }
	                        $xml->endElement(); // Ende flightDetails
	                    }
	
	                    // Hotel
	                    if ($valueReservationDetails['type'] == "hotelDetails") {
	                        $xml->startElementNS("v1", "hotelDetails", null );
	                        if (isset($valueReservationDetails['hotel']) && $valueReservationDetails['hotel'] > 0) {
	                            foreach ($valueReservationDetails['hotel'] as $keyHotel => $valueHotel) {
	                                $xml->startElementNS("v1", "hotel", null );
	                                if (isset($valueHotel['code'])) { $xml->writeAttributeNS("v1", "code", null , $valueHotel['code']); };
	                                if (isset($valueHotel['giataId'])) { $xml->writeAttributeNS("v1", "giataId", null , $valueHotel['giataId']); };
	
	                                if (isset($valueHotel['checkInDate'])) { $xml->writeElementNS("v1", "checkInDate", null , $valueHotel['checkInDate']); };
	                                if (isset($valueHotel['checkOutDate'])) { $xml->writeElementNS("v1", "checkOutDate", null , $valueHotel['checkOutDate']); };
	                                if (isset($valueHotel['roomType'])) { $xml->writeElementNS("v1", "roomType", null , $valueHotel['roomType']); };
	                                if (isset($valueHotel['board'])) { $xml->writeElementNS("v1", "board", null , $valueHotel['board']); };
	                                if (isset($valueHotel['transfer'])) { $xml->writeElementNS("v1", "transfer", null , $valueHotel['transfer']); };
	                                if (isset($valueHotel['additionalService'])) { $xml->writeElementNS("v1", "additionalService", null , $valueHotel['additionalService']); };
	                                if (isset($valueHotel['facilities'])) { $xml->writeElementNS("v1", "facilities", null , $valueHotel['facilities']); };
	                                if (isset($valueHotel['name'])) { $xml->writeElementNS("v1", "name", null , $valueHotel['name']); };
	                                if (isset($valueHotel['addressLine1'])) { $xml->writeElementNS("v1", "addressLine1", null , $valueHotel['addressLine1']); };
	                                if (isset($valueHotel['zipCode'])) { $xml->writeElementNS("v1", "zipCode", null , $valueHotel['zipCode']); };
	                                if (isset($valueHotel['place'])) { $xml->writeElementNS("v1", "place", null , $valueHotel['place']); };
	                                if (isset($valueHotel['country'])) { $xml->writeElementNS("v1", "country", null , $valueHotel['country']); };
	                                if (isset($valueHotel['remark'])) { $xml->writeElementNS("v1", "remark", null , $valueHotel['remark']); };
	                                if (isset($valueHotel['vatId'])) { $xml->writeElementNS("v1", "vatId", null , $valueHotel['vatId']); };
	                                if (isset($valueHotel['email'])) { $xml->writeElementNS("v1", "email", null , $valueHotel['email']); };
	
	                                $xml->endElement(); // Ende hotel
	                            }
	                        }
	                        $xml->endElement(); // Ende hotelDetails
	                    }
	
	                    // Mietwagen
	                    if ($valueReservationDetails['type'] == "rentalCarDetails") {
	                        $xml->startElementNS("v1", "rentalCarDetails", null );
	                        if (isset($valueReservationDetails['rentalCar']) && $valueReservationDetails['rentalCar'] > 0) {
	                            foreach ($valueReservationDetails['rentalCar'] as $keyCar => $valueCar) {
	                                $xml->startElementNS("v1", "rentalCar", null );
	                                if (isset($valueCar['pickupDate'])) { $xml->writeElementNS("v1", "pickupDate", null , $valueCar['pickupDate']); };
	                                $xml->startElementNS("v1", "pickupStation", null );
	                                if (isset($valueCar['pickupStation']['place'])) { $xml->writeElementNS("v1", "place", null , $valueCar['pickupStation']['place']); };
	                                if (isset($valueCar['pickupStation']['name'])) { $xml->writeElementNS("v1", "name", null , $valueCar['pickupStation']['name']); };
	                                $xml->endElement(); // Ende pickupStation
	
	                                if (isset($valueCar['handinDate'])) { $xml->writeElementNS("v1", "handinDate", null , $valueCar['handinDate']); };
	                                $xml->startElementNS("v1", "handinStation", null );
	                                if (isset($valueCar['handinStation']['place'])) { $xml->writeElementNS("v1", "place", null , $valueCar['handinStation']['place']); };
	                                if (isset($valueCar['handinStation']['name'])) { $xml->writeElementNS("v1", "name", null , $valueCar['handinStation']['name']); };
	                                $xml->endElement(); // Ende handinStation
	
	                                if (isset($valueHotel['car'])) { $xml->writeElementNS("v1", "car", null , $valueHotel['car']); };
	                                if (isset($valueHotel['category'])) { $xml->writeElementNS("v1", "category", null , $valueHotel['category']); };
	                                if (isset($valueHotel['remark'])) { $xml->writeElementNS("v1", "remark", null , $valueHotel['remark']); };
	
	                                $xml->endElement(); // Ende rentalCar
	                            }
	                        }
	                        $xml->endElement(); // Ende rentalCarDetails
	                    }
	
	                    // Bahn
	                    if ($valueReservationDetails['type'] == "railDetails") {
	                        $xml->startElementNS("v1", "railDetails", null );
	                        if (isset($valueReservationDetails['railSegments']) && $valueReservationDetails['railSegments'] > 0) {
	                            $xml->startElementNS("v1", "railSegments", null );
	                            foreach ($valueReservationDetails['railSegments'] as $keyRailSegments => $valueRailSegments) {
	                                $xml->startElementNS("v1", "railSegment", null );
	                                if (isset($valueRailSegments['departureStation'])) { $xml->writeElementNS("v1", "departureStation", null , $valueRailSegments['departureStation']); };
	                                if (isset($valueRailSegments['arrivalStation'])) { $xml->writeElementNS("v1", "arrivalStation", null , $valueRailSegments['arrivalStation']); };
	                                if (isset($valueRailSegments['departureTime'])) { $xml->writeElementNS("v1", "departureTime", null , $valueRailSegments['departureTime']); };
	                                if (isset($valueRailSegments['arrivalTime'])) { $xml->writeElementNS("v1", "arrivalTime", null , $valueRailSegments['arrivalTime']); };
	                                if (isset($valueRailSegments['bookingClass'])) { $xml->writeElementNS("v1", "bookingClass", null , $valueRailSegments['bookingClass']); };
	                                if (isset($valueRailSegments['tariff'])) { $xml->writeElementNS("v1", "tariff", null , $valueRailSegments['tariff']); };
	                                if (isset($valueRailSegments['trainNumber'])) { $xml->writeElementNS("v1", "trainNumber", null , $valueRailSegments['trainNumber']); };
	                                if (isset($valueRailSegments['coachNumber'])) { $xml->writeElementNS("v1", "coachNumber", null , $valueRailSegments['coachNumber']); };
	                                if (isset($valueRailSegments['cabinNumber'])) { $xml->writeElementNS("v1", "cabinNumber", null , $valueRailSegments['cabinNumber']); };
	                                if (isset($valueRailSegments['seats'])) { $xml->writeElementNS("v1", "seats", null , $valueRailSegments['seats']); };
	                                if (isset($valueRailSegments['departurePlatform'])) { $xml->writeElementNS("v1", "departurePlatform", null , $valueRailSegments['departurePlatform']); };
	                                if (isset($valueRailSegments['arrivalPlatform'])) { $xml->writeElementNS("v1", "arrivalPlatform", null , $valueRailSegments['arrivalPlatform']); };
	                                if (isset($valueRailSegments['documentNumber'])) { $xml->writeElementNS("v1", "documentNumber", null , $valueRailSegments['documentNumber']); };
	                                if (isset($valueRailSegments['remark'])) { $xml->writeElementNS("v1", "remark", null , $valueRailSegments['remark']); };
	                                $xml->endElement(); // Ende railSegment
	                            }
	                            $xml->endElement(); // Ende railSegments
	                        }
	                        $xml->endElement(); // Ende railDetails
	                    }
	
	                    // Versicherung
	                    if ($valueReservationDetails['type'] == "insuranceDetails") {
	                        $xml->startElementNS("v1", "insuranceDetails", null );
	                        if (isset($valueReservationDetails['insurancePlan']) && $valueReservationDetails['insurancePlan'] > 0) {
	                            foreach ($valueReservationDetails['insurancePlan'] as $keyInsurance => $valueInsurance) {
	                                $xml->startElementNS("v1", "insurancePlan", null );
	                                if (isset($valueInsurance['tariffCode'])) { $xml->writeElementNS("v1", "tariffCode", null , $valueInsurance['tariffCode']); };
	                                if (isset($valueInsurance['tariffDescription'])) { $xml->writeElementNS("v1", "tariffDescription", null , $valueInsurance['tariffDescription']); };
	                                if (isset($valueInsurance['policyNumber'])) { $xml->writeElementNS("v1", "policyNumber", null , $valueInsurance['policyNumber']); };
	                                if (isset($valueInsurance['coverage'])) { $xml->writeElementNS("v1", "coverage", null , $valueInsurance['coverage']); };
	
	                                if (isset($valueInsurance['coverage'])) { $xml->writeElementNS("v1", "coverage", null , $valueInsurance['coverage']); };
	                                $xml->startElementNS("v1", "coverage", null );
	                                if (isset($valueInsurance['currency'])) { $xml->writeElementNS("v1", "currency", null , $valueInsurance['currency']); };
	                                $xml->endElement(); // Ende coverage
	
	                                if (isset($valueInsurance['startDate'])) { $xml->writeElementNS("v1", "startDate", null , $valueInsurance['startDate']); };
	                                if (isset($valueInsurance['endDate'])) { $xml->writeElementNS("v1", "endDate", null , $valueInsurance['endDate']); };
	                                if (isset($valueInsurance['personCount'])) { $xml->writeElementNS("v1", "personCount", null , $valueInsurance['personCount']); };
	                                if (isset($valueInsurance['remark'])) { $xml->writeElementNS("v1", "remark", null , $valueInsurance['remark']); };
	
	                                $xml->endElement(); // Ende insurancePlan
	                            }
	                        }
	                        $xml->endElement(); // Ende insuranceDetails
	                    }
	
	                    // Freitext
	                    if ($valueReservationDetails['type'] == "freetextDetails") {
	                        $xml->startElementNS("v1", "freetextDetails", null );
	                        if (isset($valueReservationDetails['text'])) {
	                            $xml->startElementNS("v1", "freetext", null );
	                            $xml->writeElementNS("v1", "text", null , $valueReservationDetails['text']);
	                            $xml->endElement(); // Ende freetext
	                        };
	                        $xml->endElement(); // Ende freetextDetails
	                    }
	
	                    // Schiff
	                    if ($valueReservationDetails['type'] == "shipDetails") {
	                        $xml->startElementNS("v1", "shipDetails", null );
	                        if (isset($valueReservationDetails['ship']) && $valueReservationDetails['ship'] > 0) {
	                            foreach ($valueReservationDetails['ship'] as $keyShip => $valueShip) {
	                                $xml->startElementNS("v1", "ship", null );
	
	                                if (isset($valueShip['owner'])) { $xml->writeElementNS("v1", "owner", null , $valueShip['owner']); };
	                                if (isset($valueShip['addressLine1'])) { $xml->writeElementNS("v1", "addressLine1", null , $valueShip['addressLine1']); };
	                                if (isset($valueShip['addressLine2'])) { $xml->writeElementNS("v1", "addressLine2", null , $valueShip['addressLine2']); };
	                                if (isset($valueShip['zipCode'])) { $xml->writeElementNS("v1", "zipCode", null , $valueShip['zipCode']); };
	                                if (isset($valueShip['place'])) { $xml->writeElementNS("v1", "place", null , $valueShip['place']); };
	                                if (isset($valueShip['country'])) { $xml->writeElementNS("v1", "country", null , $valueShip['country']); };
	                                if (isset($valueShip['web'])) { $xml->writeElementNS("v1", "web", null , $valueShip['web']); };
	                                if (isset($valueShip['email'])) { $xml->writeElementNS("v1", "email", null , $valueShip['email']); };
	                                if (isset($valueShip['phone'])) { $xml->writeElementNS("v1", "phone", null , $valueShip['phone']); };
	                                if (isset($valueShip['name'])) { $xml->writeElementNS("v1", "name", null , $valueShip['name']); };
	                                if (isset($valueShip['checkInDate'])) { $xml->writeElementNS("v1", "checkInDate", null , $valueShip['checkInDate']); };
	                                if (isset($valueShip['checkOutDate'])) { $xml->writeElementNS("v1", "checkOutDate", null , $valueShip['checkOutDate']); };
	                                if (isset($valueShip['checkInHarbour'])) { $xml->writeElementNS("v1", "checkInHarbour", null , $valueShip['checkInHarbour']); };
	                                if (isset($valueShip['checkOutHarbour'])) { $xml->writeElementNS("v1", "checkOutHarbour", null , $valueShip['checkOutHarbour']); };
	                                if (isset($valueShip['checkInTerminal'])) { $xml->writeElementNS("v1", "checkInTerminal", null , $valueShip['checkInTerminal']); };
	                                if (isset($valueShip['checkOutTerminal'])) { $xml->writeElementNS("v1", "checkOutTerminal", null , $valueShip['checkOutTerminal']); };
	                                if (isset($valueShip['cabinType'])) { $xml->writeElementNS("v1", "cabinType", null , $valueShip['cabinType']); };
	                                if (isset($valueShip['cabinCategory'])) { $xml->writeElementNS("v1", "cabinCategory", null , $valueShip['cabinCategory']); };
	                                if (isset($valueShip['cabinDeck'])) { $xml->writeElementNS("v1", "cabinDeck", null , $valueShip['cabinDeck']); };
	                                if (isset($valueShip['cabinNumber'])) { $xml->writeElementNS("v1", "cabinNumber", null , $valueShip['cabinNumber']); };
	                                if (isset($valueShip['tableTime'])) { $xml->writeElementNS("v1", "tableTime", null , $valueShip['tableTime']); };
	                                if (isset($valueShip['tableSize'])) { $xml->writeElementNS("v1", "tableSize", null , $valueShip['tableSize']); };
	                                if (isset($valueShip['remark'])) { $xml->writeElementNS("v1", "remark", null , $valueShip['remark']); };
	
	                                if (isset($valueShip['manifests'])) {
	                                    $xml->startElementNS("v1", "manifests", null );
	                                    foreach ($valueShip['manifests'] as $keyManifest => $valueManifest) {
	                                        $xml->startElementNS("v1", "manifest", null );
	                                        if (isset($valueManifest['firstName'])) { $xml->writeElementNS("v1", "firstName", null , $valueManifest['firstName']); };
	                                        if (isset($valueManifest['lastName'])) { $xml->writeElementNS("v1", "lastName", null , $valueManifest['lastName']); };
	                                        if (isset($valueManifest['dateOfBirth'])) { $xml->writeElementNS("v1", "dateOfBirth", null , $valueManifest['dateOfBirth']); };
	                                        if (isset($valueManifest['placeOfBirth'])) { $xml->writeElementNS("v1", "placeOfBirth", null , $valueManifest['placeOfBirth']); };
	                                        if (isset($valueManifest['nationality'])) { $xml->writeElementNS("v1", "nationality", null , $valueManifest['nationality']); };
	                                        if (isset($valueManifest['passportNumber'])) { $xml->writeElementNS("v1", "passportNumber", null , $valueManifest['passportNumber']); };
	                                        if (isset($valueManifest['dateOfIssue'])) { $xml->writeElementNS("v1", "dateOfIssue", null , $valueManifest['dateOfIssue']); };
	                                        if (isset($valueManifest['placeOfIssue'])) { $xml->writeElementNS("v1", "placeOfIssue", null , $valueManifest['placeOfIssue']); };
	                                        if (isset($valueManifest['validUntil'])) { $xml->writeElementNS("v1", "validUntil", null , $valueManifest['validUntil']); };
	                                        if (isset($valueManifest['emergencyContactName'])) { $xml->writeElementNS("v1", "emergencyContactName", null , $valueManifest['emergencyContactName']); };
	                                        if (isset($valueManifest['emergencyContactPhone'])) { $xml->writeElementNS("v1", "emergencyContactPhone", null , $valueManifest['emergencyContactPhone']); };
	                                        $xml->endElement(); // Ende manifest
	                                    }
	                                    $xml->endElement(); // Ende manifests
	                                }
	
	                                if (isset($valueShip['vehicles'])) {
	                                    $xml->startElementNS("v1", "vehicles", null );
	                                    foreach ($valueShip['vehicles'] as $keyVehicle => $valueVehicle) {
	                                        $xml->startElementNS("v1", "vehicle", null );
	                                        if (isset($valueVehicle['licenseNumber'])) { $xml->writeElementNS("v1", "licenseNumber", null , $valueVehicle['licenseNumber']); };
	                                        if (isset($valueVehicle['length'])) { $xml->writeElementNS("v1", "length", null , $valueVehicle['length']); };
	                                        if (isset($valueVehicle['height'])) { $xml->writeElementNS("v1", "height", null , $valueVehicle['height']); };
	                                        if (isset($valueVehicle['width'])) { $xml->writeElementNS("v1", "width", null , $valueVehicle['width']); };
	                                        if (isset($valueVehicle['kindOf'])) { $xml->writeElementNS("v1", "kindOf", null , $valueVehicle['kindOf']); };
	                                        if (isset($valueVehicle['type'])) { $xml->writeElementNS("v1", "type", null , $valueVehicle['type']); };
	                                        $xml->endElement(); // Ende vehicle
	                                    }
	                                    $xml->endElement(); // Ende vehicles
	                                }
	
	                                if (isset($valueShip['routes'])) {
	                                    $xml->startElementNS("v1", "routes", null );
	                                    foreach ($valueShip['routes'] as $keyRoute => $valueRoute) {
	                                        $xml->startElementNS("v1", "route", null );
	                                        if (isset($valueRoute['days'])) { $xml->writeElementNS("v1", "days", null , $valueRoute['days']); };
	                                        if (isset($valueRoute['departureTime'])) { $xml->writeElementNS("v1", "departureTime", null , $valueRoute['departureTime']); };
	                                        if (isset($valueRoute['arrivalTime'])) { $xml->writeElementNS("v1", "arrivalTime", null , $valueRoute['arrivalTime']); };
	                                        if (isset($valueRoute['text'])) { $xml->writeElementNS("v1", "text", null , $valueRoute['text']); };
	                                        if (isset($valueRoute['geoData'])) { $xml->writeElementNS("v1", "geoData", null , $valueRoute['geoData']); };
	                                        $xml->endElement(); // Ende route
	                                    }
	                                    $xml->endElement(); // Ende routes
	                                }
	
	                                $xml->endElement(); // Ende ship
	                            }
	                        }
	                        $xml->endElement(); // Ende shipDetails
	                    }
	
	                    // Golf
	                    if ($valueReservationDetails['type'] == "golfDetails") {
	                        $xml->startElementNS("v1", "golfDetails", null );
	                        if (isset($valueReservationDetails['golfDetails']) && $valueReservationDetails['golfDetails'] > 0) {
	                            foreach ($valueReservationDetails['golfDetails'] as $keyGolf => $valueGolf) {
	                                $xml->startElementNS("v1", "golf", null );
	                                if (isset($valueGolf['course'])) { $xml->writeElementNS("v1", "course", null , $valueGolf['course']); };
	                                if (isset($valueGolf['addressLine1'])) { $xml->writeElementNS("v1", "addressLine1", null , $valueGolf['addressLine1']); };
	                                if (isset($valueGolf['addressLine2'])) { $xml->writeElementNS("v1", "addressLine2", null , $valueGolf['addressLine2']); };
	                                if (isset($valueGolf['zipCode'])) { $xml->writeElementNS("v1", "zipCode", null , $valueGolf['zipCode']); };
	                                if (isset($valueGolf['place'])) { $xml->writeElementNS("v1", "place", null , $valueGolf['place']); };
	                                if (isset($valueGolf['country'])) { $xml->writeElementNS("v1", "country", null , $valueGolf['country']); };
	                                if (isset($valueGolf['web'])) { $xml->writeElementNS("v1", "web", null , $valueGolf['web']); };
	                                if (isset($valueGolf['email'])) { $xml->writeElementNS("v1", "email", null , $valueGolf['email']); };
	                                if (isset($valueGolf['phone'])) { $xml->writeElementNS("v1", "phone", null , $valueGolf['phone']); };
	                                if (isset($valueGolf['remark'])) { $xml->writeElementNS("v1", "remark", null , $valueGolf['remark']); };
	
	                                if (isset($valueGolf['golfPlays'])) {
	                                    foreach ($valueGolf['golfPlays'] as $keyGolfPlays => $valueGolfPlays) {
	                                        $xml->startElementNS("v1", "golfPlay", null );
	                                        if (isset($valueGolfPlays['playDate'])) { $xml->writeElementNS("v1", "playDate", null , $valueGolfPlays['playDate']); };
	                                        if (isset($valueGolfPlays['pickUpTime'])) { $xml->writeElementNS("v1", "pickUpTime", null , $valueGolfPlays['pickUpTime']); };
	                                        if (isset($valueGolfPlays['pickUpPlace'])) { $xml->writeElementNS("v1", "pickUpPlace", null , $valueGolfPlays['pickUpPlace']); };
	                                        if (isset($valueGolfPlays['playDate'])) { $xml->writeElementNS("v1", "playDate", null , $valueGolfPlays['playDate']); };
	                                        if (isset($valueGolfPlays['playDate'])) { $xml->writeElementNS("v1", "playDate", null , $valueGolfPlays['playDate']); };
	                                        $xml->endElement(); // Ende golfPlay
	                                    }
	                                    	
	                                    $xml->endElement(); // Ende golf
	                                }
	                            }
	                            $xml->endElement(); // Ende golfDetails
	                        }
	
	                    }
	                    	
	                    	
	                }
	                $xml->endElement(); // Ende details
	            }
	
	            $xml->endElement(); // Ende reservation
	        }
	    } // Ende if reservation
	
	    $xml->endElement(); //End ImportableReservation
	
	    //echo htmlentities($xml->outputMemory());
	
	    $xml1 = $this->doRequest($clientUrl, 'POST', array(), array(), array(), $xml->outputMemory());
	
	    return $xml1;
	}
}