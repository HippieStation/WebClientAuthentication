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
            $errorText = $opts->BYONDLinkErrorMessage;
            $errorMsg = sprintf($errorText, $webAuthServer);
            throw new XenForo_Exception($errorMsg, true);
        }

        return parent::actionPost();
    }

}