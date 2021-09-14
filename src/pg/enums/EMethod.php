<?php

    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\enums;

    use Exception;

    /**
     * Class EMethod
     * @package Waafipay\pg\enums
     */
    class EMethod
    {
        const
            MWALLET_ACCOUNT = "MWALLET_ACCOUNT",
            CREDIT_CARD = "CREDIT_CARD";

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
        public static function getEMethodIdOptions()
        {
            return [
                self::MWALLET_ACCOUNT,
                self::CREDIT_CARD
            ];
        }

        /**
         * @param $value
         * @return int|string
         * @throws Exception
         */
        public static function getEMethodIdByValue($value)
        {

            $EmethodIdOptions = self::getEMethodIdOptions();
            foreach ($EmethodIdOptions as $key => $val) {
                if ($val == $value) {
                    return $key;
                }
            }
            throw new Exception("Given value of Currency is not supported");
        }

    }