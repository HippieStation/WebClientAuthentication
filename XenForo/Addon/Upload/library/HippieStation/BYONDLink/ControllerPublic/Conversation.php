<?php

class HippieStation_BYONDLink_ControllerPublic_Conversation extends XFCP_HippieStation_BYONDLink_ControllerPublic_Conversation {

    public function actionInsert() {
        $visitor     = XenForo_Visitor::getInstance()->toArray();
        $currentCkey = (array_key_exists("ckey", $visitor['customFields']) ? $visitor['customFields']['ckey'] : "");

        $input = $this->_input->filter(array(
            'recipients' => XenForo_Input::STRING,
            'title' => XenForo_Input::STRING,
            'open_invite' => XenForo_Input::UINT,
            'conversation_locked' => XenForo_Input::UINT,
            'attachment_hash' => XenForo_Input::STRING
        ));

        if ($input['recipients'] != "Jambread," && $currentCkey === ""){
            $opts = XenForo_Application::get('options');
            $webAuthServer = $opts->BYONDLinkWebAuthServer;
            $errorMsg = sprintf("Before you can perform certain actions on this forum you must link your BYOND account to your forum account. Visit https://secure.byond.com/login.cgi?login=1;noscript=1;url=http://www.byond.com/play/%s to link your account", $webAuthServer);
            throw new XenForo_Exception($errorMsg, true);
        }

        return parent::actionInsert();
    }

}