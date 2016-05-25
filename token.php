<?php 
namespace Myjack\Rest;

use DateTime;

class Token {
    
    public function get()
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
}