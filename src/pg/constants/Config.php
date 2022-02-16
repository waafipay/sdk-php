<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\constants;

    /**
     * Class Config
     * @package Waafipay\pg\constants
     */
    class Config
    {

        /**
         * @var string
         */
        static $monologName = '[WAAFIPAY]';

        /**
         * @var int
         */
        static $monologLevel = \Monolog\Logger::INFO;

        /**
         * @var string
         */
        static $monologLogfile = PROJECT . '/logs/app.log';

        /**
         * This holds unique uuid v4
         *
         * @var string
         */
        static $requestId;

    }
    Config::$requestId = LibraryConstants::PHP_SDK_TEXT . LibraryConstants::PHP_SDK_VERSION;