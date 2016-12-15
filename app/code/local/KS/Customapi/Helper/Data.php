<?php
class KS_Customapi_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
     * Get list of CMS Page
     *
     * @since   0.1.0
     * @param   $sortby   string
     * @param   $order    string
     */
	public function getPages( $sortby = 'created', $order = 'ASC' )
	{
        $collection = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('is_active', 1);
        
        $allowsort = array( 'id', 'title', 'created', 'updated', 'sort' );
        $sortby = !empty($sortby) ? filter_var($sortby, FILTER_SANITIZE_STRING) : '';
        if ( !empty($sortby) && in_array($sortby, $allowsort) ) {
            $order = ($order != 'ASC') ? 'DESC' : 'ASC';
            if ( $sortby == 'id' ) $sortby = 'page_id';
            if ( $sortby == 'created' ) $sortby = 'creation_time';
            if ( $sortby == 'updated' ) $sortby = 'update_time';
            if ( $sortby == 'sort' ) $sortby = 'sort_order';
            $collection->setOrder($sortby, $order);
        } else {
            $collection->setOrder('creation_time', 'ASC');
        }
        
        $cmsdata = array();
        foreach ( $collection as $cms ) {
            $cmsdata[] = array(
                'id' => abs( $cms->getId() ),
                'title' => $cms->getTitle(),
                'created' => date( 'c', strtotime($cms->getCreationTime()) ),
                'updated' => date( 'c', strtotime($cms->getUpdateTime()) ),
                'url' => Mage::getUrl( $cms->getIdentifier() )
            );
        }
        
        $response = array(
            'messages' => [
                'success' => [
                    'code'    => !empty($cmsdata) ? 200 : 204,
                    'message' => 'List of CMS Page'
                ],
            ],
            'data' => $cmsdata
        );
	  
	  	return $response;
	}
    
    /**
     * Get Specific of CMS Page Data
     *
     * @since   0.1.0
     * @param   $pageId   int|string      page ID or page indentifier
     */
    public function getPage($pageId)
    {
        $storeId = Mage::app()->getStore()->getId();
        $page = Mage::getModel('cms/page')->setStoreId($storeId);
        
        if ( is_numeric($pageId) ) {
            $page->load($pageId);
        } else {
            $page->load($pageId,'identifier');
        }
        
        if ( $page->getId() ) {
            $cmscontent = Mage::helper('cms')->getPageTemplateProcessor()->filter($page->getContent());
            $response = array(
                'messages' => [
                    'success' => [
                        'code'    => 200,
                        'message' => 'CMS Page: '.$page->getTitle()
                    ],
                ],
                'data' => array(
                    'title' => $page->getTitle(),
                    'heading' => $page->getContentHeading() ? $page->getContentHeading() : '',
                    'content' => $cmscontent,
                    'created' => date( 'c', strtotime($page->getCreationTime()) ),
                    'updated' => date( 'c', strtotime($page->getUpdateTime()) ),
                    'seo' => [
                        'keywords' => $page->getMetaKeywords() ? $page->getMetaKeywords() : '',
                        'description' => $page->getMetaDescription() ? $page->getMetaDescription() : '',
                    ]
                )
            );
        } else {
            $response = array(
                'messages' => [
                    'success' => [
                        'code'    => 204,
                        'message' => 'Page you requested isn\'t available'
                    ],
                ]
            );
        }
        
        return $response;
    }
    
    /**
     * Get list of CMS Static Block
     *
     * @since   0.1.0
     * @param   $sortby   string
     * @param   $order    string
     */
    public function getBlocks( $sortby = 'created', $order = 'ASC' )
    {
        $collection = Mage::getModel('cms/block')->getCollection()->addFieldToFilter('is_active', 1);
        
        $allowsort = array( 'id', 'title', 'created', 'updated' );
        $sortby = !empty($sortby) ? filter_var($sortby, FILTER_SANITIZE_STRING) : '';
        if ( !empty($sortby) && in_array($sortby, $allowsort) ) {
            $order = ($order != 'ASC') ? 'DESC' : 'ASC';
            if ( $sortby == 'id' ) $sortby = 'block_id';
            if ( $sortby == 'created' ) $sortby = 'creation_time';
            if ( $sortby == 'updated' ) $sortby = 'update_time';
            $collection->setOrder($sortby, $order);
        } else {
            $collection->setOrder('creation_time', 'ASC');
        }
        
        $cmsdata = array();
        foreach ( $collection as $cms ) {
            $cmsdata[] = array(
                'id' => abs( $cms->getId() ),
                'title' => $cms->getTitle(),
                'identifier' => $cms->getIdentifier(),
                'content' => Mage::helper('cms')->getPageTemplateProcessor()->filter($cms->getContent()),
                'created' => date( 'c', strtotime($cms->getCreationTime()) ),
                'updated' => date( 'c', strtotime($cms->getUpdateTime()) )
            );
        }
        
        $response = array(
            'messages' => [
                'success' => [
                    'code'    => !empty($cmsdata) ? 200 : 204,
                    'message' => 'List of CMS Static Block'
                ],
            ],
            'data' => $cmsdata
        );
	  
	  	return $response;
    }
    
    /**
     * Get Specific of CMS Page Data
     *
     * @since   0.1.0
     * @param   $blockId   int|string      BLock ID or block indentifier
     */
    public function getBlock($blockId)
    {
        $storeId = Mage::app()->getStore()->getId();
        $block = Mage::getModel('cms/block')->setStoreId($storeId);
        
        if ( is_numeric($blockId) ) {
            $block->load($blockId);
        } else {
            $block->load($blockId,'identifier');
        }
        
        if ( $block->getId() ) {
            $cmscontent = Mage::helper('cms')->getPageTemplateProcessor()->filter($block->getContent());
            $response = array(
                'messages' => [
                    'success' => [
                        'code'    => 200,
                        'message' => 'CMS Static Block: '.$block->getTitle()
                    ],
                ],
                'data' => array(
                    'id' => abs( $block->getId() ),
                    'title' => $block->getTitle(),
                    'identifier' => $block->getIdentifier(),
                    'content' => $cmscontent,
                    'created' => date( 'c', strtotime($block->getCreationTime()) ),
                    'updated' => date( 'c', strtotime($block->getUpdateTime()) )
                )
            );
        } else {
            $response = array(
                'messages' => [
                    'success' => [
                        'code'    => 204,
                        'message' => 'Page you requested isn\'t available'
                    ],
                ]
            );
        }
        
        return $response;
    }
	
}
	 