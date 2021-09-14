<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\response;

    use waafipay\pg\response\interfaces\SecureResponse;

    /**
     * Class NativePaymentStatusResponse
     * @package waafipay\pg\response
     */
    class NativePaymentStatusResponse implements SecureResponse
    {

        /**
         * @var SecureResponseHeader
         */
        public $head;

        /**
         * @var NativePaymentStatusResponseBody
         */
        public $body;

        /**
         * NativePaymentStatusResponse constructor.
         * @param SecureResponseHeader            $head
         * @param NativePaymentStatusResponseBody $body
         */
        public function __construct($head, $body)
        {
            $this->head = $head;
            $this->body = $body;
        }

        /**
         * @return SecureResponseHeader
         */
        public function getHead()
        {
            return $this->head;
        }

        /**
         * @param SecureResponseHeader $head
         */
        public function setHead($head)
        {
            $this->head = $head;
        }

        /**
         * @return BaseResponseBody|NativePaymentStatusResponseBody
         */
        public function getBody()
        {
            return $this->body;
        }

        /**
         * @param NativePaymentStatusResponseBody $body
         */
        public function setBody($body)
        {
            $this->body = $body;
        }

        /**
         * @return array
         */
        public function jsonSerialize()
        {
            return
                [
                    'head' => $this->getHead(),
                    'body' => $this->getBody()
                ];
        }
    }

