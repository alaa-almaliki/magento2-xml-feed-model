<?php

/**
 * (c) Alaa Al-Maliki
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Block\Adminhtml\System\Config\Form\Field\FieldArray;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class SubjectFieldArray
 *
 * @package Alaa\XmlFeedModel\Block\Adminhtml\System\Config\Form\Field\FieldArray
 */
class SubjectFieldArray extends AbstractFieldArray
{
    /**
     * Subject Field Array
     */
    protected function _prepareToRender()
    {
        $this->addColumn('custom_attribute', [ 'label' => __('Custom Attribute')]);
        $this->addColumn('magento_attribute', [ 'label' => __('Magento Attribute')]);
        $this->_addAfter = false;
        parent::_prepareToRender();
    }
}
