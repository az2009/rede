<?php

namespace Az2009\Cielo\Model\Method\Dc\Transaction;

class Pending extends \Az2009\Cielo\Model\Method\Cc\Transaction\Pending
{
    public function process()
    {
        $payment = $this->getPayment();
        $bodyArray = $this->getBody(\Zend\Json\Json::TYPE_ARRAY);
        $paymentId = '';

        if (property_exists($this->getBody(), 'Payment')) {
            $paymentId = $this->getBody()->Payment->PaymentId;
            $paymentId .= '-order';
        }

        if (!$payment->getTransactionId() && !empty($paymentId)) {
            $payment->setTransactionId($paymentId)
                    ->setLastTransId($paymentId);
            $payment->setAdditionalInformation(
                'transaction_authorization',
                $paymentId
            );

            if (isset($bodyArray['Payment'])) {
                $payment->setAdditionalInformation(
                    'payment_data',
                    \Zend\Json\Json::encode($bodyArray['Payment'])
                );
            }
        }

        if (isset($bodyArray['Payment']['AuthenticationUrl'])
            && $url = $bodyArray['Payment']['AuthenticationUrl']
        ) {
            $payment->setAdditionalInformation('redirect_url', $url);
        }

        $this->prepareBodyTransaction($bodyArray);

        $payment->setTransactionAdditionalInfo(
            \Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS,
            $this->getTransactionData()
        );

        $payment->setIsTransactionClosed(true);
        $payment->setIsTransactionPending(true);
        $this->addReturnMessageToTransaction($bodyArray);
        $payment->addTransaction(\Magento\Sales\Model\Order\Payment\Transaction::TYPE_ORDER);
        $payment->setTransactionId(null);

        return $this;
    }
}