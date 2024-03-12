<?php

namespace Nebalus\Ownsite\Factory;

use Slim\Views\Twig;

class TwigFactory
{

    public function build(): Twig
    {
        // Loads TWIG
        $twigConfig = [];
        if (getenv("TWIG_CACHE")) {
            $twigConfig["cache"] = "/var/www" . getenv("TWIG_CACHE");
        }
        if (getenv("TWIG_DEBUG")) {
            $twigConfig["debug"] = getenv("TWIG_DEBUG");
        }
        if (getenv("TWIG_CHARSET")) {
            $twigConfig["charset"] = getenv("TWIG_CHARSET");
        }

        return Twig::create(__DIR__ . '/../../templates', $twigConfig);
    }
}