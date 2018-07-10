<?php
/**
 * OnePica_AvaTax
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0), a
 * copy of which is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   OnePica
 * @package    OnePica_AvaTax
 * @author     OnePica Codemaster <codemaster@onepica.com>
 * @copyright  Copyright (c) 2009 One Pica, Inc.
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

/**
 * Class OnePica_AvaTaxAr2_Block_Documents_Grid
 */
class OnePica_AvaTaxAr2_Block_Documents_Grid extends Mage_Core_Block_Template
{
    protected $_collection;

    public function __construct()
    {
        parent::__construct();

        /** @var \OnePica_AvaTaxAr2_Block_Documents_Grid $rootBlock */
        $rootBlock = Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root');

        $rootBlock->setHeaderTitle($this->__('AvaTax Documents'));
    }

    /**
     * Preparing global layout
     *
     * You can redefine this method in child classes for changing layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->createBlock('page/html_pager', 'avataxar2.documents.grid.pager')
                      ->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();

        return $this;
    }

    /**
     * @return \OnePica_AvaTaxAr2_Model_Records_RestV2_Document_Collection
     */
    public function getCollection()
    {
        if (!$this->_collection) {
            $this->_collection = new Varien_Data_Collection();
            $this->_collection = Mage::getModel('avataxar2_records/document')->getCollection();
            $this->_collection->addCustomerFilter($this->getCustomerNumber());
        }

        return $this->_collection;
    }

    /**
     * @return int|string
     */
    public function getCustomerNumber()
    {
        return 100;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @param $document
     * @return string
     */
    public function getRevokeUrl($document)
    {
        return $this->getUrl('*/*/delete', array('document_id' => $document->getId()));
    }
}
