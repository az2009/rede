<?php

namespace Az2009\Cielo\Model\Method\Dc;

class Postback extends \Az2009\Cielo\Model\Method\Cc\Postback
{
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\DataObject $request,
        Response\Postback $response,
        Validate\Validate $validate,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \Az2009\Cielo\Helper\Dc $helper,
        \Magento\Framework\DataObject $update,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context, $registry, $extensionFactory,
            $customAttributeFactory, $paymentData,
            $scopeConfig, $logger, $request,
            $response, $validate,
            $httpClientFactory, $helper, $update, $resource,
            $resourceCollection, $data
        );
    }


}