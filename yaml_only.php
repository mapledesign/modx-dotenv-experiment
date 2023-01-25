<?php
declare(strict_types=1);

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/vendor/autoload.php';

class YamlConfigLoader
{


    /**
     * Loads a YAML file.
     *
     * @throws \InvalidArgumentException when the given file is not a local file or when it does not exist
     */
    public function loadFile(string $file): ?array
    {
        if (!class_exists(Parser::class)) {
            throw new \RuntimeException('Unable to load YAML config files as the Symfony Yaml Component is not installed.');
        }

        if (!stream_is_local($file)) {
            throw new \InvalidArgumentException(sprintf('This is not a local file "%s".', $file));
        }

        if (!is_file($file)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not exist.', $file));
        }

        $this->yamlParser = new Parser();

        try {
            $configuration = $this->yamlParser->parseFile($file, Yaml::PARSE_CONSTANT | Yaml::PARSE_CUSTOM_TAGS);
        } catch (ParseException $e) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not contain valid YAML: ', $file).$e->getMessage(), 0, $e);
        }

        return $configuration;
    }
}

$loader = new YamlConfigLoader();
$configuration = $loader->loadFile(__DIR__ . '/config/system_settings.yaml');
dump($configuration);
