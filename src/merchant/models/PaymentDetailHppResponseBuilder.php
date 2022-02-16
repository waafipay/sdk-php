<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */
	namespace waafipay\merchant\models;
    
    
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