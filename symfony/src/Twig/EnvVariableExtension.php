<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EnvVariableExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_env_var', [$this, 'getEnvironmentVariable'])
        ];
    }

    /**
     * Retourne la valeur d'une variable d'environnement donnée
     *
     * @param $varName string
     * @return string
     */
    public function getEnvironmentVariable(string $varName): string
    {
        return $_ENV[$varName];
    }
}
