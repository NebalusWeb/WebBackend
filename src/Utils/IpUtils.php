<?php

namespace Nebalus\Webapi\Utils;

class IpUtils
{
    public function getClientIP(): string|null
    {
        // Falls Traefik den Header "X-Forwarded-For" setzt (kann mehrere IPs enthalten)
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Zerlege den Header in einzelne IPs (bei mehreren, z.B. "ClientIP, Proxy1, Proxy2")
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipList as $ip) {
                $ip = trim($ip);
                // Überprüfe, ob es sich um eine gültige IP-Adresse handelt
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        if (!empty($_SERVER['X-Real-Ip'])) {
            return $_SERVER['X-Real-Ip'];
        }

        if (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }

        return null;
    }
}
