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

        // Checks if add-on is already present if it is skip creating the Custom User Field
        if (!$existingAddOn)
        {
            $dw = XenForo_DataWriter::create('XenForo_DataWriter_UserField');
            //Twitch
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