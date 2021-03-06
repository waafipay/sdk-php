<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\response;

    use waafipay\pg\response\interfaces\SecureResponse;

    /**
     * Class NativeRefundStatusResponse
     * @package waafipay\pg\response
     */
    class NativeRefundStatusResponse implements SecureResponse
    {

        /**
         * @var SecureResponseHeader
         */
        private $head;

        /**
         * @var NativeRefundStatusResponseBody
         */
        private $body;

        /**
         * NativeRefundStatusResponse constructor.
         * @param SecureResponseHeader           $head
         * @param NativeRefundStatusResponseBody $body
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
         * @return NativeRefundStatusResponseBody
         */
        public function getBody()
        {
            return $this->body;
        }

        /**
         * @param NativeRefundStatusResponseBody $body
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
