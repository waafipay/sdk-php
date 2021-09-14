<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\merchant\models;

    use waafipay\pg\response\AsyncRefundResponse;
    use waafipay\pg\response\InitiateTransactionResponse;
    use waafipay\pg\response\NativePaymentStatusResponse;
    use waafipay\pg\response\NativeRefundStatusResponse;

    /**
     * Class SDKResponse
     * @package waafipay\merchant\models
     */
    class SDKResponse
    {

        /**
         * @var InitiateTransactionResponse|NativePaymentStatusResponse|AsyncRefundResponse|NativeRefundStatusResponse $responseObject
         */
        private $responseObject;

        /**
         * @var string $jsonResponse
         */
        private $jsonResponse;

        /**
         * SDKResponse constructor.
         * @param InitiateTransactionResponse|NativePaymentStatusResponse|AsyncRefundResponse|NativeRefundStatusResponse $responseObject
         * @param string                                                                                                 $jsonResponse
         */
        public function __construct($responseObject, $jsonResponse)
        {
            $this->responseObject = $responseObject;
            $this->jsonResponse = $jsonResponse;
        }

        /**
         * @return InitiateTransactionResponse|NativePaymentStatusResponse|AsyncRefundResponse|NativeRefundStatusResponse
         */
        public function getResponseObject()
        {
            return $this->responseObject;
        }

        /**
         * @return string
         */
        public function getJsonResponse()
        {
            return $this->jsonResponse;
        }

        /**
         * @param InitiateTransactionResponse|NativePaymentStatusResponse|AsyncRefundResponse|NativeRefundStatusResponse $responseObject
         */
        public function setResponseObject($responseObject)
        {
            $this->responseObject = $responseObject;
        }

        /**
         * @param string $jsonResponse
         */
        public function setJsonResponse($jsonResponse)
        {
            $this->jsonResponse = $jsonResponse;
        }
    }
