<?php
/**
 * Class CreditAccount
 *
 * @author   Facundo Capua <fcapua@summasolutions.net>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     http://www.summasolutions.net/
 */

namespace Tudai\CuentaCorriente\Model;

class CustomerCredit
    extends \Magento\Payment\Model\Method\AbstractMethod
{

    const PAYMENT_METHOD_USERCREDIT_CODE = 'customer_credit';



    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_USERCREDIT_CODE;


    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;


    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        //Me traigo por injección de dependencia la sesión del usuario
        $this->customerSession = $customerSession;

        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig,
            $logger, $resource, $resourceCollection, $data);
    }


    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        //Si ya viene habilitado el método (verificando si está activo)
        $isAvailable = parent::isAvailable($quote);

        if ($isAvailable){
          //Tomo el valor de si tiene habilitado el credito o no para saber si lo muestro
          $isAvailable = (bool) $this->customerSession->getCustomer()->getData('enable_customer_credit');
            //Si usuario tiene habilitado el metodo de pago verifico que el total no sea mayor al permitido
            if ($isAvailable){
              $importe = $quote->getData('base_grand_total');
              //Tomo el valor que esta guardado en la configuracion segun el atributo de la clase padre
              $limite = $this->_scopeConfig->getValue('payment/customer_credit/limite');
              $isAvailable = (bool)($importe <= $limite);
            }
        }

        return $isAvailable;
    }
}
