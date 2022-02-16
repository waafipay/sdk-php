<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\request;

    use JsonSerializable;

    /**
     * Class RefundInitiateRequest
     * @package waafipay\pg\request
     */
    class RefundInitiateRequest implements JsonSerializable
    {

        /**
         * @var SecureRequestHeader
         */
        private $head;

        /**
         * @var RefundInitiateRequestBody
         */
        private $body;

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
         * @return RefundInitiateRequestBody
         */
        public function getBody()
        {
            return $this->body;
        }

        /**
         * @param RefundInitiateRequestBody $body
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
