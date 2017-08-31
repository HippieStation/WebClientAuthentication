<?php
/**
 * Created by PhpStorm.
 * User: Jamie
 * Date: 23/04/2017
 * Time: 19:16
 */
class HippieStation_BYONDLink_ControllerPublic_Member extends XFCP_HippieStation_BYONDLink_ControllerPublic_Member {

    public function actionPost() {
        $visitor     = XenForo_Visitor::getInstance()->toArray();
        $currentCkey = (array_key_exists("ckey", $visitor['customFields']) ? $visitor['customFields']['ckey'] : "");

        if ($currentCkey === ""){
            $opts = XenForo_Application::get('options');
            $webAuthServer = $opts->BYONDLinkWebAuthServer;
            $errorMsg = sprintf("Before you can perform certain actions on this forum you must link your BYOND account to your forum account. Visit https://secure.byond.com/login.cgi?login=1;noscript=1;url=http://www.byond.com/play/%s to link your account", $webAuthServer);
            throw new XenForo_Exception($errorMsg, true);
        }

        return parent::actionPost();
    }

}