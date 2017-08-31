<?php

class HippieStation_BYONDLink_ControllerPublic_Thread extends XFCP_HippieStation_BYONDLink_ControllerPublic_Thread {

    public function actionReply() {
        $visitor     = XenForo_Visitor::getInstance()->toArray();
        $currentCkey = (array_key_exists("ckey", $visitor['customFields']) ? $visitor['customFields']['ckey'] : "");

        if ($currentCkey === ""){
            $opts = XenForo_Application::get('options');
            $webAuthServer = $opts->BYONDLinkWebAuthServer;
            $errorText = $opts->BYONDLinkErrorMessage;
            $errorMsg = sprintf($errorText, $webAuthServer);
            throw new XenForo_Exception($errorMsg, true);
        }

        return parent::actionReply();
    }

}