<?php
    /**
     * Copyright (C) 2021 Waafipay.
     */

    namespace waafipay\pg\enums;

    use Exception;

    /**
     * This Enum represents the total list of currencies supported by the system
     *
     * Class EnumCurrency
     * @package Waafipay\pg\enums
     */
    class EnumCurrency
    {
        const USD = "USD";

        /**
         * @var string
         */
        public $currency;

        /**
         * @return string
         */
        public function getCurrency()
        {
            return $this->currency;
        }

        /**
         * EnumCurrency constructor.
         * @param string $currency
         */
        public function __construct($currency)
        {
            $this->currency = $currency;
        }

        /**
         * @return array
         */
        public static function getEnumCurrencyOptions()
        {
            return [
                self::USD,
            ];
        }

        /**
         * @param $currency
         * @return int|string
         * @throws Exception
         */
        static function getEnumByCurrency($currency)
        {
            $enumOptions = self::getEnumCurrencyOptions();
            foreach ($enumOptions as $key => $val) {
                if ($currency == $val) {
                    return $key;
                }
            }
            throw new Exception("FacadeInvalidParameterException : Given value of Currency is not supported");
        }
    }



