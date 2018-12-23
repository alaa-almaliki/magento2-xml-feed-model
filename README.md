# Magento2 Xml Feed Model

## Installation
```
composer install alaa/magento2-xml-feed-model
php -f bin/magento module:enable Alaa_XmlFeedModel
php -f bin/magento setup:upgrade
```

## How it works

### Setup
First, a configuration file needs to be created.
```
<?php

return [
    'order' => 'mapper/mapped_fields/order', // order is the parent node of the xml document => xml config path in the system.xml file
    'order.customer' => 'mapper/mapped_fields/customer', // order/customer is the xml path to the customer node in the document => xml config path in the system.xml file
    'order.customer.customer_address' => 'mapper/mapped_fields/customer_address', // order/customer/customer_address => xml config path in the system.xml file
    'order.items' => '', // order/items contains children item nodes => empty xml config path, no data mapping is required for this node
    'order.items.item' => 'mapper/mapped_fields/item', // order/items/item contains item nodes => xml config path in the system.xml file
];
```

Then, create a field mapping from the backend using the `system.xml` file
```
<?xml version="1.0" encoding="UTF-8"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Config:etc/system_file.xsd">
    <system>
        <tab id="xml_feed_model_example">
            <label>Xml Feed Model Example</label>
        </tab>
        <section id="mapper" showInStore="1" showInWebsite="1" showInDefault="1" translate="label" sortOrder="1">
            <label>Order Feed Fields</label>
            <tab>xml_feed_model_example</tab>
            <resource>{YOUR ACL RESOURCE}</resource>
            <group id="mapped_fields" showInStore="1" showInWebsite="1" showInDefault="1" translate="label" sortOrder="1">
                <label>Mapped Fields</label>
                <field id="order" showInStore="1" showInWebsite="1" showInDefault="1" translate="label" sortOrder="1">
                    <label>Order Fields</label>
                    <backend_model>Magento\Config\Model\Config\Backend\Serialized\ArraySerialized</backend_model>
                    <frontend_model>Alaa\XmlFeedModel\Block\Adminhtml\System\Config\Form\Field\FieldArray\SubjectFieldArray</frontend_model>
                </field>
            </group>
        </section>
    </system>
</config>
```

A predefined class `Alaa\XmlFeedModel\Block\Adminhtml\System\Config\Form\Field\FieldArray\SubjectFieldArray` is used for mapping array keys

Now you should be able to ad as many mapping as required.

### Usage

Resolving the representation of the xml
```
$order = $this->orderRepository->get($orderId);

$orderSubject = new Subject('order', $order->getData()); // corresponds to 'order' => 'mapper/mapped_fields/order', in the configuration file
$orderSubject->addAttribute($orderSubject->getNodeName(), 'account', '111');

$customerSubject = new Subject('customer');
$customerSubject->setData($order->getData());
$customerSubject->addAttribute($customerSubject->getNodeName(), 'id', (string) $order->getCustomerId());

$customerAddress = new Subject('customer_address');
$customerAddress->setData($order->getBillingAddress()->getData());

$itemsSubject = new Subject('items');
foreach ($order->getItems() as $item) {
    if ($item->getParentItem()) {
        continue;
    }
    $itemsSubject->addChild(new Subject('item', $item->getData()));
}


$orderSubject->addChild($customerSubject);
$customerSubject->addChild($customerAddress);
$orderSubject->addChild($itemsSubject);
```

Writing the subject to xml
```
// Reading the configuration file
$file = $this->moduleDirReader->getModuleDir('etc', 'YOUR_MODULE'). '/order_mapped_fields.php';

// do the mappings
/** Alaa\XmlFeedModel\Model\MappedSubjectBuilder $this->mappedSubjectBuilder */
$mappedSubject = $this->mappedSubjectBuilder->build($file, $orderSubject);


// convert the data to xml
/** @var \Alaa\XmlFeedModel\Model\XmlConverter $this->xmlConverter */
$xml = $this->xmlConverter->convert($mappedSubject);

// write the xml to a file
$xml->asXML('var/order/subject.xml');
```

## Contribution
Feel free to raise issues and contribute.

## License 
MIT
