<?php

    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\response\interfaces;

    use waafipay\pg\response\SecureResponseHeader;

    /**
     * Interface SecureResponse
     * @package waafipay\pg\response\interfaces
     */
    interface SecureResponse extends Response
    {

        /**
         * @return SecureResponseHeader
         */
        public function getHead();

    }
