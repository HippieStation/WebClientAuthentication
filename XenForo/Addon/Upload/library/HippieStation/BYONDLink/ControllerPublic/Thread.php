<?php

class HippieStation_BYONDLink_ControllerPublic_Thread extends XFCP_HippieStation_BYONDLink_ControllerPublic_Thread {

    public function actionReply() {
        $visitor     = XenForo_Visitor::getInstance()->toArray();
        $currentCkey = (array_key_exists("ckey", $visitor['customFields']) ? $visitor['customFields']['ckey'] : "");

        if ($currentCkey === ""){
            $opts = XenForo_Application::get('options');
            $webAuthServer = $opts->BYONDLinkWebAuthServer;
            $errorMsg = sprintf("Before you can perform certain actions on this forum you must link your BYOND account to your forum account. Click <a href='https://secure.byond.com/login.cgi?login=1;noscript=1;url=http://www.byond.com/play/%s'>this link</a> to link your account", $webAuthServer);
            throw new XenForo_Exception($errorMsg, true);
        }

        return parent::actionReply();
    }

}