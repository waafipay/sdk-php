<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\response;

    /**
     * Class InitiateTransactionResponseBody
     * @package waafipay\pg\response
     */
    class InitiateTransactionResponseBody extends BaseResponseBody
    {
        
		/**
         * @var string
         */
        private $schemaVersion;
		
		/**
         * @var string
         */
        private $timestamp;
		
		/**
         * @var string
         */
        private $requestId;
		
		/**
         * @var string
         */
        private $responseCode;
		
		/**
         * @var string
         */
        private $responseMsg;
		
		/**
         * @var string
         */
        private $errorCode;
		
		
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
         * waafipay\pg\response\InitiateTransactionResponseBody constructor.
         */
        public function __construct()
        {
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
        public function gettimestamp()
        {
            return $this->timestamp;
        }

        /**
         * @param string $timestamp
         */
        public function settimestamp($timestamp)
        {
            $this->timestamp = $timestamp;
        }
		
		
		/**
         * @return string
         */
        public function getrequestId()
        {
            return $this->requestId;
        }

        /**
         * @param string $requestId
         */
        public function setrequestId($requestId)
        {
            $this->requestId = $requestId;
        }
		
		
		/**
         * @return string
         */
        public function getresponseCode()
        {
            return $this->responseCode;
        }

        /**
         * @param string $responseCode
         */
        public function setresponseCode($responseCode)
        {
            $this->responseCode = $responseCode;
        }
		
		
		/**
         * @return string
         */
        public function getresponseMsg()
        {
            return $this->responseMsg;
        }

        /**
         * @param string $responseMsg
         */
        public function setresponseMsg($responseMsg)
        {
            $this->responseMsg = $responseMsg;
        }
		
		/**
         * @return string
         */
        public function geterrorCode()
        {
            return $this->errorCode;
        }

        /**
         * @param string $errorCode
         */
        public function seterrorCode($errorCode)
        {
            $this->errorCode = $errorCode;
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
         * @return array|mixed
         */
        public function jsonSerialize()
        {
			$params = [
				 "state" => $this->getstate(),
				 "referenceId" => $this->getreferenceId(),
				 "transactionId" => $this->gettransactionId(),
				 "description" => $this->getdescription(),
				 "txAmount" => $this->gettxAmount(),
			];
            return
                [
                    'schemaVersion' => $this->getschemaVersion(),
                    'timestamp' => $this->gettimestamp(),
                    'requestId' => $this->getrequestId(),
                    'responseCode' => $this->getresponseCode(),
                    'responseMsg' => $this->getresponseMsg(),
                    'errorCode' => $this->geterrorCode(),
                    'params' => $params
                ];
        }
    }