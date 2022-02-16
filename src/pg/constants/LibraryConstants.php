<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\constants;

    use Exception;

    /**
     * Class LibraryConstants
     * @package Waafipay\pg\constants
     */
    class LibraryConstants
    {
        const VERSION = "v1";

        /** Environment constants */
        const STAGING_ENVIRONMENT = "STAGE";
        const PRODUCTION_ENVIRONMENT = "PROD";

        // Status message can be returned in case of Api success
        const SUCCESS_STATUS = "S";
        const PENDING_STATUS = "PENDING";
        const TXN_SUCCESS_STATUS = "TXN_SUCCESS";

        const REQUEST_TYPE_PREAUTHORIZE = "API_PREAUTHORIZE";
        const REQUEST_TYPE_PREAUTHCOMMIT = "API_PREAUTHORIZE_COMMIT";
        const REQUEST_TYPE_PREAUTHCANCEL = "API_PREAUTHORIZE_CANCEL";
        const REQUEST_TYPE_CANCELPURCHASE = "API_CANCELPURCHASE";
        const REQUEST_TYPE_REFUND = "API_REFUND";
        const SCHEMA_VERSION = "1.0";

        /** holds constant value for Request Id text */
        const X_REQUEST_ID = "X-Request-ID";
        /** holds the version of SDK */
        const PHP_SDK_TEXT = "PHP-SDK";
        /** holds the version of SDK */
        const PHP_SDK_VERSION = "1.0.0";

        /**
         * Constants constructor.
         * @throws Exception
         */
        private function __construct()
        {
            throw new Exception(ErrorConstants::UTILITY_CLASS_EXCEPTION);
        }

    }

    namespace waafipay\pg\constants\LibraryConstants;

    use waafipay\pg\constants\ErrorConstants;

    /**
     * Class Request
     * @package Waafipay\pg\constants\LibraryConstants
     */
    class Request
    {

        /**
         * Request constructor.
         * @throws \Exception
         */
        private function __construct()
        {
            throw new \Exception(ErrorConstants::UTILITY_CLASS_EXCEPTION);
        }

    }
