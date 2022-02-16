<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\merchant\models;

    use waafipay\merchant\models\PaymentHppResponseDetail\PaymentDetailHppResponseBuilder;
    use waafipay\pg\constants\LibraryConstants;
    use waafipay\pg\constants\MerchantProperties;
    use waafipay\pg\models\PayerInfo;
    use waafipay\pg\models\TransactionInfo;
    use waafipay\pg\request\InitiateHppTransactionResponseBody;

    /**
     * This class is used to store all the PaymentHppResponseDetail information
     * Request of initiateTransaction api is translated by PaymentHppResponseDetail object
     *
     * Class PaymentHppResponseDetail
     * @package Waafipay\merchant\models
     *
     */
    class PaymentHppResponseDetail
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
         * @var Money
         * required
         */
        
        /**
         * @var int
         * Read TimeOut for Payment Api
         * optional
         */
        private $readTimeout;

         /**
         * @var string
         */
        private $hppResultToken;

        /**
         * PaymentDetail constructor.
         * @param PaymentDetailHppResponseBuilder $PaymentDetailHppResponseBuilder
         */
        public function __construct($PaymentDetailHppResponseBuilder)
        {
            $this->channelId = $PaymentDetailHppResponseBuilder->channelId;
            $this->orderId = $PaymentDetailHppResponseBuilder->orderId;
            $this->hppResultToken = $PaymentDetailHppResponseBuilder->hppResultToken;
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
        public function gethppResultToken()
        {
            return $this->hppResultToken;
        }

        
        /**
         * @return string
         */
        public function getOrderId()
        {
            return $this->orderId;
        }

        

        /**
         * @return int
         */
        public function getReadTimeout()
        {
            return $this->readTimeout;
        }

        /**
         * @return InitiateHppTransactionResponseBody
         */
        public function createInitiateHppTransactionResponseBody()
        {
            $body = new InitiateHppTransactionResponseBody();
            $body->setRequestType(LibraryConstants::REQUEST_TYPE_PREAUTHORIZE);
            $body->setschemaVersion(LibraryConstants::SCHEMA_VERSION);
            $body->setMid(MerchantProperties::getmerchantUid());
            $body->setapiid(MerchantProperties::getapiUserId());
            $body->setapikey(MerchantProperties::getapiKey());
            $body->setOrderId($this->getOrderId());
            $body->setchannelId($this->getChannelId());
            $body->sethppResultToken($this->gethppResultToken());
            return $body;
        }
    }


    namespace waafipay\merchant\models\PaymentHppResponseDetail;

    use waafipay\merchant\models\PaymentHppResponseDetail;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\models\TransactionInfo;
    use waafipay\pg\utils\CommonUtil;

    /**
     * PaymentDetailHppResponseBuilder is used to build the PaymentHppResponseDetail object
     *
     * Class PaymentDetailHppResponseBuilder
     * @package Waafipay\merchant\models\PaymentHppResponseDetail
     */
    class PaymentDetailHppResponseBuilder
    {

        /**
         * @var string
         */
        public $channelId;
        /**
         * @var string
         */
        public $paymentMethod;
		/**
         * @var string
         */
        public $orderId;
        /**
         * @var transactionInfo
         */
        
         /**
         * @var string
         */
        public $hppResultToken;
        
        
        /**
         * @var int
         * Default value of readTimeout is 80000
         */
        public $readTimeout = 80000;

        /**
         * PaymentDetailBuilder constructor.
         * @throws \Exception
         */
        public function __construct($channelId,$hppResultToken)
        {
            if (CommonUtil::checkStringForEmptyOrNull($channelId)) {
                throw new SDKException("ChannelId can not be null or empty");
            } elseif(CommonUtil::checkStringForEmptyOrNull($hppResultToken)){
                throw new SDKException("Response Token can not be null or empty");    
            }
            else {
                $this->channelId = $channelId;
                $this->hppResultToken = $hppResultToken;
                $this->orderId = 'RPHWP'.time();
            }
        }

        /**
         * @return PaymentHppResponseDetail
         */
        public function build()
        {
            return new PaymentHppResponseDetail($this);
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

         /**
         * @param string $hppResultToken
         */
        public function sethppResultToken($hppResultToken)
        {
            $this->hppResultToken = $hppResultToken;
        }
		
		

        
    }