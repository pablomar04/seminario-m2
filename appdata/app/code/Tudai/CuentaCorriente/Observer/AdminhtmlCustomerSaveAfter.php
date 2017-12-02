<?php

namespace Tudai\CuentaCorriente\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AdminhtmlCustomerSaveAfter implements ObserverInterface{
  protected $logger;
  protected $adminSession;

  function __construct(
    \Psr\Log\LoggerInterface $logger,
    \Magento\Backend\Model\Auth\Session $adminSession
  ){
    $this->logger = $logger;
    $this->adminSession = $adminSession;

  }

  function execute(\Magento\Framework\Event\Observer $observer){
    $customer = $observer->getData('customer');

    $customerName= $customer->getFirstName().' '.$customer->getLastName();
    $value = $customer->getCustomAttribute('enable_customer_credit')->getValue();

    $adminUser = $this->adminSession->getUser()->getName();
    $this->logger->info(sprintf("OBSERVER -- %s Guardado con valor %s por e administrador %s",$customerName,$value,$adminUser));

  }
}




 ?>
