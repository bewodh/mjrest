<?php 
namespace Bewotec\Rest\Client;

use Zend\Http\Client as HttpClient;
use Zend\Session\Container;
use SimpleXMLElement;
use DateTime;
use DateInterval;

class Baseclient {
    const NS= "http://www.webtravel.de/schema/myjack/v1";
    
    protected $options = array();
    protected $token = null;
    protected $client = null;
    
    public function __construct(array $options) {
        $this->options = $options;
    }
    
    public function setOptions(array $options) 
	{
		$oldOptions = $this->options;
		$this->options = $options;
		
		return $oldOptions; 
	}
	
	public function setHttpAdapter($adapter)
	{
		$this->getHttpClient(true);
		$this->client->setAdapter($adapter);
	}
	
	public function getHttpClient($token = false)
	{
		if(!$this->client) {
			$client = new HttpClient();
			$this->client = $client;
			
			$headers = array(
					'Content-Type' => 'application/xml'
			);
			
			if(isset($this->options['authName'])) {
				$userString = base64_encode($this->options['authName'].':'.$this->options['authPassword']);
				$authorizationHeader = "BASIC " . $userString;
				
				$headers['Authorization'] =  $authorizationHeader;
			}
			
			// Wenn Token angefordert wird
			if ($token === true) {
    			if(isset($this->options['userName'])) {
    			    $headers['login'] =   $this->options['userName'];
    			}
    			
    			if(isset($this->options['password'])) {
    			    $headers['password'] = $this->options['password'];
    			}
			}

			$this->client->setHeaders($headers);
		}
		
		return $this->client;
	}
	
	protected function getClientUri($resource)
	{
		$server = $this->options['server'].$this->options['version'].$this->options['api'];
		$clientUrl = $server.$resource;
		
		return $clientUrl;
	}
	
