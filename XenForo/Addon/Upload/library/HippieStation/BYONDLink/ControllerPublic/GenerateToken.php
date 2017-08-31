<?php

class HippieStation_BYONDLink_ControllerPublic_GenerateToken extends XenForo_ControllerPublic_Abstract
{
    public function renderJson()
    {
        return json_encode($this->_params);
    }

    private function throwError($errorMsg){
        $params['has_error'] = true;
        $params['error']     = $errorMsg;
        return $this->responseView('HippieStation_BYONDLink_ViewPublic_VerifyToken', 'BYONDLink_VerifyToken', $params);
    }

    public function actionIndex()
    {
        $this->_routeMatch->setResponseType('raw');

        $opts = XenForo_Application::get('options');
        $ipStr = $opts->BYONDLinkServers;
        $ipStr = str_replace(' ', '', $ipStr);

        $hmacKey = $opts->BYONDLinkHMACKey;

        $ips = explode(',', $ipStr);
        if (!in_array($_SERVER['REMOTE_ADDR'], $ips)) {
            die("This IP is not in the allowed list.");
        }

        $ckey = $this->_input->filterSingle('ckey', XenForo_Input::STRING);
        if ($ckey === "") {
            die("No ckey provided.");
        }

        $bodyObj = array(
            "ckey" => $ckey,
            "time" => time(),
        );
        $body = json_encode($bodyObj);
        $hash = hash_hmac('sha256', $body, $hmacKey);
        $data = $hash . bin2hex($body);
        return $this->responseView('HippieStation_BYONDLink_ViewPublic_Text', 'content_template', [$data]);
    }
}