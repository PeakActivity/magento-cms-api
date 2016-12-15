<?php
class KS_Customapi_PageController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        return $this->listAction();
    }
    
    public function listAction()
    {
        $params = $this->getRequest()->getParams();
        $sortby = !empty($params['sortby']) ? $params['sortby'] : 'created';
        $response = Mage::helper('customapi')->getPages( $sortby, (isset( $params['DESC'] ) ? 'DESC' : 'ASC') );
        
        $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
    
    public function getAction()
    {
        $pageId = $this->getRequest()->getParam('page');
        $response = Mage::helper('customapi')->getPage($pageId);
        
        $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}