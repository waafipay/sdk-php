<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\request;

    use JsonSerializable;

    /**
     * Class NativePaymentStatusRequest
     * @package Waafipay\pg\request
     */
    class NativePaymentStatusRequest implements JsonSerializable
    {

        /**
         * @var SecureRequestHeader
         */
        public $head;

        /**
         * @var NativePaymentStatusRequestBody
         */
        public $body;

        /**
         * Waafipay\pg\request\NativePaymentStatusRequest constructor.
         */
        public function __construct()
        {
        }

        /**
         * @return SecureRequestHeader
         */
        public function getHead()
        {
            return $this->head;
        }

        /**
         * @param SecureRequestHeader $head
         */
        public function setHead($head)
        {
            $this->head = $head;
        }

        /**
         * @return NativePaymentStatusRequestBody
         */
        public function getBody()
        {
            return $this->body;
        }

        /**
         * @param NativePaymentStatusRequestBody $body
         */
        public function setBody($body)
        {
            $this->body = $body;
        }

        /**
         * @return array|mixed
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
