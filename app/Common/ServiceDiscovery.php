<?php

namespace App\Common;

class ServiceDiscovery
{

    private static array $services;

    public static function get($serviceName): string|false
    {
        self::$services = config("app.service_discovery");
        return (!empty(self::$services[$serviceName]) && !empty($serviceName)) ? self::$services[$serviceName] : false;
    }
}
