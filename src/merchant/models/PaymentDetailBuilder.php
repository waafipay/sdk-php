<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    
    namespace waafipay\merchant\models;

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
        public function __construct($channelId, $paymentMethod, $transactionInfo, $payerInfo)
        {
            if (CommonUtil::checkStringForEmptyOrNull($channelId)) {
                throw new SDKException("ChannelId can not be null or empty");
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
                $this->orderId = 'RPHWP'.time();
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