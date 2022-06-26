<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\merchant\models;

    use waafipay\merchant\models\PaymentRefund\PaymentRefundlBuilder;
    use waafipay\pg\constants\LibraryConstants;
    use waafipay\pg\constants\MerchantProperties;
    use waafipay\pg\models\ServiceParamsRefund;
    use waafipay\pg\request\InitiateCommitTransactionRequestBody;
    use waafipay\pg\request\InitiateRefundTransactionRequestBody;

    /**
     * This class is used to store all the PaymentRefund information
     * Request of initiateTransaction api is translated by PaymentDetailCommit object
     *
     * Class PaymentRefund
     * @package Waafipay\merchant\models
     *
     */
    class PaymentRefund
    {
        /**
         * @var string
         * required
         */
        private $channelId;
        /**
         * @var string
         * required
         */
        private $orderId;
       
        
        /**
         * @var payerInfo
         * required
         */
        private $serviceParams;
        /**
         * @var int
         * Read TimeOut for Payment Api
         * optional
         */
        private $readTimeout;

        /**
         * PaymentDetail constructor.
         * @param PaymentRefundlBuilder $PaymentRefundlBuilder
         */
        public function __construct($PaymentRefundlBuilder)
        {
            $this->channelId = $PaymentRefundlBuilder->channelId;
            $this->orderId = $PaymentRefundlBuilder->orderId;
            $this->serviceParams = $PaymentRefundlBuilder->serviceParams;
        }

        /**
         * @return string
         */
        public function getChannelId()
        {
            return $this->channelId;
        }

        
        /**
         * @return string
         */
        public function getOrderId()
        {
            return $this->orderId;
        }

        
        /**
         * @return serviceParams
         */
        public function getserviceParams()
        {
            return $this->serviceParams;
        }
		
		
        /**
         * @return int
         */
        public function getReadTimeout()
        {
            return $this->readTimeout;
        }

        
		
		public function createRefundRequestBody()
        {
            $body = new InitiateRefundTransactionRequestBody();
            $body->setRequestType(LibraryConstants::REQUEST_TYPE_REFUND);
            $body->setschemaVersion(LibraryConstants::SCHEMA_VERSION);
            $body->setMid(MerchantProperties::getmerchantUid());
            $body->setapiid(MerchantProperties::getapiUserId());
            $body->setapikey(MerchantProperties::getapiKey());
            $body->setOrderId($this->getOrderId());
            $body->setserviceParams($this->getserviceParams());
            $body->setchannelId($this->getChannelId());
            return $body;
        }
		
    }


    namespace waafipay\merchant\models\PaymentRefund;

    use waafipay\merchant\models\PaymentRefund;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\models\ServiceParamsRefund;
    use waafipay\pg\utils\CommonUtil;

    /**
     * PaymentCommitDetailBuilder is used to build the PaymentRefund object
     *
     * Class PaymentCommitDetailBuilder
     * @package Waafipay\merchant\models\PaymentRefund
     */
    class PaymentRefundlBuilder
    {

        /**
         * @var string
         */
        public $channelId;
        
		/**
         * @var string
         */
        public $orderId;
        /**
         * @var ServiceParamsRefund
         */
        public $serviceParams;
        
        
        /**
         * @var int
         * Default value of readTimeout is 80000
         */
        public $readTimeout = 80000;

        /**
         * PaymentCommitDetailBuilder constructor.
         * @throws \Exception
         */
        public function __construct($channelId, $orderId, $serviceParams)
        {
            if (CommonUtil::checkStringForEmptyOrNull($channelId)) {
                throw new SDKException("ChannelId can not be null or empty");
            }
            elseif (CommonUtil::checkStringForEmptyOrNull($orderId)) {
                throw new SDKException("OrderId can not be null or empty");
            }
            elseif (!$serviceParams instanceof ServiceParamsRefund) {
                throw new SDKException("ServiceParamsRefund Info should be of type Waafipay\pg\models\ServiceParamsRefund");
            }
            else {
                $this->channelId = $channelId;
                $this->orderId = $orderId;
                $this->serviceParams = $serviceParams;
            }
        }

        /**
         * @return PaymentRefund
         */
        public function build()
        {
            return new PaymentRefund($this);
        }

        /**
         * @param string $orderId
         * @return $this
         */
        public function setOrderId($orderId)
        {
            $this->orderId = $orderId;
            return $this;
        }

        /**
         * @param string $channelId
         */
        public function setChannelId($channelId)
        {
            $this->channelId = $channelId;
        }
		
				
		public function setserviceParams($serviceParams)
        {
            $this->serviceParams = $serviceParams;
        }
		
        
    }
