<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\request;

    use JsonSerializable;
    use waafipay\pg\models\PayerInfo;
    use waafipay\pg\models\TransactionInfo;

    /**
     * Class InitiateTransactionRequestBody
     * @package Waafipay\pg\request
     */
    class InitiateTransactionRequestBody implements JsonSerializable
    {
        /**
         * @var string
         */
        private $requestType;
		
		/**
         * @var string
         */
        private $channelId;
		
		/**
         * @var string
         */
        private $schemaVersion;

        /**
         * @var string
         */
        private $apiid;
		
		/**
         * @var string
         */
        private $apikey;
		
		/**
         * @var string
         */
        private $mid;

        /**
         * @var string
         */
        private $orderId;

        /**
         * @var string
         */
        private $paymentMethod;

        
        /**
         * @var payerInfo
         */
        private $payerInfo;

        /**
         * @var transactionInfo
         */
        private $transactionInfo;

		
		/**
         * @return string
         */
        public function getapiid()
        {
            return $this->apiid;
        }

        /**
         * @param string $apiid
         */
        public function setapiid($apiid)
        {
            $this->apiid = $apiid;
        }
		
		/**
         * @return string
         */
        public function getapikey()
        {
            return $this->apikey;
        }

        /**
         * @param string $apikey
         */
        public function setapikey($apikey)
        {
            $this->apikey = $apikey;
        }
		
		/**
         * @return string
         */
        public function getchannelId()
        {
            return $this->channelId;
        }

        /**
         * @param string $channelId
         */
        public function setchannelId($channelId)
        {
            $this->channelId = $channelId;
        }
        
        /**
         * @return string
         */
        public function getRequestType()
        {
            return $this->requestType;
        }

        /**
         * @param string $requestType
         */
        public function setRequestType($requestType)
        {
            $this->requestType = $requestType;
        }
		
		/**
         * @return string
         */
        public function getschemaVersion()
        {
            return $this->schemaVersion;
        }

        /**
         * @param string $schemaVersion
         */
        public function setschemaVersion($schemaVersion)
        {
            $this->schemaVersion = $schemaVersion;
        }

        /**
         * @return string
         */
        public function getMid()
        {
            return $this->mid;
        }

        /**
         * @param string $mid
         */
        public function setMid($mid)
        {
            $this->mid = $mid;
        }

        /**
         * @return string
         */
        public function getOrderId()
        {
            return $this->orderId;
        }

        /**
         * @param string $orderId
         */
        public function setOrderId($orderId)
        {
            $this->orderId = $orderId;
        }

        

        /**
         * @return string
         */
        public function getpaymentMethod()
        {
            return $this->paymentMethod;
        }

        /**
         * @param string $paymentMethod
         */
        public function setpaymentMethod($paymentMethod)
        {
            $this->paymentMethod = $paymentMethod;
        }

        /**
         * @return payerInfo
         */
        public function getpayerInfo()
        {
            return $this->payerInfo;
        }

        /**
         * @param payerInfo $payerInfo
         */
        public function setpayerInfo($payerInfo)
        {
            $this->payerInfo = $payerInfo;
        }
		
		/**
         * @return transactionInfo
         */
        public function gettransactionInfo()
        {
            return $this->transactionInfo;
        }

        /**
         * @param transactionInfo $transactionInfo
         */
        public function settransactionInfo($transactionInfo)
        {
            $this->transactionInfo = $transactionInfo;
        }


        /**
         * @return array|mixed
         */
        public function jsonSerialize()
        {
			$serviceparam = [
				"merchantUid" => $this->getMid(),
				"apiUserId" => $this->getapiid(),
				"apiKey" => $this->getapikey(),
				"paymentMethod" => $this->getpaymentMethod(),
				"payerInfo" => $this->getpayerInfo(),
				"transactionInfo" => $this->gettransactionInfo(),
			];
            return
                [
                    'schemaVersion' => $this->getschemaVersion(),
                    'serviceName' => $this->getRequestType(),
                    'timestamp' => time(),
                    'requestId' => $this->getOrderId(),
                    'channelName' => $this->getchannelId(),
                    'serviceParams' => $serviceparam
                ];
        }
    }