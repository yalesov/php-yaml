<?php
namespace Heartsentwined\Yaml;

use Heartsentwined\ArgValidator\ArgValidator;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml
{
    /**
     * Yaml parser
     *
     * __DIR__ support: (only available for Yaml files, of course!)
     * - '__DIR__' will behave as expected
     * - '___DIR___' (an extra underscore around) will be translated as a literal '__DIR__'
     *
     * @param  mixed $yaml
     * @return self
     */
    public static function parse($yaml)
    {
        ArgValidator::assert($yaml, 'string');
        if (is_file($yaml) && is_readable($yaml)) {
            $dir = realpath(dirname($yaml));
            $yaml = file_get_contents($yaml);
            $yaml = strtr($yaml, array(
                '___DIR___' => '__DIR__',
                '__DIR__' => $dir,
            ));
        }

        return SymfonyYaml::parse($yaml);
    }
}
