<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\XmlFeedModel\Block\Adminhtml\System\Config\Form\Field\FieldArray;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class SubjectFieldArray
 *
 * @package                 Alaa\XmlFeedModel\Block\Adminhtml\System\Config\Form\Field\FieldArray
 * @author                  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @SuppressWarnings(PHPMD)
 */
class SubjectFieldArray extends AbstractFieldArray
{
    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD)
     * @codingStandardsIgnoreStart
     */
    protected function _prepareToRender()
    {
        $this->addColumn('magento_attribute', [ 'label' => __('Magento Attribute')]);
        $this->addColumn('custom_attribute', [ 'label' => __('Custom Attribute')]);
        $this->_addAfter = false;
        parent::_prepareToRender();
    }
    //@codingStandardsIgnoreEnd
}
