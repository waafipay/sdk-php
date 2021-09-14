<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\merchant\models;

    use waafipay\merchant\models\PaymentDetail\PaymentDetailBuilder;
    use waafipay\pg\constants\LibraryConstants;
    use waafipay\pg\constants\MerchantProperties;
    use waafipay\pg\models\PayerInfo;
    use waafipay\pg\models\TransactionInfo;
    use waafipay\pg\request\InitiateTransactionRequestBody;

    /**
     * This class is used to store all the paymentDetail information
     * Request of initiateTransaction api is translated by paymentDetail object
     *
     * Class PaymentDetail
     * @package Waafipay\merchant\models
     *
     */
    class PaymentDetail
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
         * @param PaymentDetailBuilder $paymentDetailBuilder
         */
        public function __construct($paymentDetailBuilder)
        {
            $this->channelId = $paymentDetailBuilder->channelId;
            $this->paymentMethod = $paymentDetailBuilder->paymentMethod;
            $this->orderId = $paymentDetailBuilder->orderId;
            $this->payerInfo = $paymentDetailBuilder->payerInfo;
            $this->transactionInfo = $paymentDetailBuilder->transactionInfo;
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
         * @return payerInfo
         */
        public function getpayerInfo()
        {
            return $this->payerInfo;
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
         * @return InitiateTransactionRequestBody
         */
        public function createInitiateTransactionRequestBody()
        {
            $body = new InitiateTransactionRequestBody();
            $body->setRequestType(LibraryConstants::REQUEST_TYPE_PREAUTHORIZE);
            $body->setschemaVersion(LibraryConstants::SCHEMA_VERSION);
            $body->setMid(MerchantProperties::getmerchantUid());
            $body->setapiid(MerchantProperties::getapiUserId());
            $body->setapikey(MerchantProperties::getapiKey());
            $body->setOrderId($this->getOrderId());
            $body->setpaymentMethod($this->getpaymentMethod());
            $body->setpayerInfo($this->getpayerInfo());
            $body->settransactionInfo($this->gettransactionInfo());
            $body->setchannelId($this->getChannelId());
            return $body;
        }
    }


    namespace waafipay\merchant\models\PaymentDetail;

    use waafipay\merchant\models\paymentDetail;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\models\PayerInfo;
    use waafipay\pg\models\TransactionInfo;
    use waafipay\pg\utils\CommonUtil;

    /**
     * PaymentDetailBuilder is used to build the paymentDetail object
     *
     * Class PaymentDetailBuilder
     * @package Waafipay\merchant\models\PaymentDetail
     */
    class PaymentDetailBuilder
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
         * @var payerInfo
         */
        public $payerInfo;
        
        /**
         * @var int
         * Default value of readTimeout is 80000
         */
        public $readTimeout = 80000;

        /**
         * PaymentDetailBuilder constructor.
         * @throws \Exception
         */
        public function __construct($channelId, $paymentMethod, $orderId, $transactionInfo, $payerInfo)
        {
            if (CommonUtil::checkStringForEmptyOrNull($channelId)) {
                throw new SDKException("ChannelId can not be null or empty");
            }
            elseif (CommonUtil::checkStringForEmptyOrNull($orderId)) {
                throw new SDKException("OrderId can not be null or empty");
            }
			elseif (CommonUtil::checkStringForEmptyOrNull($paymentMethod)) {
                throw new SDKException("PaymentMethod can not be null or empty");
            }
            elseif (!$transactionInfo instanceof TransactionInfo) {
                throw new SDKException("Transaction Info should be of type Waafipay\pg\models\TransactionInfo");
            }
			elseif (!$payerInfo instanceof PayerInfo) {
                throw new SDKException("Payer Info should be of type Waafipay\pg\models\PayerInfo");
            }
            else {
                $this->channelId = $channelId;
                $this->paymentMethod = $paymentMethod;
                $this->orderId = $orderId;
                $this->transactionInfo = $transactionInfo;
                $this->payerInfo = $payerInfo;
            }
        }

        /**
         * @return paymentDetail
         */
        public function build()
        {
            return new paymentDetail($this);
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
		
		public function setpayerInfo($payerInfo)
        {
            $this->payerInfo = $payerInfo;
        }

        
    }