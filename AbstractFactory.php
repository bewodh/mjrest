<?php
namespace Bewotec\Rest;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

class AbstractFactory implements AbstractFactoryInterface
{

    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        // Search for service: ‘X’ -> Bewotec\Rest\Client\X
        if (class_exists('Bewotec\Rest\Client\\' . ucfirst(strtolower($requestedName)))) {
            return true;
        }
        
        return false;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $serviceLocator->get('config');
        $clientName = 'Bewotec\Rest\Client\\' . ucfirst(strtolower($requestedName));
        
        $rest = new $clientName($config['myjack']);
        if ($serviceLocator->has('httpadapter')) {
            $rest->setHttpAdapter($serviceLocator->get('httpadapter'));
        }
        
        return $rest;
    }
}