<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\merchant\models;

    use waafipay\merchant\models\PaymentHppDetail\PaymentDetailHppBuilder;
    use waafipay\pg\constants\LibraryConstants;
    use waafipay\pg\constants\MerchantProperties;
    use waafipay\pg\models\PayerInfo;
    use waafipay\pg\models\TransactionInfo;
    use waafipay\pg\request\InitiateHppTransactionRequestBody;

    /**
     * This class is used to store all the PaymentHppDetail information
     * Request of initiateTransaction api is translated by PaymentHppDetail object
     *
     * Class PaymentHppDetail
     * @package Waafipay\merchant\models
     *
     */
    class PaymentHppDetail
    {
        /**
         * @var string
         * required
         */
        private $succallbackurl;

        /**
         * @var string
         * required
         */
        private $failcallbackurl;

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
        private $paymentMethod;
        /**
         * @var transactionInfo
         * required
         */
        private $transactionInfo;
        /**
         * @var payerInfo
         * required
         */
        private $payerInfo;
        /**
         * @var int
         * Read TimeOut for Payment Api
         * optional
         */
        private $readTimeout;

        /**
         * PaymentDetail constructor.
         * @param PaymentDetailHppBuilder $paymentDetailHppBuilder
         */
        public function __construct($paymentDetailHppBuilder)
        {
            $this->channelId = $paymentDetailHppBuilder->channelId;
            $this->paymentMethod = $paymentDetailHppBuilder->paymentMethod;
            $this->orderId = $paymentDetailHppBuilder->orderId;
            $this->transactionInfo = $paymentDetailHppBuilder->transactionInfo;
            $this->succallbackurl = $paymentDetailHppBuilder->succallbackurl;
            $this->failcallbackurl = $paymentDetailHppBuilder->failcallbackurl;
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
        public function getsuccallbackurl()
        {
            return $this->succallbackurl;
        }

        /**
         * @return string
         */
        public function getfailcallbackurl()
        {
            return $this->failcallbackurl;
        }

        /**
         * @return string
         */
        public function getpaymentMethod()
        {
            return $this->paymentMethod;
        }

        /**
         * @return string
         */
        public function getOrderId()
        {
            return $this->orderId;
        }

        
        
		
		/**
         * @return transactionInfo
         */
        public function gettransactionInfo()
        {
            return $this->transactionInfo;
        }

        /**
         * @return int
         */
        public function getReadTimeout()
        {
            return $this->readTimeout;
        }

        /**
         * @return InitiateHppTransactionRequestBody
         */
        public function createInitiateHppTransactionRequestBody()
        {
            $body = new InitiateHppTransactionRequestBody();
            $body->setRequestType(LibraryConstants::REQUEST_TYPE_PREAUTHORIZE);
            $body->setschemaVersion(LibraryConstants::SCHEMA_VERSION);
            $body->setMid(MerchantProperties::getmerchantUid());
            $body->setapiid(MerchantProperties::getapiUserId());
            $body->setapikey(MerchantProperties::getapiKey());
            $body->setOrderId($this->getOrderId());
            $body->setpaymentMethod($this->getpaymentMethod());
            $body->settransactionInfo($this->gettransactionInfo());
            $body->setchannelId($this->getChannelId());
            $body->setsuccallbackurl($this->getsuccallbackurl());
            $body->setfailcallbackurl($this->getfailcallbackurl());
            return $body;
        }
    }


    namespace waafipay\merchant\models\PaymentHppDetail;

    use waafipay\merchant\models\PaymentHppDetail;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\models\TransactionInfo;
    use waafipay\pg\utils\CommonUtil;

    /**
     * PaymentDetailHppBuilder is used to build the PaymentHppDetail object
     *
     * Class PaymentDetailHppBuilder
     * @package Waafipay\merchant\models\PaymentHppDetail
     */
    class PaymentDetailHppBuilder
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
        public $transactionInfo;

        /**
         * @var string
         * required
         */
        private $succallbackurl;

        /**
         * @var string
         * required
         */
        private $failcallbackurl;
        
        
        /**
         * @var int
         * Default value of readTimeout is 80000
         */
        public $readTimeout = 80000;

        /**
         * PaymentDetailBuilder constructor.
         * @throws \Exception
         */
        public function __construct($channelId, $paymentMethod, $transactionInfo, $succallbackurl, $failcallbackurl)
        {
            if (CommonUtil::checkStringForEmptyOrNull($channelId)) {
                throw new SDKException("ChannelId can not be null or empty");
            }
            elseif (CommonUtil::checkStringForEmptyOrNull($paymentMethod)) {
                throw new SDKException("PaymentMethod can not be null or empty");
            }
            elseif (CommonUtil::checkStringForEmptyOrNull($succallbackurl)) {
                throw new SDKException("Success Call back URL can not be null or empty");
            }
            elseif (CommonUtil::checkStringForEmptyOrNull($failcallbackurl)) {
                throw new SDKException("Failure Call back URL can not be null or empty");
            }
            elseif (!$transactionInfo instanceof TransactionInfo) {
                throw new SDKException("Transaction Info should be of type Waafipay\pg\models\TransactionInfo");
            }
            else {
                $this->channelId = $channelId;
                $this->paymentMethod = $paymentMethod;
                $this->orderId = 'RPHWP'.time();
                $this->transactionInfo = $transactionInfo;
                $this->succallbackurl = $succallbackurl;
                $this->failcallbackurl = $failcallbackurl;
            }
        }

        /**
         * @return PaymentHppDetail
         */
        public function build()
        {
            return new PaymentHppDetail($this);
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
		
		public function setpaymentMethod($paymentMethod)
        {
            $this->paymentMethod = $paymentMethod;
        }
		
		public function settransactionInfo($transactionInfo)
        {
            $this->transactionInfo = $transactionInfo;
        }

        public function setsuccallbackurl($succallbackurl)
        {
            $this->succallbackurl = $succallbackurl;
        }

        public function setfailcallbackurl($failcallbackurl)
        {
            $this->failcallbackurl = $failcallbackurl;
        }
		

        
    }