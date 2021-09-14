<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\models;

    use JsonSerializable;
	use waafipay\pg\constants\MerchantProperties;

    /**
     * Class ServiceParamsRefund
     * @package Waafipay\pg\models
     */
    class ServiceParamsRefund implements JsonSerializable
    {
		
		/**
         * @var string
         */
        private $amount;

        /**
         * @var string
         */
        private $transactionId;

        /**
         * @var string
         */
        private $description;

        /**
         * @var string
         */
        private $referenceId;
		
		/**
         * @return string
         */
        public function getamount()
        {
            return $this->amount;
        }

        /**
         * @param string $amount
         */
        public function setamount($amount)
        {
            $this->amount = $amount;
        }
	
        
        /**
         * @return string
         */
        public function gettransactionId()
        {
            return $this->transactionId;
        }

        /**
         * @param string $transactionId
         */
        public function settransactionId($transactionId)
        {
            $this->transactionId = $transactionId;
        }

        /**
         * @return string
         */
        public function getdescription()
        {
            return $this->description;
        }

        /**
         * @param string $description
         */
        public function setdescription($description)
        {
            $this->description = $description;
        }

        /**
         * @return string
         */
        public function getreferenceId()
        {
            return $this->referenceId;
        }

        /**
         * @param string $referenceId
         */
        public function setreferenceId($referenceId)
        {
            $this->referenceId = $referenceId;
        }

                

        /**
         * Waafipay\pg\models\PayerInfo constructor.
         */
        public function __construct()
        {
            
        }

        /**
         * @return array|mixed
         */
        public function jsonSerialize()
        {
            return
                [
						'merchantUid' => MerchantProperties::getmerchantUid(),
						'apiUserId' => MerchantProperties::getapiUserId(),
						'apiKey' => MerchantProperties::getapiKey(),		
						'transactionId' => $this->gettransactionId(),
						'description' => $this->getdescription(),
						'amount' => $this->getamount(),
						'referenceId' => $this->getreferenceId()
					
                ];
        }
    }
