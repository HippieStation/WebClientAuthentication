<?php

class HippieStation_BYONDLink_ViewPublic_JSON extends  XenForo_ViewPublic_Base
{
    public function renderJson()
    {
        return json_encode($this->_params);
    }
}