<?php

class HippieStation_BYONDLink_ControllerPublic_VerifyToken extends XenForo_ControllerPublic_Abstract
{
    private static function hash_compare($a, $b)
    {
        if (!is_string($a) || !is_string($b)) {
            return false;
        }
        $len = strlen($a);
        if ($len !== strlen($b)) {
            return false;
        }
        $status = 0;
        for ($i = 0; $i < $len; $i++) {
            $status |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $status === 0;
    }

    private function throwError($errorMsg){
        $params['has_error'] = true;
        $params['error']     = $errorMsg;
        return $this->responseView('HippieStation_BYONDLink_ViewPublic_VerifyToken', 'BYONDLink_VerifyToken', $params);
    }

    public function actionIndex()
    {
        XenForo_Session::startPublicSession();
        $userModel = $this->getModelFromCache('XenForo_Model_User');
        $visitor     = XenForo_Visitor::getInstance()->toArray();
        $currentCkey = (array_key_exists("ckey", $visitor['customFields']) ? $visitor['customFields']['ckey'] : "");
        $token = $this->_input->filterSingle('token', XenForo_Input::STRING);

        $opts = XenForo_Application::get('options');
        $hmacKey = $opts->BYONDLinkHMACKey;

        if ($visitor['user_id'] == 0) {
            return $this->throwError("\"You need to be logged into the forum to use this");
        }

        if ($currentCkey != "") {
            return $this->throwError("\"You've already linked a BYOND key to this account");
        }

        if ($token === "") {
            return $this->throwError("Invalid request");
        }

        $providedHash = substr($token, 0, 64); // SHA256 = 64
        $body         = substr($token, 64, strlen($token));
        $body         = hex2bin($body);
        $correctHash  = hash_hmac('sha256', $body, $hmacKey);

        if (!$this->hash_compare($providedHash, $correctHash)) {
            return $this->throwError("Invalid token");
        }

        $bodyObj = json_decode($body);
        $time    = $bodyObj->time;
        $ckey    = $bodyObj->ckey;
        if (time() - $time > 15) {
            return $this->throwError("Token has expired");
        }

        $user = $userModel->getUserById($visitor['user_id']);
        $dw = XenForo_DataWriter::create('XenForo_DataWriter_User');
        $dw->setExistingData($user);
        $dw->setOption(XenForo_DataWriter_User::OPTION_ADMIN_EDIT, true);
        $dw->setCustomFields(array(
            'ckey' => $ckey
        ));
        $dw->save();
        $dw->rebuildCustomFields();

        $params = [];
        $params['ckey'] = $ckey;
        return $this->responseView('HippieStation_BYONDLink_ViewPublic_VerifyToken', 'BYONDLink_VerifyToken', $params);
    }
}