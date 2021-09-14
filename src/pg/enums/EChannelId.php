<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\enums;

    use Exception;

    /**
     * Class EChannelId
     * @package Waafipay\pg\enums
     */
    class EChannelId
    {
        const WEB = "WEB";

        /**
         * @var string
         */
        private $value;

        /**
         * EChannelId constructor.
         */
        public function __construct()
        {

        }

        /**
         * @param string $value
         */
        public function setValue($value)
        {
            $this->value = $value;
        }

        /**
         * @return string
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @return array
         */
        public static function getEChannelIdOptions()
        {
            return [
                self::WEB
            ];
        }

        /**
         * @param $value
         * @return int|string
         * @throws Exception
         */
        public static function getEChannelIdByValue($value)
        {

            $EChannelIdOptions = self::getEChannelIdOptions();
            foreach ($EChannelIdOptions as $key => $val) {
                if ($val == $value) {
                    return $key;
                }
            }
            throw new Exception("Given value of Channel is not supported");
        }

    }