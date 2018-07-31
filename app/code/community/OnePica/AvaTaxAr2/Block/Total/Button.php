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
 * Class OnePica_AvaTaxAr2_Block_ActionButton
 */
class OnePica_AvaTaxAr2_Block_Total_Button extends Mage_Checkout_Block_Total_Default
{
    protected $_template = 'onepica/avataxar2/total/button.phtml';

    /**
     * @return string
     */
    public function getPopupUrl()
    {
        if ($this->_getCustomerSession()->isLoggedIn()) {
            return $this->getUrl(
                'avataxcert/popup/genCert', array(
                    'customerId'     => $this->getCustomerId(),
                    'customerNumber' => $this->getCustomerNumberOrGenerate()
                )
            );
        }

        return $this->getUrl('avataxcert/popup/loginMessage');
    }

    /**
     * @return \Mage_Customer_Model_Customer
     */
    public function getCustomer()
    {
        return $this->_getCustomerSession()->getCustomer();
    }

    /**
     * @return int|string
     */
    public function getCustomerId()
    {
        return $this->getCustomer()->getId();
    }

    /**
     * @return int|string
     */
    public function getCustomerNumberOrGenerate()
    {
        return $this->_getHelper()->getCustomerNumberOrGenerate($this->getCustomer());
    }

    /**
     * @return \Mage_Customer_Model_Session
     */
    protected function _getCustomerSession()
    {
        return Mage::getSingleton('customer/session');
    }

    /**
     * @return \OnePica_AvaTaxAr2_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('avataxar2');
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        $html = parent::_toHtml();

        $totals = $this->getTotals();
        if (!isset($totals['tax'])) {
            $html = '';
        }

        if (isset($totals['tax']) && $totals['tax']->getValue() == 0) {
            $html = '';
        }

        return $html;
    }
}
