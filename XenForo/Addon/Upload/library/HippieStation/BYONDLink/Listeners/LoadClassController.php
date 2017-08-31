<?php
class HippieStation_BYONDLink_Listeners_LoadClassController {

    public static function loadClassListenerForum($class, &$extend) {
        if ($class == 'XenForo_ControllerPublic_Forum') {
            $extend[] = 'HippieStation_BYONDLink_ControllerPublic_Forum';
        }
    }

    public static function loadClassListenerThread($class, &$extend) {
        if ($class == 'XenForo_ControllerPublic_Thread') {
            $extend[] = 'HippieStation_BYONDLink_ControllerPublic_Thread';
        }
    }

    public static function loadClassListenerConversation($class, &$extend) {
        if ($class == 'XenForo_ControllerPublic_Conversation') {
            $extend[] = 'HippieStation_BYONDLink_ControllerPublic_Conversation';
        }
    }

    public static function loadClassListenerMember($class, &$extend) {
        if ($class == 'XenForo_ControllerPublic_Member') {
            $extend[] = 'HippieStation_BYONDLink_ControllerPublic_Member';
        }
    }
}
