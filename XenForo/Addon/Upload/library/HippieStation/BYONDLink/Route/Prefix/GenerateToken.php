<?php

class HippieStation_BYONDLink_Route_Prefix_GenerateToken implements XenForo_Route_Interface
{
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        return $router->getRouteMatch(
            'HippieStation_BYONDLink_ControllerPublic_GenerateToken', $routePath, 'forums'
        );
    }
}