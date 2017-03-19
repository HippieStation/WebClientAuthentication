<?php
class HippieStation_BYONDLink_main
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

    public static function verifyToken(XenForo_ControllerPublic_Abstract $controller, XenForo_ControllerResponse_Abstract $response)
    {
        $userModel = $controller->getModelFromCache('XenForo_Model_User');

        XenForo_Session::startPublicSession();
        $visitor     = XenForo_Visitor::getInstance()->toArray();
        $currentCkey = (array_key_exists("ckey", $visitor['customFields']) ? $visitor['customFields']['ckey'] : "");

        $response->templateName = 'byondlink_verifyToken';

        if ($visitor['user_id'] == 0) {
            $response->params['has_error'] = true;
            $response->params['error']     = "You need to be logged into the forum to use this";
            return;
        }

        if ($currentCkey != "") {
            $response->params['has_error'] = true;
            $response->params['error']     = "You've already linked a BYOND key to this account";
            return;
        }

        if (!isset($_GET['token'])) {
            $response->params['has_error'] = true;
            $response->params['error']     = "Invalid request";
            return;
        }

        $token        = $_GET['token'];
        $providedHash = substr($token, 0, 64); // SHA256 = 64
        $body         = substr($token, 64, strlen($token));
        $body         = hex2bin($body);
        $correctHash  = hash_hmac('sha256', $body, "INSERT HMAC KEY HERE");

        if (!HippieStation_BYONDLink_main::hash_compare($providedHash, $correctHash)) {
            $response->params['has_error'] = true;
            $response->params['error']     = "Invalid token";
            return;
        }

        $bodyObj = json_decode($body);
        $time    = $bodyObj->time;
        $ckey    = $bodyObj->ckey;
        if (time() - $time > 15) {
            $response->params['has_error'] = true;
            $response->params['error']     = "Token has expired";
            return;
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

        $response->params['ckey'] = $ckey;
    }
}
