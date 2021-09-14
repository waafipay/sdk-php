<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */
	/* this is just a comment*/
    namespace waafipay\pg\process;

    use Exception;
    use waafipay\merchant\models\SDKResponse;
    use waafipay\pg\constants\Config;
    use waafipay\pg\constants\ErrorConstants\ErrorMessage;
    use waafipay\pg\constants\LibraryConstants;
    use waafipay\pg\constants\MerchantProperties;
    use waafipay\pg\exceptions\SDKException;
    use waafipay\pg\response\AsyncRefundResponse;
    use waafipay\pg\response\AsyncRefundResponseBody;
    use waafipay\pg\response\InitiateTransactionResponse;
    use waafipay\pg\response\CommitInitiateTransactionResponse;
    use waafipay\pg\response\CommitInitiateTransactionResponseBody;
    use waafipay\pg\response\InitiateTransactionResponseBody;
    use waafipay\pg\response\NativePaymentStatusResponse;
    use waafipay\pg\response\NativePaymentStatusResponseBody;
    use waafipay\pg\response\NativeRefundStatusResponse;
    use waafipay\pg\response\NativeRefundStatusResponseBody;
    use waafipay\pg\response\SecureResponseHeader;
    use waafipay\pg\utils\EncDecUtil;
    use waafipay\pg\utils\JSONUtil;
    use waafipay\pg\utils\LoggingUtil;
    use Psr\Log\LogLevel;

    if (!defined('CURL_SSLVERSION_TLSv1_2')) {
        define('CURL_SSLVERSION_TLSv1_2', '6');
    }

    /**
     * This class receives request from Payment class and Request class for hitting the waafipay apis with the received request attributes.
     *
     * Class Request
     * @package Waafipay\pg\process
     */
    class Request
    {

        /**
         * @param $request
         * @param $url
         * @param $responseClassName
         * @param $readTimeout
         * @param $connTimeout
         * @return SDKResponse
         * @throws Exception
         */
        public static function process($request, $url, $responseClassName, $readTimeout, $connTimeout)
        {
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "process for request: " . print_r($request, true));
            $formattedJsonReq = JSONUtil::mapToJson($request);

            // echo "\n\nJson formatted request body: ";
             // echo '<pre>'; print_r($formattedJsonReq);
			 // die();
            $rawJsonResponse = self::executeCurl($url, $formattedJsonReq, $readTimeout, $connTimeout);
			$rawjarr = json_decode($rawJsonResponse, true);
			$rawJsonResponse = array();
			$rawJsonResponse["schemaVersion"] = $rawjarr['schemaVersion'];
			$rawJsonResponse["timestamp"] = $rawjarr['timestamp'];
			$rawJsonResponse["requestId"] = $rawjarr['requestId'];
			$rawJsonResponse["responseCode"] = $rawjarr['responseCode'];
			$rawJsonResponse["responseMsg"] = $rawjarr['responseMsg'];
			$rawJsonResponse["errorCode"] = $rawjarr['errorCode'];
			$rawJsonResponse["sessionId"] = $rawjarr['sessionId'];
			$farray = array_merge($rawjarr['params'],$rawJsonResponse);
			$rawJsonResponse = json_encode($farray);
			
			
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "response: " . $rawJsonResponse);

            if ($responseClassName == 'waafipay\pg\response\InitiateTransactionResponse') {
                $responseObj = new InitiateTransactionResponse([],new InitiateTransactionResponseBody());
            }
			
			$respbody = $responseObj->getBody();
			
            
            JSONUtil::mapResponseJsonToObject($rawJsonResponse, $respbody);
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "responseData: " . print_r($responseObj, true));
			//echo '<pre>'; print_r($responseObj);
            // echo '<pre>'; print_r($respbody);
			//die();
            $responseObjBody = $responseObj->getBody();
			$transactionId = $responseObjBody->gettransactionId();
			// echo '<pre>'; print_r($responseObjBody);
			// die();
			$responseMsg = $responseObjBody->getresponseMsg();
			
            if ($transactionId == null || empty($transactionId)) {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, $responseMsg .
                    "as responseData->getBody is null and raw json received is: " . $rawJsonResponse);
                throw new Exception($responseMsg);
            }

            
            $resultInfo = $responseObjBody->getresponseCode();
            $resultStatus = $responseObjBody->getresponseMsg();

            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "Execution completed with raw json response: " . $rawJsonResponse);
            return new SDKResponse($responseObj, $rawJsonResponse);
        }
		
		
		public static function processCommit($request, $url, $responseClassName, $readTimeout, $connTimeout)
        {
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "process for request: " . print_r($request, true));
            $formattedJsonReq = JSONUtil::mapToJson($request);

            // echo "\n\nJson formatted request body: ";
             // echo '<pre>'; print_r($formattedJsonReq);
			 // die();
            $rawJsonResponse = self::executeCurl($url, $formattedJsonReq, $readTimeout, $connTimeout);
			$rawjarr = json_decode($rawJsonResponse, true);
			$rawJsonResponse = array();
			$rawJsonResponse["schemaVersion"] = $rawjarr['schemaVersion'];
			$rawJsonResponse["timestamp"] = $rawjarr['timestamp'];
			$rawJsonResponse["requestId"] = $rawjarr['requestId'];
			$rawJsonResponse["responseCode"] = $rawjarr['responseCode'];
			$rawJsonResponse["responseMsg"] = $rawjarr['responseMsg'];
			$rawJsonResponse["errorCode"] = $rawjarr['errorCode'];
			$rawJsonResponse["sessionId"] = $rawjarr['sessionId'];
			$farray = array_merge($rawjarr['params'],$rawJsonResponse);
			$rawJsonResponse = json_encode($farray);
			// echo '<pre>'; print_r($rawJsonResponse);
			 // die();
			
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "response: " . $rawJsonResponse);

            if ($responseClassName == 'waafipay\pg\response\CommitInitiateTransactionResponse') {
                $responseObj = new CommitInitiateTransactionResponse([],new CommitInitiateTransactionResponseBody());
            }
			
			$respbody = $responseObj->getBody();
			
            
            JSONUtil::mapResponseJsonToObject($rawJsonResponse, $respbody);
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "responseData: " . print_r($responseObj, true));
			//echo '<pre>'; print_r($responseObj);
            // echo '<pre>'; print_r($respbody);
			//die();
            $responseObjBody = $responseObj->getBody();
			$responseCode = $responseObjBody->getresponseCode();
			// echo '<pre>'; print_r($responseObjBody);
			// die();
			$responseMsg = $responseObjBody->getresponseMsg();
			
            if ($responseCode == null || empty($responseCode)) {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, $responseMsg .
                    "as responseData->getBody is null and raw json received is: " . $rawJsonResponse);
                throw new Exception($responseMsg);
            }

            
            $resultInfo = $responseObjBody->getresponseCode();
            $resultStatus = $responseObjBody->getresponseMsg();

            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "Execution completed with raw json response: " . $rawJsonResponse);
            return new SDKResponse($responseObj, $rawJsonResponse);
        }

        /**
         * @param $apiURL
         * @param $requestParamList
         * @param $readTimeout
         * @param $connTimeout
         * @return mixed
         * @throws Exception
         */
        private static function executeCurl($apiURL, $requestParamList, $readTimeout, $connTimeout)
        {
            LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "executeCurl called ");
            $postData = $requestParamList;
            $curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $apiURL,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => $postData,
			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			  ),
			));

			$jsonResponse = curl_exec($curl);

			curl_close($curl);

            
            if ($jsonResponse) {
                LoggingUtil::addLog(LogLevel::INFO, __CLASS__, "API response received upon successful execution: " . $jsonResponse);
            } else {
                $error = "CURL Error:";
                LoggingUtil::addLog(LogLevel::ERROR, __CLASS__, "API Communication Error: " . $error);
                throw new SDKException("API Communication Error" . $error);
            }
            return $jsonResponse;
        }

        
    }
