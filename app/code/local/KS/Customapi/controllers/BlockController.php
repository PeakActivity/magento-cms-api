<?php
class KS_Customapi_BlockController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        return $this->listAction();
    }
    
    public function listAction()
    {
        $params = $this->getRequest()->getParams();
        $sortby = !empty($params['sortby']) ? $params['sortby'] : 'created';
        $response = Mage::helper('customapi')->getBlocks( $sortby, (isset( $params['DESC'] ) ? 'DESC' : 'ASC') );
        
        $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
    
    public function getAction()
    {
        $blockId = $this->getRequest()->getParam('block');
        $response = Mage::helper('customapi')->getBlock($blockId);
        
        $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}