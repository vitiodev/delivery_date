<?php
declare(strict_types=1);

namespace Overdose\CustomDeliveryDate\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Overdose\CustomDeliveryDate\Model\Config;

class SaveCustomDeliveryDateToOrderObserver implements \Magento\Framework\Event\ObserverInterface
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
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $date = $this->addToCurrentDateFewDays();
        $order->setData(Config::CUSTOM_DELIVERY_DATE_ATTRIBUTE, $date);
        return $this;
    }

    /**
     * Add to current date a few days
     *
     * @return string
     */
    private function addToCurrentDateFewDays(): string
    {
        return $this->dateTime->date(null, strtotime('+' . Config::DAYS . 'days'));
    }
}
