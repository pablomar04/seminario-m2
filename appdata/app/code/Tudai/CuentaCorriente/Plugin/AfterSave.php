<?php

namespace Tudai\CuentaCorriente\Plugin;

class AfterSave
{
    /** @var \Psr\Log\LoggerInterface  */
    protected $logger;

    /** @var \Magento\Backend\Model\Auth\Session  */
    protected $adminSession;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Backend\Model\Auth\Session $adminSession
    )
    {
        $this->logger = $logger;
        $this->adminSession = $adminSession;
    }

    public function afterSave(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Api\Data\CustomerInterface $customer)
    {
        $customerName = $customer->getFirstname().' '.$customer->getLastname();
        $value = $customer->getCustomAttribute('enable_customer_credit')->getValue();

        $adminUser = $this->adminSession->getUser()->getName();

        $this->logger->info(sprintf("PLUGIN -- %s Guardado con Valor %s por el administrador %s", $customerName, $value, $adminUser));

        return $customer;
    }
}