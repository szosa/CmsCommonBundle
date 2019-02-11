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

    /**
     * SettingsParserService constructor.
     * @param Filesystem $filesystem
     * @param array $settingsDir
     */
    public function __construct(Filesystem $filesystem, array $settingsDir)
    {
        $this->filesystem = $filesystem;
        $this->settingsDir = $settingsDir;
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
            $settings = Yaml::parseFile($settingPath);
            return $settings;
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
        $string = sprintf('../src/%s/Resources/config/settings.yml', $settingPath);
        $path = realpath($string);
        if(!$this->filesystem->exists($path))
        {
            throw new FileException(sprintf('Setting file: %s dosen\'t exist', $settingPath));
        }

        return $path;
    }
}