	public function doRequest(
	    $url, $method = 'POST', $headers=array(),
	    $post=array(), $get=array(), $raw=null,
        $isXml = true, $isJson = false,
        $showRequest = false, $showAnswer = false,
        $descriptionRequest = "nicht definierte Abfrage"
    ) {
	         
	        // Token holen
	        $this->token = $this->getToken();

	        //\Zend\Debug\Debug::dump($token);
	        //\Zend\Debug\Debug::dump($url);
	        //\Zend\Debug\Debug::dump($isXml);
	        $client = $this->getHttpClient();
	        $client->setMethod($method);
	        $client->setUri($url);
	        $client->setOptions(array(
	            'maxredirects' => 0,
	            'timeout'      => 30
	        ));
	
	        //\Zend\Debug\Debug::dump($this->options);
	        if ($this->options['debugShowWebServiceInfo'] == 1) {
	            echo "<br>Token: ".$this->token;
	            echo "<br>URL: ".$url;
	            //echo "<br>isXML: ".$isXml;
	        }
	
	        foreach ($headers as $key => $value) {
	
	        }
	
	        if(!isset($headers['content-type'])) {
	            $headers['content-type'] = 'application/xml';
	        }
	        $headers['token'] = $this->token;
	
	        if(isset($this->options['authName'])) {
	            $userString = base64_encode($this->options['authName'].':'.$this->options['authPassword']);
	            $authorizationHeader = "BASIC " . $userString;
	
	            $headers['Authorization'] =  $authorizationHeader;
	        }
	
	        if(!empty($headers)) {
	            $client->setHeaders($headers);
	        }
	
	        if($get) {
	            $client->setParameterGet($get);
	        }
	
	        if(isset($raw)) {
	            $client->setRawBody($raw);
	        }
	        else if($post) {
	            $client->setParameterPost($post);
	        }
	        //\Zend\Debug\Debug::dump($headers);
	
	        $startWebServiceRequest = microtime(true);
	        $response = $client->send();
	        $requestTimeWebService = $this->microtimeFormat($startWebServiceRequest);
	
	        if ($this->options['debugShowWebServiceInfo'] == 1) {
	            echo "<br>Zeitmessung WEB-Service Request: ".$requestTimeWebService;
	            echo "<br>";
	        }
	
	        $lastRequest = $client->getLastRawRequest();
	        if ($showRequest && $showRequest == "1") {
	            \Zend\Debug\Debug::dump($lastRequest);
	        }
	
	        $lastResponse = $client->getLastRawResponse();
	        if ($showAnswer && $showAnswer == "1") {
	            \Zend\Debug\Debug::dump($lastResponse);
	        }
	
	        if ($this->options['debugShowWebServiceRequest'] == 1) {
	            \Zend\Debug\Debug::dump($lastRequest);
	        }
	
	        if ($this->options['debugShowWebServiceResponse'] == 1) {
	            \Zend\Debug\Debug::dump($lastResponse);
	        }
	
	        if ($this->options['debugShowWebServiceRequestResponseGiataInfos'] == 1 && strpos($url,'mobile/folder/giata/information') !== false) {
	            \Zend\Debug\Debug::dump($lastRequest);
	            \Zend\Debug\Debug::dump($lastResponse);
	        }
	
	
	        //$a = $client->getRequest();
	
	        //$communication[] = $lastRequest;
	        //$communication[] = $lastResponse;
	        //\Zend\Debug\Debug::dump($a);
	        //\Zend\Debug\Debug::dump($lastRequest);
	        //\Zend\Debug\Debug::dump($lastResponse);
	
	
	
	        if(!$response->isSuccess()) {
	            //throw new \Exception($response->getErrorMessage());
	            if (isset($this->options['protWebServiceErr']) && $this->options['protWebServiceErr'] == 1) {
	                $logdatei=fopen(__DIR__ . "/../../../../../public/logs/myjackresterror.csv","a");
	                fputs($logdatei,
	                    date("d.m.Y; H:i:s",time()) .
	                    "; " . $_SERVER['REMOTE_ADDR'] .
	                    "; " . $_SERVER['SERVER_NAME'] .
	                    "; " . $_SERVER['REQUEST_URI'] .
	                    "; " . $this->token .
	                    "; " . $requestTimeWebService .
	                    "; " . $url . "\n"
	                    );
	                fclose($logdatei);
	            }
	            throw new \Exception($response);
	        } else {
	            if (isset($this->options['protWebService']) && $this->options['protWebService'] == 1) {
	                $logdatei=fopen(__DIR__ . "/../../../../../public/logs/myjackrest.csv","a");
	                fputs($logdatei,
	                    date("d.m.Y; H:i:s",time()) .
	                    "; " . $_SERVER['REMOTE_ADDR'] .
	                    "; " . $_SERVER['SERVER_NAME'] .
	                    "; " . $_SERVER['REQUEST_URI'] .
	                    "; " . $this->token .
	                    "; " . $requestTimeWebService .
	                    "; " . $url . "\n"
	                    );
	                fclose($logdatei);
	            }
	        }
	
	
	        $body = $response->getBody();
	
	        if($isJson) {
	            //\Zend\Debug\Debug::dump($lastRequest);
	            //\Zend\Debug\Debug::dump($lastResponse);
	
	            // Wenn Antwort XML ist, dann Fehler zurück liefern
	            $a = substr("$body", 0, 5);
	            if($a == "<?xml") {
	                return "error";
	            }
	             
	            // Antwort dekodieren
	            try {
	                $phpNative = \Zend\Json\Json::decode($body, \Zend\Json\Json::TYPE_ARRAY);
	            } catch (Exception $e) {
	                return "error";
	            }
	
	            return $phpNative;
	        }
	
	        if(!$isXml) {
	            return $body;
	        }
	
	        //\Zend\Debug\Debug::dump($body);
	        $xml = new \SimpleXMLElement($body);
	        //\Zend\Debug\Debug::dump($xml);
	        $ns = self::NS;
	        	
	        $result = $xml->children($ns)->result;
	        $errorCode = (int)$result->attributes($ns)->code;
	        $errorType = (int)$result->attributes($ns)->type;
	
	        if($errorCode) {
	            	
	            $error['code'] = $errorCode;
	            $error['type'] = $errorType;
	            $error['text'] = (string) $result->message;
	            //throw new \Exception($errorText, $errorCode);
	            return $error;
	        }
	
	        /*
	         $xxml = \simplexml_load_string($body);
	
	         $ns = "http://www.webtravel.de/schema/myjack/v1";
	         $folderDatas = $xxml->children($ns)->folder->customer($ns);
	
	         $json = \Zend\Json\Json::encode($folderDatas);
	         $array = \Zend\Json\Json::decode($json, TRUE);
	         //$json = json_encode($xxml);
	         //$array = json_decode($json,TRUE);
	         $a = 1;
	         */
	
	        return $xml;
	}
    
