<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\models;

    use JsonSerializable;

    /**
     * Class TransactionInfo
     * @package Waafipay\pg\models
     */
    class TransactionInfo implements JsonSerializable
    {

        /**
         * @var string
         */
        private $referenceId;

        /**
         * @var string
         */
        private $invoiceId;

        /**
         * @var string
         */
        private $amount;

        /**
         * @var string
         */
        private $currency;
		
		/**
         * @var string
         */
        private $description;


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
        public function getinvoiceId()
        {
            return $this->invoiceId;
        }

        /**
         * @param string $invoiceId
         */
        public function setinvoiceId($invoiceId)
        {
            $this->invoiceId = $invoiceId;
        }

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
        public function getcurrency()
        {
            return $this->currency;
        }

        /**
         * @param string $currency
         */
        public function setcurrency($currency)
        {
            $this->currency = $currency;
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
         * Waafipay\pg\models\TransactionInfo constructor.
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
					
						'referenceId' => $this->getreferenceId(),
						'invoiceId' => $this->getinvoiceId(),
						'amount' => $this->getamount(),
						'currency' => $this->getcurrency(),
						'description' => $this->getdescription()
					
                ];
        }
    }
