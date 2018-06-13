<?php
/**
 * OnePica_AvaTax
 *
 * NOTICE OF LICENSE
 *
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
 * Admin grid controller
 *
 * @property \Mage_Adminhtml_Model_Session _sessionAdminhtml
 * @category   OnePica
 * @package    OnePica_AvaTax
 * @author     OnePica Codemaster <codemaster@onepica.com>
 */
class OnePica_AvaTaxAr2_Adminhtml_AvaTaxAr2_GridController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Additional initialization
     */
    protected function _construct()
    {
        $this->setUsedModuleName('OnePica_AvaTaxAr2');
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('avataxar2');
    }

    /**
     * Customer newsletter grid
     *
     */
    public function documentsAction()
    {
        $this->_initCustomer();

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Customer newsletter grid
     *
     */
    public function documentDeleteAction()
    {
        $certId = $this->getRequest()->getPost('certId');

        $dataResponse = array();
        $dataResponse['success'] = true;
        $dataResponse['message'] = $certId . ' deleted';

        $this->getResponse()->setBody(json_encode($dataResponse));
    }

    /**
     * @param string $idFieldName
     * @return $this
     * @throws \Mage_Core_Exception
     */
    protected function _initCustomer($idFieldName = 'id')
    {
        $this->_title($this->__('Customers'))->_title($this->__('Manage Customers'));

        $customerId = (int)$this->getRequest()->getParam($idFieldName);
        $customer = Mage::getModel('customer/customer');

        if ($customerId) {
            $customer->load($customerId);
        }

        Mage::register('current_customer', $customer);

        return $this;
    }
}
