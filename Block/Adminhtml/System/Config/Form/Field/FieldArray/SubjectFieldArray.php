<?php

namespace Alaa\XmlFeedModel\Block\Adminhtml\System\Config\Form\Field\FieldArray;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class SubjectFieldArray
 * @package Alaa\XmlFeedModel\Block\Adminhtml\System\Config\Form\Field\FieldArray
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class SubjectFieldArray extends AbstractFieldArray
{
    /**
     * Prepare fields
     */
    protected function _prepareToRender()
    {
        $this->addColumn('custom_attribute', [ 'label' => __('Custom Attribute')]);
        $this->addColumn('magento_attribute', [ 'label' => __('Magento Attribute')]);
        $this->_addAfter = false;
        parent::_prepareToRender();
    }
}