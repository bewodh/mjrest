<?php 
namespace Bewotec\Rest\Client;

use Bewotec\Rest\Client\Baseclient as BaseClient;

class Agency extends BaseClient {
    public function getA($webcode=0)
    {
        $recource = "/service/mobile/agency/folder/".$webcode;
        $clientUrl = $this->getClientUri($recource);

        $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true, false, false, "Agentur ID");

        return $xml;
    }
    /*
	 * mobile: Agentur Daten laden
	 */
	public function getAgency($webcode=0)
	{
	    if($webcode != "undefined") {
    	    $recource = "/service/mobile/agency/webcode/".$webcode;
    	    $clientUrl = $this->getClientUri($recource);

    	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true, false, false, "Agentur Details");
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

	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true, false, false, "Agentur ID");

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

	/*
	 * Globale Angebote laden
	 */
	public function getAgencyOffers($webcode=0)
	{
	    $recource = "/service/agency/".$webcode."/offers";
	    $clientUrl = $this->getClientUri($recource);

	    $xml = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false, true);

	    return $xml;
	}

	/*
	 * Logo der Unit abrufen
	 */
	public function cmsLogo($unit=0)
	{
	    $resource = "/service/cms/logo?agencyId=".$unit;
	    $clientUrl = $this->getClientUri($resource);

	    $body = $this->doRequest($clientUrl, 'GET', array(), array(), array(), null, false);

	    if ($body != "") {
	        $im = imagecreatefromstring( $body );
	    } else {
	        $im = FALSE;
	    }

	    if ($im !== false) {
	        ob_start();
	        // generate the byte stream
	        imagejpeg($im);
	        // and finally retrieve the byte stream
	        $rawImageBytes = ob_get_clean();
	        //echo "<img src='data:image/jpeg;base64," . base64_encode( $rawImageBytes ) . "' />";
	    }
	    else {
	        $rawImageBytes = "";
	    }

	    $rawImageBytes = base64_encode($rawImageBytes);

	    return $rawImageBytes;
	}
    
}