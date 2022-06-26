<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    
    namespace waafipay\merchant\models;

    use waafipay\merchant\models\PaymentRefund;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\models\ServiceParamsRefund;
    use waafipay\pg\utils\CommonUtil;

    /**
     * PaymentRefundlBuilder is used to build the PaymentRefund object
     *
     * Class PaymentRefundlBuilder
     * @package Waafipay\merchant\models\PaymentRefundlBuilder
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
                throw new SDKException("ServiceParams Info should be of type Waafipay\pg\models\ServiceParamsRefund");
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
