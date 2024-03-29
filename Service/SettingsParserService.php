<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 11.02.2019
 * Time: 21:31
 */

namespace Stallfish\CmsCommonBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class SettingsParserService
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var array
     */
    private $settingsDir;

    /**
     * @var array
     */
    private $settingPaths;

    private $projectDir;

    /**
     * SettingsParserService constructor.
     * @param Filesystem $filesystem
     * @param string $rootDir
     */
    public function __construct(Filesystem $filesystem, string $rootDir, string $projectDir)
    {
        $this->filesystem = $filesystem;
        $this->projectDir = $projectDir;
        $config = Yaml::parse(
            file_get_contents( realpath($rootDir . '/config/config.yml'))
        );
        $this->settingsDir = $config['cms_common']['settings'];
        $this->settingPaths = $this->prepareSettingPathArray();
    }

    /**
     * @return array
     */
    public function parseAllSettings()
    {
        $return = [];
        foreach($this->settingPaths as $settingPath)
        {
            $return = array_merge($return, $this->getParametersAsArray($settingPath)['settings']);
        }
        return $return;
    }

    /**
     * @return array
     */
    private function prepareSettingPathArray(): array
    {
        $return = [];
        foreach($this->settingsDir as $settingDir)
        {
            $return[] = $this->prepareSettingPath($settingDir);
        }

        return $return;
    }

    /**
     * @param String $settingPath
     * @return array|mixed
     */
    private function getParametersAsArray(String $settingPath)
    {
        try {
            return Yaml::parseFile($settingPath);
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }

        return [];
    }

    /**
     * @param String $settingPath
     * @return string
     */
    private function prepareSettingPath(String $settingPath):string
    {
        $string = sprintf($this->projectDir . '/src/%s/Resources/config/settings.yml', $settingPath);
        $path = realpath($string);
        if(!$this->filesystem->exists($path))
        {
            throw new FileException(sprintf('Setting file: %s dosen\'t exist', $string . $path));
        }

        return $path;
    }
}