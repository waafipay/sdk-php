<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\request;

    use JsonSerializable;

    /**
     * Class ExtraParameterMap
     * @package Waafipay\pg\request
     */
    class ExtraParameterMap implements JsonSerializable
    {

        /**
         * @var array
         */
        private $extraParamsMap = array();

        /**
         * Waafipay\pg\request\ExtraParameterMap constructor.
         */
        protected function __construct()
        {
        }

        /**
         * @return array
         */
        public function getExtraParamsMap()
        {
            return $this->extraParamsMap;
        }

        /**
         * @param array $extraParamsMap
         */
        public function setExtraParamsMap($extraParamsMap = array())
        {
            $this->extraParamsMap = $extraParamsMap;
        }

        /**
         * @return array|mixed
         */
        public function jsonSerialize()
        {
            return
                [
                    'extraParamsMap' => $this->getExtraParamsMap()
                ];
        }

    }
