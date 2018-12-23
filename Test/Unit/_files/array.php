<?php
/**
 * @copyright 2018 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

return [
    'order' => 'mapper/mapped_fields/order',
    'order.customer' => 'mapper/mapped_fields/customer',
    'order.customer.customer_address' => 'mapper/mapped_fields/customer_address',
    'order.items' => '',
    'order.items.item' => 'mapper/mapped_fields/item',
];