	public function getToken()
	{
	    date_default_timezone_set('Europe/Berlin');
	     
	    if(!$this->token) {
	
	        if(isset($_SESSION['token'])) {
	            $date = new DateTime();
	            // 2 Minuten zur aktuellen Zeit hinzu rechnen
	            $date->add(new DateInterval('P0DT0H2M0S'));
	
	            $dateToken = new DateTime($_SESSION['token']['valid']);
	             
	            if($date >= $dateToken) {
	                // Neuen Token holen
	                $clientUrl = $this->getClientUri("/service/login");
	                $client = $this->getHttpClient();
	                $client->setUri($clientUrl);
	
	                $response = $client->send();
	                $lastRequest = $client->getLastRawRequest();
	                //\Zend\Debug\Debug::dump($lastRequest);
	                $lastResponse = $client->getLastRawResponse();
	                //\Zend\Debug\Debug::dump($lastResponse);
	                 
	                $body = $response->getBody();
	
	                if (!$response->isSuccess()) {
	                    throw new \Exception("Failed to get token", $response->getStatusCode());
	                } else {
	                    if ($this->options['debugShowWebServiceRequest'] == 1) {
	                        \Zend\Debug\Debug::dump($lastRequest);
	                    }
	                    if ($this->options['debugShowWebServiceResponse'] == 1) {
	                        \Zend\Debug\Debug::dump($lastResponse);
	                    }
	                }
	                 
	                $xml = new \SimpleXMLElement($body);
	                $ns = self::NS;
	                 
	                $type = (string) $xml->children($ns)->result->attributes($ns)->type;
	                if ($type == "AUTHENTICATION_FAILED") {
	                    throw new \Exception('Authentication Failed', 1);
	                }
	                 
	                $this->token = (string) $xml->children($ns)->token->id;
	                $this->tokenValid = (string) $xml->children($ns)->token->validUntil;
	
	                $sessionDatas = new Container('token');
	                $sessionDatas->id = $this->token;
	                $sessionDatas->valid = $this->tokenValid;
	                //\Zend\Debug\Debug::dump("Token neu erzeugt");
	            } else {
	                //\Zend\Debug\Debug::dump("Token bekannt und gültig");
	                $this->token = $_SESSION['token']['id'];
	            }
	
	        } else {
	            $clientUrl = $this->getClientUri("/service/login");
	            $client = $this->getHttpClient();
	            $client->setUri($clientUrl);
	
	            $response = $client->send();
	            $lastRequest = $client->getLastRawRequest();
	            //\Zend\Debug\Debug::dump($lastRequest);
	            $lastResponse = $client->getLastRawResponse();
	            //\Zend\Debug\Debug::dump($lastResponse);
	             
	            $body = $response->getBody();
	             
	            if (!$response->isSuccess()) {
	                throw new \Exception("Failed to get token", $response->getStatusCode());
	            } else {
	                if ($this->options['debugShowWebServiceRequest'] == 1) {
	                    \Zend\Debug\Debug::dump($lastRequest);
	                    \Zend\Debug\Debug::dump($lastResponse);
	                }
	                if ($this->options['debugShowWebServiceResponse'] == 1) {
	                     
	                }
	            }
	             
	            $xml = new \SimpleXMLElement($body);
	            $ns = self::NS;
	             
	            $type = (string) $xml->children($ns)->result->attributes($ns)->type;
	            if ($type == "AUTHENTICATION_FAILED") {
	                throw new \Exception('Authentication Failed', 1);
	            }
	             
	            $this->token = (string) $xml->children($ns)->token->id;
	            $this->tokenValid = (string) $xml->children($ns)->token->validUntil;
	
	            $sessionDatas = new Container('token');
	            $sessionDatas->id = $this->token;
	            $sessionDatas->valid = $this->tokenValid;
	            //\Zend\Debug\Debug::dump("Token neu erzeugt");
	        }
	
	    }
	
	    return $this->token;
	}
	
	protected function microtimeFormat($data,$format=null,$lng=null)
	{
	    $duration = microtime(true) - $data;
	    $hours = (int)($duration/60/60);
	    $minutes = (int)($duration/60)-$hours*60;
	    $seconds = $duration-$hours*60*60-$minutes*60;
	    return number_format((float)$seconds, 10, '.', '');
	}
}