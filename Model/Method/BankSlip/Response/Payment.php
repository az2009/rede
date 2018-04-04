<?php

namespace Az2009\Cielo\Model\Method\BankSlip\Response;

class Payment extends \Az2009\Cielo\Model\Method\Cc\Response\Payment
{
    public function __construct(
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Authorize $authorize,
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Unauthorized $unauthorized,
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Capture $capture,
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Pending $pending,
        \Az2009\Cielo\Model\Method\BankSlip\Transaction\Cancel $cancel,
        array $data = []
    ) {
        parent::__construct($authorize, $unauthorized, $capture, $pending, $cancel, $data);
    }

    public function process()
    {
        switch ($this->getStatus()) {

            case Payment::STATUS_AUTHORIZED:
            case Payment::STATUS_CAPTURED:
                $this->_capture
                    ->setPayment($this->getPayment())
                    ->setResponse($this->getResponse())
                    ->process();
                break;
            case Payment::STATUS_CANCELED_ABORTED:
            case Payment::STATUS_CANCELED_AFTER:
            case Payment::STATUS_CANCELED:
                $this->_cancel
                    ->setPayment($this->getPayment())
                    ->setResponse($this->getResponse())
                    ->process();
                break;
            case Payment::STATUS_PAYMENT_REVIEW:
            case Payment::STATUS_PENDING:
                $this->_pending
                    ->setPayment($this->getPayment())
                    ->setResponse($this->getResponse())
                    ->process();
                break;
            default:
                $this->_unauthorized
                    ->setPayment($this->getPayment())
                    ->setResponse($this->getResponse())
                    ->process();
                break;
        }
    }

    /**
     * get status payment
     * @return mixed
     * @throws \Exception
     */
    public function getStatus()
    {
        $payment = $this->getPayment();

        if ($payment->getPlaceOrderBankSlip()) {
            return Payment::STATUS_PAYMENT_REVIEW;
        }

        $body = $this->getBody();
        if (property_exists($body, 'Payment')) {
            $status = $body->Payment->Status;
            return $this->isStatusCanceled($status);
        } elseif (property_exists($body, 'Status')) {
            $status = $body->Status;
            return $this->isStatusCanceled($status);
        }

        throw new \Exception(__('Invalid payment status'));
    }
}