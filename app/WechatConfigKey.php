<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class WechatConfigKey extends Model
    {

        //
        public $timestamps = false;

        /**
         * [ check configs completeness ]
         * @param $config
         * @return $config
         */
        public function checkConfigs ($config)
        {
            if(!is_object($config))
            {
                $config=(object)$config;
            }
            $keys = $this->get ();
            foreach ($keys as $key) {
                $property = $key['key'];
                property_exists ($config , $key['key']) ? 0 : $config->$property = $key['default_value'];
            }

            return $config;

        }
    }
