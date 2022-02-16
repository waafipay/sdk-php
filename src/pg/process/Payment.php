<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\process;

    use Exception;
    use waafipay\merchant\models\PaymentDetail;
    use waafipay\merchant\models\PaymentHppDetail;
    use waafipay\merchant\models\PaymentHppResponseDetail;
    use waafipay\merchant\models\PaymentDetailCommit;
    use waafipay\merchant\models\PaymentRefund;
    use waafipay\merchant\models\SDKResponse;
    use waafipay\pg\constants\Config;
    use waafipay\pg\constants\LibraryConstants;
    use waafipay\pg\constants\MerchantProperties;
    use waafipay\pg\models\PayerInfo;
	use waafipay\pg\models\TransactionInfo;
	use waafipay\pg\models\ServiceParamsRefund;
	use waafipay\pg\models\ServiceParams;
    use waafipay\pg\request\InitiateTransactionRequest;
    use waafipay\pg\request\InitiateTransactionRequestBody;
    use waafipay\pg\request\NativePaymentStatusRequest;
    use waafipay\pg\request\NativePaymentStatusRequestBody;
    use waafipay\pg\request\SecureRequestHeader;
    use waafipay\pg\response\CommitInitiateTransactionResponse;
    use waafipay\pg\response\InitiateTransactionResponse;
    use waafipay\pg\response\InitiateTransactionResponseBody;
    use waafipay\pg\response\CommitInitiateTransactionResponseBody;
    use waafipay\pg\response\InitiateCommitTransactionRequestBody;
    use waafipay\pg\response\NativePaymentStatusResponse;
    use waafipay\pg\response\NativePaymentStatusResponseBody;
    use waafipay\pg\utils\CommonUtil;
    use waafipay\pg\utils\EncDecUtil;
    use waafipay\pg\utils\JSONUtil;
    use waafipay\pg\utils\LoggingUtil;
    use Psr\Log\LogLevel;

    /**
     * This class is used to validate the Api call on the basis of required parameters and create request object
     * and make respective function calls after setting signature, if required.
     *
     * Class Payment
     * @package waafipay\pg\process
     */
    class Payment
    {

        public static function CreateHppResultTxn($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentHppResponseDetail) {
                try {
                    Config::$requestId= CommonUtil::getUniqueRequestId();
                    if (!MerchantProperties::$isInitialized) {
                        LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "MerchantProperties are not initialized ");
                        throw new Exception("MerchantProperties are not initialized ");
                    }

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In CreateHppResultTxn PaymentDetail: " . print_r($paymentDetails, true));

                    self::validatePaymentHppResponseDetailsObject($paymentDetails);
                    $request = self::createInitiateHppTransactionRespRequest($paymentDetails);

                    $requestBody = $request->getBody();

                    $url = self::urlBuilder(MerchantProperties::getInitiateTxnUrl());
                    return Request::processHppResp($requestBody, $url,
                        'waafipay\pg\response\InitiateTransactionResponse', $paymentDetails->getReadTimeout(), MerchantProperties::getConnectionTimeout());

                } catch (Exception $e) {
                    LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "Exception caught in createTxnToken: " . print_r($e, true));
                    return CommonUtil::getSDKResponse($e, new InitiateTransactionResponse(null, new InitiateTransactionResponseBody()));
                }
            } else {
                $e = "Unexpected Object Passed";
                return CommonUtil::getSDKResponse($e, new InitiateTransactionResponse(null, new InitiateTransactionResponseBody()));
            }
        }

         /**
         * @param PaymentHppResponseDetail
         * @return InitiateTransactionRequest
         * @throws Exception
         */
        private static function createInitiateHppTransactionRespRequest($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentHppResponseDetail) {
                // $head = CommonUtil::getSecureRequestHeader(MerchantProperties::getmerchantUid(), null, $paymentDetails->getChannelId());
                $head = array();
                $body = $paymentDetails->createInitiateHppTransactionResponseBody();
                $request = new InitiateTransactionRequest($head, $body);
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "InitiateTransactionRequest object %s " . print_r($request, true));
                return $request;
            } else {
               throw new Exception("InitiateTransactionRequest object error");
            }
        }

        /**
         * validatePaymentHppResponseDetailsObject checks if all mandatory parameters are present for createTxnToken api call.
         * If not, then it will throw exception
         *
         * @param PaymentHppResponseDetail
         * @throws Exception
         */
        private static function validatePaymentHppResponseDetailsObject($paymentDetails)
        {
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "validatePaymentHppResponseDetailsObject for object: " . print_r($paymentDetails, true));
            if ($paymentDetails instanceof PaymentHppResponseDetail) {
                if (
                    CommonUtil::checkStringForEmptyOrNull($paymentDetails->getOrderId())
					|| CommonUtil::checkStringForEmptyOrNull($paymentDetails->gethppResultToken())) {

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validatePaymentHppResponseDetailsObject returns false ");
                    throw new Exception("validatePaymentHppResponseDetailsObject returns false");
                }
            } else {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In validatePaymentHppResponseDetailsObject, ");
                throw new Exception("In validatePaymentHppResponseDetailsObject");
            }
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validatePaymentHppResponseDetailsObject returns true ");
        }
        
        public static function CreateHppTxn($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentHppDetail) {
                try {
                    Config::$requestId= CommonUtil::getUniqueRequestId();
                    if (!MerchantProperties::$isInitialized) {
                        LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "MerchantProperties are not initialized ");
                        throw new Exception("MerchantProperties are not initialized ");
                    }

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In createTxn PaymentDetail: " . print_r($paymentDetails, true));

                    self::validatePaymentHppDetailsObject($paymentDetails);
                    $request = self::createInitiateHppTransactionRequest($paymentDetails);

                    $requestBody = $request->getBody();

                    $url = self::urlBuilder(MerchantProperties::getInitiateTxnUrl());
                    return Request::processHpp($requestBody, $url,
                        'waafipay\pg\response\InitiateTransactionResponse', $paymentDetails->getReadTimeout(), MerchantProperties::getConnectionTimeout());

                } catch (Exception $e) {
                    LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "Exception caught in createTxnToken: " . print_r($e, true));
                    return CommonUtil::getSDKResponse($e, new InitiateTransactionResponse(null, new InitiateTransactionResponseBody()));
                }
            } else {
                $e = "Unexpected Object Passed";
                return CommonUtil::getSDKResponse($e, new InitiateTransactionResponse(null, new InitiateTransactionResponseBody()));
            }
        }
		
		public static function CreateTxn($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentDetail) {
                try {
                    Config::$requestId= CommonUtil::getUniqueRequestId();
                    if (!MerchantProperties::$isInitialized) {
                        LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "MerchantProperties are not initialized ");
                        throw new Exception("MerchantProperties are not initialized ");
                    }

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In createTxn PaymentDetail: " . print_r($paymentDetails, true));

                    self::validatePaymentDetailsObject($paymentDetails);
                    $request = self::createInitiateTransactionRequest($paymentDetails);

                    $requestBody = $request->getBody();

                    $url = self::urlBuilder(MerchantProperties::getInitiateTxnUrl());
                    return Request::process($requestBody, $url,
                        'waafipay\pg\response\InitiateTransactionResponse', $paymentDetails->getReadTimeout(), MerchantProperties::getConnectionTimeout());

                } catch (Exception $e) {
                    LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "Exception caught in createTxnToken: " . print_r($e, true));
                    return CommonUtil::getSDKResponse($e, new InitiateTransactionResponse(null, new InitiateTransactionResponseBody()));
                }
            } else {
                $e = "Unexpected Object Passed";
                return CommonUtil::getSDKResponse($e, new InitiateTransactionResponse(null, new InitiateTransactionResponseBody()));
            }
        }
		
		
		public static function CreateCommitTxn($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentDetailCommit) {
                try {
                    if (!MerchantProperties::$isInitialized) {
                        LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "MerchantProperties are not initialized ");
                        throw new Exception("MerchantProperties are not initialized ");
                    }

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In createTxnCommit PaymentDetail: " . print_r($paymentDetails, true));

                    self::validateCommitPaymentDetailsObject($paymentDetails);
                    $request = self::createInitiateCommTransactionRequest($paymentDetails);

                    $requestBody = $request->getBody();

                    $url = self::urlBuilder(MerchantProperties::getInitiateTxnUrl());
                    return Request::processCommit($requestBody, $url,
                        'waafipay\pg\response\CommitInitiateTransactionResponse', $paymentDetails->getReadTimeout(), MerchantProperties::getConnectionTimeout());

                } catch (Exception $e) {
                    LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "Exception caught in createTxnCommit: " . print_r($e, true));
                    return CommonUtil::getSDKResponse($e, new CommitInitiateTransactionResponse(null, new CommitInitiateTransactionResponseBody()));
                }
            } else {
                $e = "Unexpected Object Passed";
                return CommonUtil::getSDKResponse($e, new CommitInitiateTransactionResponse(null, new CommitInitiateTransactionResponseBody()));
            }
        }
		
		
		public static function CreateCancelCommitTxn($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentDetailCommit) {
                try {
                    if (!MerchantProperties::$isInitialized) {
                        LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "MerchantProperties are not initialized ");
                        throw new Exception("MerchantProperties are not initialized ");
                    }

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In createCancelCommitTxn PaymentDetail: " . print_r($paymentDetails, true));

                    self::validateCommitPaymentDetailsObject($paymentDetails);
                    $request = self::createInitiateCancelCommTransactionRequest($paymentDetails);

                    $requestBody = $request->getBody();

                    $url = self::urlBuilder(MerchantProperties::getInitiateTxnUrl());
                    return Request::processCommit($requestBody, $url,
                        'waafipay\pg\response\CommitInitiateTransactionResponse', $paymentDetails->getReadTimeout(), MerchantProperties::getConnectionTimeout());

                } catch (Exception $e) {
                    LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "Exception caught in createCancelCommitTxn: " . print_r($e, true));
                    return CommonUtil::getSDKResponse($e, new CommitInitiateTransactionResponse(null, new CommitInitiateTransactionResponseBody()));
                }
            } else {
                $e = "Unexpected Object Passed";
                return CommonUtil::getSDKResponse($e, new CommitInitiateTransactionResponse(null, new CommitInitiateTransactionResponseBody()));
            }
        }
		
		
		public static function CreatePurchaseCancelTxn($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentDetailCommit) {
                try {
                    if (!MerchantProperties::$isInitialized) {
                        LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "MerchantProperties are not initialized ");
                        throw new Exception("MerchantProperties are not initialized ");
                    }

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In createPurchaseCancelTxn PaymentDetail: " . print_r($paymentDetails, true));

                    self::validateCommitPaymentDetailsObject($paymentDetails);
                    $request = self::createPurchaseCancelTransactionRequest($paymentDetails);

                    $requestBody = $request->getBody();

                    $url = self::urlBuilder(MerchantProperties::getInitiateTxnUrl());
                    return Request::processCommit($requestBody, $url,
                        'waafipay\pg\response\CommitInitiateTransactionResponse', $paymentDetails->getReadTimeout(), MerchantProperties::getConnectionTimeout());

                } catch (Exception $e) {
                    LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "Exception caught in createCancelCommitTxn: " . print_r($e, true));
                    return CommonUtil::getSDKResponse($e, new CommitInitiateTransactionResponse(null, new CommitInitiateTransactionResponseBody()));
                }
            } else {
                $e = "Unexpected Object Passed";
                return CommonUtil::getSDKResponse($e, new CommitInitiateTransactionResponse(null, new CommitInitiateTransactionResponseBody()));
            }
        }
		
		
		public static function CreateRefundTxn($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentRefund) {
                try {
                    if (!MerchantProperties::$isInitialized) {
                        LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "MerchantProperties are not initialized ");
                        throw new Exception("MerchantProperties are not initialized ");
                    }

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In createRefundTxn PaymentDetail: " . print_r($paymentDetails, true));

                    self::validateRefundDetailsObject($paymentDetails);
                    $request = self::createRefundTransactionRequest($paymentDetails);

                    $requestBody = $request->getBody();

                    $url = self::urlBuilder(MerchantProperties::getInitiateTxnUrl());
                    return Request::processCommit($requestBody, $url,
                        'waafipay\pg\response\CommitInitiateTransactionResponse', $paymentDetails->getReadTimeout(), MerchantProperties::getConnectionTimeout());

                } catch (Exception $e) {
                    LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "Exception caught in createCancelCommitTxn: " . print_r($e, true));
                    return CommonUtil::getSDKResponse($e, new CommitInitiateTransactionResponse(null, new CommitInitiateTransactionResponseBody()));
                }
            } else {
                $e = "Unexpected Object Passed";
                return CommonUtil::getSDKResponse($e, new CommitInitiateTransactionResponse(null, new CommitInitiateTransactionResponseBody()));
            }
        }
		
		
		private static function validateRefundDetailsObject($paymentDetails)
        {
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "validateRefundDetailsObject for object: " . print_r($paymentDetails, true));
            if ($paymentDetails instanceof PaymentRefund) {
                $serviceParams = $paymentDetails->getserviceParams();
                if (
                    (!$serviceParams instanceof ServiceParamsRefund)
                    || CommonUtil::checkStringForEmptyOrNull($serviceParams->gettransactionId())
					|| CommonUtil::checkStringForEmptyOrNull($serviceParams->getdescription())
					|| CommonUtil::checkStringForEmptyOrNull($serviceParams->getreferenceId())
					|| CommonUtil::checkStringForEmptyOrNull($serviceParams->getamount())
					) {

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validateRefundDetailsObject returns false ");
                    throw new Exception("validateRefundDetailsObject returns false");
                }
            } else {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In validateRefundDetailsObject, ");
                throw new Exception("In validateRefundDetailsObject");
            }
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validateRefundDetailsObject returns true ");
        }


        /**
         * validateCreateTxnToken checks if all mandatory parameters are present for createTxnToken api call.
         * If not, then it will throw exception
         *
         * @param PaymentHppDetail
         * @throws Exception
         */
        private static function validatePaymentHppDetailsObject($paymentDetails)
        {
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "validatePaymentHppDetailsObject for object: " . print_r($paymentDetails, true));
            if ($paymentDetails instanceof PaymentHppDetail) {
                $transactionInfo = $paymentDetails->gettransactionInfo();
                if (
                    CommonUtil::checkStringForEmptyOrNull($paymentDetails->getOrderId())
					|| (!$transactionInfo instanceof TransactionInfo)
                    || CommonUtil::checkStringForEmptyOrNull($transactionInfo->getreferenceId())
					|| CommonUtil::checkStringForEmptyOrNull($transactionInfo->getinvoiceId())
					|| CommonUtil::checkStringForEmptyOrNull($transactionInfo->getamount())
					|| CommonUtil::checkStringForEmptyOrNull($transactionInfo->getdescription())
					|| CommonUtil::checkStringForEmptyOrNull($transactionInfo->getcurrency())) {

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validatePaymentHppDetailsObject returns false ");
                    throw new Exception("validatePaymentHppDetailsObject returns false");
                }
            } else {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In validatePaymentHppDetailsObject, ");
                throw new Exception("In validatePaymentHppDetailsObject");
            }
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validatePaymentHppDetailsObject returns true ");
        }

        
        /**
         * validateCreateTxnToken checks if all mandatory parameters are present for createTxnToken api call.
         * If not, then it will throw exception
         *
         * @param PaymentDetail
         * @throws Exception
         */
        private static function validatePaymentDetailsObject($paymentDetails)
        {
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "validatePaymentDetailsObject for object: " . print_r($paymentDetails, true));
            if ($paymentDetails instanceof PaymentDetail) {
                $payerInfo = $paymentDetails->getpayerInfo();
                $transactionInfo = $paymentDetails->gettransactionInfo();
                if (
                    CommonUtil::checkStringForEmptyOrNull($paymentDetails->getOrderId())
                    || (!$payerInfo instanceof PayerInfo)
                    || CommonUtil::checkStringForEmptyOrNull($payerInfo->getaccountNo())
					|| CommonUtil::checkStringForEmptyOrNull($payerInfo->getaccountPwd())
					|| (!$transactionInfo instanceof TransactionInfo)
                    || CommonUtil::checkStringForEmptyOrNull($transactionInfo->getreferenceId())
					|| CommonUtil::checkStringForEmptyOrNull($transactionInfo->getinvoiceId())
					|| CommonUtil::checkStringForEmptyOrNull($transactionInfo->getamount())
					|| CommonUtil::checkStringForEmptyOrNull($transactionInfo->getdescription())
					|| CommonUtil::checkStringForEmptyOrNull($transactionInfo->getcurrency())) {

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validatePaymentDetailsObject returns false ");
                    throw new Exception("validatePaymentDetailsObject returns false");
                }
            } else {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In validatePaymentDetailsObject, ");
                throw new Exception("In validatePaymentDetailsObject");
            }
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validatePaymentDetailsObject returns true ");
        }
		
		
		private static function validateCommitPaymentDetailsObject($paymentDetails)
        {
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "validateCommitPaymentDetailsObject for object: " . print_r($paymentDetails, true));
            if ($paymentDetails instanceof PaymentDetailCommit) {
                $serviceParams = $paymentDetails->getserviceParams();
                if (
                    (!$serviceParams instanceof ServiceParams)
                    || CommonUtil::checkStringForEmptyOrNull($serviceParams->gettransactionId())
					|| CommonUtil::checkStringForEmptyOrNull($serviceParams->getdescription())
					|| CommonUtil::checkStringForEmptyOrNull($serviceParams->getreferenceId())
					) {

                    LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validateCommitPaymentDetailsObject returns false ");
                    throw new Exception("validateCommitPaymentDetailsObject returns false");
                }
            } else {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In validateCommitPaymentDetailsObject, ");
                throw new Exception("In validateCommitPaymentDetailsObject");
            }
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, " validateCommitPaymentDetailsObject returns true ");
        }

        /**
         * @param PaymentHppDetail
         * @return InitiateTransactionRequest
         * @throws Exception
         */
        private static function createInitiateHppTransactionRequest($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentHppDetail) {
                // $head = CommonUtil::getSecureRequestHeader(MerchantProperties::getmerchantUid(), null, $paymentDetails->getChannelId());
                $head = array();
                $body = $paymentDetails->createInitiateHppTransactionRequestBody();
                $request = new InitiateTransactionRequest($head, $body);
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "InitiateTransactionRequest object %s " . print_r($request, true));
                return $request;
            } else {
               throw new Exception("InitiateTransactionRequest object error");
            }
        }

        /**
         * @param PaymentDetail
         * @return InitiateTransactionRequest
         * @throws Exception
         */
        private static function createInitiateTransactionRequest($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentDetail) {
                // $head = CommonUtil::getSecureRequestHeader(MerchantProperties::getmerchantUid(), null, $paymentDetails->getChannelId());
                $head = array();
                $body = $paymentDetails->createInitiateTransactionRequestBody();
                $request = new InitiateTransactionRequest($head, $body);
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "InitiateTransactionRequest object %s " . print_r($request, true));
                return $request;
            } else {
               throw new Exception("InitiateTransactionRequest object error");
            }
        }
		
		
		private static function createInitiateCommTransactionRequest($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentDetailCommit) {
                // $head = CommonUtil::getSecureRequestHeader(MerchantProperties::getmerchantUid(), null, $paymentDetails->getChannelId());
                $head = array();
                $body = $paymentDetails->createInitiateTransactionRequestBody();
                $request = new InitiateTransactionRequest($head, $body);
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "InitiateTransactionRequest object %s " . print_r($request, true));
                return $request;
            } else {
               throw new Exception("InitiateTransactionRequest object error");
            }
        }
		
		
		private static function createInitiateCancelCommTransactionRequest($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentDetailCommit) {
                // $head = CommonUtil::getSecureRequestHeader(MerchantProperties::getmerchantUid(), null, $paymentDetails->getChannelId());
                $head = array();
                $body = $paymentDetails->createCancelTransactionRequestBody();
                $request = new InitiateTransactionRequest($head, $body);
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "InitiateTransactionRequest object %s " . print_r($request, true));
                return $request;
            } else {
               throw new Exception("InitiateTransactionRequest object error");
            }
        }
		
		
		private static function createPurchaseCancelTransactionRequest($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentDetailCommit) {
                // $head = CommonUtil::getSecureRequestHeader(MerchantProperties::getmerchantUid(), null, $paymentDetails->getChannelId());
                $head = array();
                $body = $paymentDetails->createPCancelTransactionRequestBody();
                $request = new InitiateTransactionRequest($head, $body);
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "InitiateTransactionRequest object %s " . print_r($request, true));
                return $request;
            } else {
               throw new Exception("InitiateTransactionRequest object error");
            }
        }
		
		
		private static function createRefundTransactionRequest($paymentDetails)
        {
            if ($paymentDetails instanceof PaymentRefund) {
                // $head = CommonUtil::getSecureRequestHeader(MerchantProperties::getmerchantUid(), null, $paymentDetails->getChannelId());
                $head = array();
                $body = $paymentDetails->createRefundRequestBody();
                $request = new InitiateTransactionRequest($head, $body);
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "InitiateTransactionRequest object %s " . print_r($request, true));
                return $request;
            } else {
               throw new Exception("InitiateTransactionRequest object error");
            }
        }

        
        

        /**
         * Returns the url string with adding queryParameters
         *
         * @param $url
         * @param $mid
         * @param $orderId
         * @return string
         */
        private static function urlBuilder($url)
        {
            return $url;
        }
    }
