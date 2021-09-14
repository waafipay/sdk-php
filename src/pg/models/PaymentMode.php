<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\models;

    use JsonSerializable;

    /**
     * Class PaymentMode
     * @package Waafipay\pg\models
     */
    class PaymentMode implements JsonSerializable
    {
        /**
         * @var string
         */
        private $mode;

        /**
         * @var array
         */
        private $channels = array();

        /**
         * Waafipay\pg\models\PaymentMode constructor.
         */
        public function __construct()
        {
        }

        /**
         * @return string
         */
        public function getMode()
        {
            return $this->mode;
        }

        /**
         * @param string $mode
         */
        public function setMode($mode)
        {
            $this->mode = $mode;
        }

        /**
         * @return array
         */
        public function getChannels()
        {
            return $this->channels;
        }

        /**
         * @param array $channels
         */
        public function setChannels($channels = array())
        {
            $this->channels = $channels;
        }

        /**
         * @return array|mixed
         */
        public function jsonSerialize()
        {
            return [
                'paymentMode' => [
                    'mode' => $this->mode,
                    'channels' => $this->channels
                ]
            ];
        }
    }
