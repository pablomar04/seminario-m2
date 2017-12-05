<?php
/**
 * Class MyAccount
 *
 * @author   Facundo Capua <fcapua@summasolutions.net>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     http://www.summasolutions.net/
 */

namespace Tudai\CuentaCorriente\Block;

class MyAccount
    extends \Magento\Framework\View\Element\AbstractBlock
{
    /** @var \Magento\Customer\Model\Session */
    protected $session;

    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\View\Element\Context $context,
        array $data = []
    ) {
        $this->session = $session;
        parent::__construct($context, $data);
    }

    public function _toHtml()
    {
        $userCreditAvailable = (bool) $this->session->getCustomer()->getData('enable_customer_credit');
        if($userCreditAvailable){
            return 'El usuario puede comprar con Cuenta Corriente';
        }else{
            return 'El usuario no puede comprar con Cuenta Corriente';
        }
    }
}