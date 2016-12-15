<?php
class KS_Customapi_Model_Api extends Mage_Api_Model_Resource_Abstract
{        
    public function pages($sortby='id', $order='ASC')
    {
        return Mage::helper('customapi')->getPages($sortby,$order);
    }
    
    public function page($pageId=0)
    {
        return Mage::helper('customapi')->getPage($pageId);
    }
    
    public function blocks($sortby='id', $order='ASC')
    {
        return Mage::helper('customapi')->getBlocks($sortby,$order);
    }
    
    public function block($blockId=0)
    {
        return Mage::helper('customapi')->getBlock($blockId);
    }
    
}