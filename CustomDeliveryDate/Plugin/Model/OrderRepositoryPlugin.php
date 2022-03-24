<?php
declare(strict_types=1);

namespace Overdose\CustomDeliveryDate\Plugin\Model;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\OrderRepository;
use Overdose\CustomDeliveryDate\Model\Config;

class OrderRepositoryPlugin
{
    /**
     * @var DateTime
     */
    private DateTime $dateTime;

    /**
     * @param DateTime $dateTime
     */
    public function __construct(
        DateTime $dateTime
    ) {
        $this->dateTime = $dateTime;
    }

    /**
     * Add custom delivery attribute to rest request
     *
     * @param OrderRepository $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepository $subject, OrderInterface $order)
    {
        $date = $this->dateTime->date(
            Config::TIME_FORMAT,
            strtotime($order->getData(Config::CUSTOM_DELIVERY_DATE_ATTRIBUTE))
        );
        $extensionAttributes = $order->getExtensionAttributes()->setData(Config::CUSTOM_DELIVERY_DATE_ATTRIBUTE, $date);
        $order->setExtensionAttributes($extensionAttributes);
        return $order;
    }
}
