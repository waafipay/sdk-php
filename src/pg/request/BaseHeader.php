<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\request;

    use JsonSerializable;
    use waafipay\pg\enums\EChannelId;

    /**
     * Class BaseHeader
     * @package waafipay\pg\request
     */
    class BaseHeader implements JsonSerializable
    {

        /**
         * @var string
         */
        public $version;

        /**
         * @var EChannelId
         */
        public $channelId;

        /**
         * @return string
         */
        public function getVersion()
        {
            return $this->version;
        }

        /**
         * @param string $version
         */
        public function setVersion($version)
        {
            $this->version = $version;
        }

        /**
         * @return string
         */
        public function getChannelId()
        {
            return $this->channelId;
        }

        /**
         * @param string $channelId
         */
        public function setChannelId($channelId)
        {
            $this->channelId = $channelId;
        }

        /**
         * BaseHeader constructor.
         */
        public function __construct()
        {
        }

        /**
         * @return array|mixed
         */
        public function jsonSerialize()
        {
            return
                [
                    'version' => $this->getVersion(),
                    'channelId' => $this->getChannelId()
                ];
        }
    }
