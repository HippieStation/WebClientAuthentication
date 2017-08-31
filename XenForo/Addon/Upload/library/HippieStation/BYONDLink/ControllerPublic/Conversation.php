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

        if ($currentCkey === "" && ($input['recipients'] != "Jambread," && $input['recipients'] != "Jambread" && $input['recipients'] != "Jambread, ")){
            $opts = XenForo_Application::get('options');
            $webAuthServer = $opts->BYONDLinkWebAuthServer;
            $errorText = $opts->BYONDLinkErrorMessage;
            $errorMsg = sprintf($errorText, $webAuthServer);
            throw new XenForo_Exception($errorMsg, true);
        }

        return parent::actionInsert();
    }

}