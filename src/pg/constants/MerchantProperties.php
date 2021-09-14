<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\constants;

    use Exception;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\utils\CommonUtil;
    use waafipay\pg\utils\LoggingUtil;
    use Psr\Log\LogLevel;

    /**
     * This class is used to store all the merchant related constants
     * that are common to all payments and orders
     *
     * Class MerchantProperties
     * @package Waafipay\pg\constants
     */
    class MerchantProperties
    {
        /**
         * @var bool
         */
        static $isInitialized = false;

        // TEST for Testing and PROD for Production.
        /**
         * @var string
         * ENVIRONMENT is used to set URLs(TESTING or PRODUCTION)
         */
        private static $environment = LibraryConstants::STAGING_ENVIRONMENT;

        /**
         * @var int
         * timeout constants
         */
        private static $connectTimeout = 30000; // 30 * 1000

        /**
         * @var string
         */
        private static $apiUserId;
		
        /**
         * @var string
         */
        private static $merchantUid;
		
		
        /**
         * @var string
         */
        private static $apiKey;
		
		
		/**
		* @var string $callbackUrl callback url on which Waafipay will respond for api calls
		*/
        private static $callbackUrl = "";

        /** URLs */
        /**
         * @var string
         */
        private static $initiateTxnUrl = "https://sandbox.safarifoneict.com/asm";
        
        
        public static function initialize($environment, $apiUserId, $merchantUid, $apiKey)
        {
            if (!self::$isInitialized) {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "initialize called");

                if (CommonUtil::checkStringForEmptyOrNull($environment)) {
                    throw new SDKException("Environment can not be null or empty");
                }
                elseif (CommonUtil::checkStringForEmptyOrNull($apiUserId)) {
                    throw new SDKException("apiUserId can not be null or empty");
                }
                elseif (CommonUtil::checkStringForEmptyOrNull($merchantUid)) {
                    throw new SDKException("merchant Uid can not be null or empty");
                }
                elseif (CommonUtil::checkStringForEmptyOrNull($apiKey)) {
                    throw new SDKException("apiKey can not be null or empty");
                }
                else {
                    self::$isInitialized = true;
                    self::setEnvironment($environment);
                    self::setapiUserId($apiUserId);
                    self::setmerchantUid($merchantUid);
                    self::setapiKey($apiKey);
                }
            }
        }

        /**
         * @return string
         */
        public static function getEnvironment()
        {
            return self::$environment;
        }

        /**
         * @return string
         */
        public static function getapiUserId()
        {
            return self::$apiUserId;
        }

        /**
         * @return string
         */
        public static function getmerchantUid()
        {
            return self::$merchantUid;
        }

        /**
         * @return string
         */
        public static function getapiKey()
        {
            return self::$apiKey;
        }

        /**
         * @return string
         */
        public static function getCallbackUrl()
        {
            return self::$callbackUrl;
        }

        /**
         * @return string
         */
        public static function getInitiateTxnUrl()
        {
            return self::$initiateTxnUrl;
        }


        /**
         * @return int
         */
        public static function getConnectionTimeout()
        {
            return self::$connectTimeout;
        }

        /**
         * @param int $connectionTimeout
         */
        public static function setConnectionTimeout($connectionTimeout)
        {
            self::$connectTimeout = $connectionTimeout;
        }

        /**
         * @param string $apiUserId
         */
        public static function setapiUserId($apiUserId)
        {
            self::$apiUserId = $apiUserId;
        }

        /**
         * @param string $merchantUid
         */
        public static function setmerchantUid($merchantUid)
        {
            self::$merchantUid = $merchantUid;
        }


        /**
         * @param string $apiKey
         */
        public static function setapiKey($apiKey)
        {
            self::$apiKey = $apiKey;
        }

        /**
         * @param string $callbackUrl
         */
        public static function setCallbackUrl($callbackUrl)
        {
            self::$callbackUrl = $callbackUrl;
        }

        /**
         * @param string $environment
         * @throws Exception
         */
        public static function setEnvironment($environment)
        {
            self::$environment = $environment;
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "Setting Environment for " . $environment);
            if ($environment === LibraryConstants::PRODUCTION_ENVIRONMENT) {
                self::$initiateTxnUrl   = "https://sandbox.safarifoneict.com/asm";
            }
        }
    }