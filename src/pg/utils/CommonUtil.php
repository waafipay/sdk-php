<?php
    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\utils;

    use Exception;
    use waafipay;
    use waafipay\merchant\models\SDKResponse;
    use waafipay\pg\constants\ErrorConstants;
    use waafipay\pg\constants\LibraryConstants;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\request\SecureRequestHeader;
    use waafipay\pg\response\AsyncRefundResponse;
    use waafipay\pg\response\InitiateTransactionResponse;
    use waafipay\pg\response\interfaces\Response;
    use waafipay\pg\response\NativePaymentStatusResponse;
    use waafipay\pg\response\NativeRefundStatusResponse;
    use waafipay\pg\response\ResultInfo;
    use Psr\Log\LogLevel;

    /**
     * This class performs common task for making waafipay's api calls
     *
     * Class CommonUtil
     * @package waafipay\pg\utils
     */
    class CommonUtil
    {

        /**
         * @param Exception                                                                                              $e
         * @param InitiateTransactionResponse|NativePaymentStatusResponse|AsyncRefundResponse|NativeRefundStatusResponse $obj
         * @return SDKResponse
         * @throws Exception
         */
        public static function getSDKResponse($e, $obj)
        {

            LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "getSDKResponse with exception : " . $e);

            $result = new ResultInfo();

            $result->setResultStatus(ErrorConstants::FAILURE);
            $result->setResultCode(ErrorConstants\ErrorCode::DEFAULT_CODE);
            $result->setResultMsg($e->getMessage());

            if ($obj instanceof Response) {
                $obj->getBody()->setResultInfo($result);
            }

            if ($e instanceof SDKException) {
                LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, 'Exception instanceof SDKException with rawData : ' . $e->getRawdata());
                return new SDKResponse($obj, $e->getRawdata());
            }

            return new SDKResponse($obj, null);
        }

        /**
         * @param string $clientId
         * @param string $workFlow
         * @param string $channelId
         * @return SecureRequestHeader returns SecureRequestHeader object
         * @throws Exception
         */
        public static function getSecureRequestHeader($clientId, $channelId)
        {

            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "In getSecureRequestHeader()");

            $secureRequestHeader = new SecureRequestHeader();
            $secureRequestHeader->setVersion(LibraryConstants::VERSION);
            $secureRequestHeader->setChannelId($channelId);
            $secureRequestHeader->setRequestTimestamp(date('Y-m-d h:i:s T'));
            $secureRequestHeader->setClientId($clientId);
            $secureRequestHeader->setSignature(null);

            return $secureRequestHeader;
        }

        /**
         * @param string $param
         * @return bool
         */
        public static function checkStringForEmptyOrNull($param)
        {

            /** CASE1: Empty string
             *  CASE2: Null value
             *  CASE3: Whitespaces
             */
            if (!is_string($param) || empty($param) || empty(trim($param))) {
                return true;
            }

            /** CASE4: valid string value */
            return false;
        }

        /**
         * @return string
         */
        public static function getUniqueRequestId()
        {
            return LibraryConstants::PHP_SDK_TEXT . ":" . LibraryConstants::PHP_SDK_VERSION . ":" . UUID::v4();
        }
    }