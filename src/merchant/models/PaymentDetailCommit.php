<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\merchant\models;

    use waafipay\merchant\models\PaymentDetailCommit\paymentCommitDetailBuilder;
    use waafipay\pg\constants\LibraryConstants;
    use waafipay\pg\constants\MerchantProperties;
    use waafipay\pg\models\ServiceParams;
    use waafipay\pg\request\InitiateCommitTransactionRequestBody;
    use waafipay\pg\request\InitiateRefundTransactionRequestBody;

    /**
     * This class is used to store all the PaymentDetailCommit information
     * Request of initiateTransaction api is translated by PaymentDetailCommit object
     *
     * Class PaymentDetailCommit
     * @package Waafipay\merchant\models
     *
     */
    class PaymentDetailCommit
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
         * @param paymentCommitDetailBuilder $paymentCommitDetailBuilder
         */
        public function __construct($paymentCommitDetailBuilder)
        {
            $this->channelId = $paymentCommitDetailBuilder->channelId;
            $this->orderId = $paymentCommitDetailBuilder->orderId;
            $this->serviceParams = $paymentCommitDetailBuilder->serviceParams;
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

        /**
         * @return InitiateCommitTransactionRequestBody
         */
        public function createInitiateTransactionRequestBody()
        {
            $body = new InitiateCommitTransactionRequestBody();
            $body->setRequestType(LibraryConstants::REQUEST_TYPE_PREAUTHCOMMIT);
            $body->setschemaVersion(LibraryConstants::SCHEMA_VERSION);
            $body->setMid(MerchantProperties::getmerchantUid());
            $body->setapiid(MerchantProperties::getapiUserId());
            $body->setapikey(MerchantProperties::getapiKey());
            $body->setOrderId($this->getOrderId());
            $body->setserviceParams($this->getserviceParams());
            $body->setchannelId($this->getChannelId());
            return $body;
        }
		
		
		/**
         * @return InitiateCommitTransactionRequestBody
         */
        public function createCancelTransactionRequestBody()
        {
            $body = new InitiateCommitTransactionRequestBody();
            $body->setRequestType(LibraryConstants::REQUEST_TYPE_PREAUTHCANCEL);
            $body->setschemaVersion(LibraryConstants::SCHEMA_VERSION);
            $body->setMid(MerchantProperties::getmerchantUid());
            $body->setapiid(MerchantProperties::getapiUserId());
            $body->setapikey(MerchantProperties::getapiKey());
            $body->setOrderId($this->getOrderId());
            $body->setserviceParams($this->getserviceParams());
            $body->setchannelId($this->getChannelId());
            return $body;
        }
		
		public function createPCancelTransactionRequestBody()
        {
            $body = new InitiateCommitTransactionRequestBody();
            $body->setRequestType(LibraryConstants::REQUEST_TYPE_CANCELPURCHASE);
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


    namespace waafipay\merchant\models\PaymentDetailCommit;

    use waafipay\merchant\models\PaymentDetailCommit;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\models\ServiceParams;
    use waafipay\pg\utils\CommonUtil;

    /**
     * PaymentCommitDetailBuilder is used to build the PaymentDetailCommit object
     *
     * Class PaymentCommitDetailBuilder
     * @package Waafipay\merchant\models\PaymentDetailCommit
     */
    class PaymentCommitDetailBuilder
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
         * @var serviceParams
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
        public function __construct($channelId, $serviceParams)
        {
            if (CommonUtil::checkStringForEmptyOrNull($channelId)) {
                throw new SDKException("ChannelId can not be null or empty");
            }
            elseif (!$serviceParams instanceof ServiceParams) {
                throw new SDKException("ServiceParams Info should be of type Waafipay\pg\models\ServiceParams");
            }
            else {
                $this->channelId = $channelId;
                $this->orderId = 'RPHWP'.time();
                $this->serviceParams = $serviceParams;
            }
        }

        /**
         * @return PaymentDetailCommit
         */
        public function build()
        {
            return new PaymentDetailCommit($this);
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