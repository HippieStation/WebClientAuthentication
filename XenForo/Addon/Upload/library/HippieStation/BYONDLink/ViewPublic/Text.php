<?php

class HippieStation_BYONDLink_ViewPublic_Text extends  XenForo_ViewPublic_Base
{
    public function renderRaw()
    {
        return $this->_params[0];
    }
}