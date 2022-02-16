<?php
    /**
     * Copyright (C) 2021 waafipay.
     */

    namespace waafipay\pg\response\interfaces;

    use waafipay\pg\response\BaseResponseBody;
    use waafipay\pg\response\ResponseHeader;

    /**
     * Interface Response
     * @package waafipay\pg\response\interfaces
     */
    interface Response
    {

        /**
         * @return ResponseHeader
         */
        public function getHead();

        /**
         * @return BaseResponseBody
         */
        public function getBody();
    }
