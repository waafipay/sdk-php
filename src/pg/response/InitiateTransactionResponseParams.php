<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\response;

    /**
     * Class InitiateTransactionResponseParams
     * @package waafipay\pg\response
     */
    class InitiateTransactionResponseParams extends BaseResponseBody
    {
        		
		/**
         * @var string
         */
        private $transactionId;

        /**
         * @var string
         */
        private $referenceId;

        /**
         * @var string
         */
        private $state;

        
        /**
         * @var string
         */
        private $description;
		
		/**
         * @var string
         */
        private $txAmount;

        /**
         * waafipay\pg\response\InitiateTransactionResponseParams constructor.
         */
        public function __construct()
        {
        }
		
		
		/**
         * @return string
         */
        public function gettxAmount()
        {
            return $this->txAmount;
        }

        /**
         * @param string $txAmount
         */
        public function settxAmount($txAmount)
        {
            $this->txAmount = $txAmount;
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
         * @return string
         */
        public function getstate()
        {
            return $this->state;
        }

        /**
         * @param string $state
         */
        public function setstate($state)
        {
            $this->state = $state;
        }
		
		
		
        /**
         * @return array|mixed
         */
        public function jsonSerialize()
        {
            return
                [
					"state" => $this->getstate(),
					"referenceId" => $this->getreferenceId(),
					"transactionId" => $this->gettransactionId(),
					"description" => $this->getdescription(),
					"txAmount" => $this->gettxAmount(),
                ];
        }
    }