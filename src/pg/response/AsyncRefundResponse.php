<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\response;

    use waafipay\pg\response\interfaces\SecureResponse;

    /**
     * Class AsyncRefundResponse
     * @package waafipay\pg\response
     */
    class AsyncRefundResponse implements SecureResponse
    {

        /**
         * @var SecureResponseHeader
         */
        private $head;

        /**
         * @var AsyncRefundResponseBody
         */
        private $body;

        /**
         * @return SecureResponseHeader
         */
        public function getHead()
        {
            return $this->head;
        }

        /**
         * AsyncRefundResponse constructor.
         * @param SecureResponseHeader    $head
         * @param AsyncRefundResponseBody $body
         */
        public function __construct($head, $body)
        {
            $this->head = $head;
            $this->body = $body;
        }

        /**
         * @param SecureResponseHeader $head
         */
        public function setHead($head)
        {
            $this->head = $head;
        }

        /**
         * @return AsyncRefundResponseBody|BaseResponseBody
         */
        public function getBody()
        {
            return $this->body;
        }

        /**
         * @param AsyncRefundResponseBody $body
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
