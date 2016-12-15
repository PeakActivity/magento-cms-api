<?php
class KS_Customapi_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->_redirect('cmsapi/page/list');
    }
}