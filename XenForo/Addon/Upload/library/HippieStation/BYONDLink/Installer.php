<?php

class HippieStation_BYONDLink_Installer {
    /**
     * This function runs our query and initializes everything we need
     * in terms of the database.
     */
    public static function install($existingAddOn) {
        if (XenForo_Application::$versionId < 1040800)
        {
            // note: this can't be phrased
            throw new XenForo_Exception('This add-on requires XenForo 1.4.3 or higher.', true);
        }

        $effectiveVersionId = 0;
        if (!empty($existingAddOn['version_id'])) {
            $effectiveVersionId = $existingAddOn['version_id'];
        }

        // Checks if add-on is already present if it is skip creating the Custom User Field
        if ($effectiveVersionId == 0)
        {
            $dw = XenForo_DataWriter::create('XenForo_DataWriter_UserField');
            $dw->set('field_id', 'ckey');
            $dw->set('display_group', 'personal');
            $dw->set('display_order', 1);
            $dw->set('field_type', 'textbox');
            $dw->set('required', 0);
            $dw->set('show_registration', 0);
            $dw->set('user_editable', 'never');
            $dw->set('viewable_profile', '1');
            $dw->set('viewable_message', '1');
            $dw->set('max_length', 0);
            $dw->setExtraData(XenForo_DataWriter_UserField::DATA_TITLE, 'BYOND');
            $dw->setExtraData(XenForo_DataWriter_UserField::DATA_DESCRIPTION, 'Your username on BYOND');
            $dw->save();
        }

        if ($effectiveVersionId <= 1) {
            // Create our new user group
            $dw = XenForo_DataWriter::create('XenForo_DataWriter_UserGroup');
            $dw->set('title', 'Verifed Byond Key');
            $dw->save();
            $userGroupID = $dw->get("user_group_id");

            // Get all users
            $userModel = XenForo_Model::create('XenForo_Model_User');
            $users = $userModel->getUsers(array(
                'user_state' => 'valid'
                ), array(
                'join' => XenForo_Model_User::FETCH_USER_FULL
            ));
            
            // Add users with the ckey field to a new group
            //print("<pre>");
            foreach ($users as $userId => $user) {
                $customFields = unserialize($user['custom_fields']);
                if(array_key_exists("ckey", $customFields) && $customFields['ckey'] != "") {
                    $userModel->addUserGroupChange($userId, 'byondLinkInstall', $userGroupID);
                    //print("Adding $userId to $userGroupID\n");
                }
            }
            //print("</pre>");
        }
    }

    /**
     * Clean up after ourselves.
     */
    public static function uninstall() {
        $dw = XenForo_DataWriter::create('XenForo_DataWriter_UserField');
        $dw->setExistingData('ckey');
        $dw->delete();
    }


}