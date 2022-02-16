<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\models;

    use JsonSerializable;

    /**
     * Class PayerInfo
     * @package Waafipay\pg\models
     */
    class PayerInfo implements JsonSerializable
    {

        /**
         * @var string
         */
        private $accountNo;

        /**
         * @var string
         */
        private $accountPwd;

        /**
         * @var string
         */
        private $accountExpDate;

        /**
         * @var string
         */
        private $accountHolder;


        /**
         * @return string
         */
        public function getaccountNo()
        {
            return $this->accountNo;
        }

        /**
         * @param string $accountNo
         */
        public function setaccountNo($accountNo)
        {
            $this->accountNo = $accountNo;
        }

        /**
         * @return string
         */
        public function getaccountPwd()
        {
            return $this->accountPwd;
        }

        /**
         * @param string $accountPwd
         */
        public function setaccountPwd($accountPwd)
        {
            $this->accountPwd = $accountPwd;
        }

        /**
         * @return string
         */
        public function getaccountExpDate()
        {
            return $this->accountExpDate;
        }

        /**
         * @param string $accountExpDate
         */
        public function setaccountExpDate($accountExpDate)
        {
            $this->accountExpDate = $accountExpDate;
        }

        /**
         * @return string
         */
        public function getaccountHolder()
        {
            return $this->accountHolder;
        }

        /**
         * @param string $accountHolder
         */
        public function setaccountHolder($accountHolder)
        {
            $this->accountHolder = $accountHolder;
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
						'accountNo' => $this->getaccountNo(),
						'accountPwd' => $this->getaccountPwd(),
						'accountExpDate' => $this->getaccountExpDate(),
						'accountHolder' => $this->getaccountHolder()
					
                ];
        }
    }
