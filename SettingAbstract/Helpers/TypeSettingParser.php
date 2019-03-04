<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 12.02.2019
 * Time: 23:31
 */

namespace Stallfish\CmsCommonBundle\Settings\Helper;

/**
 * Class TypeSettingValidator
 * @package Stallfish\CmsCommonBundle\Settings\Helper
 */
class TypeSettingParser
{
    /**
     * @param array $setting
     * @return string
     */
    static function parseLabel(array $setting):string
    {
        try{
            return (string)$setting['label'];
        }catch(\Exception $exception)
        {
            printf('Missing \'label\' attribute for setting or cannot be converted to string');
        }

        return null;
    }

    /**
     * @param array $settings
     * @return string
     */
    static function parsePlaceholder(array $settings):string
    {
        if(key_exists('placeholder', $settings))
        {
            try{
                return (string)$settings['placeholder'];
            }catch(\Exception $exception)
            {
                sprintf('Value of %s cannot be convert to string', self::parseLabel($settings));
            }
        }
        return null;
    }

    /**
     * @param array $setting
     * @return bool
     */
    static function parseRequired(array $setting):bool
    {
        if(key_exists('required', $setting)) {
            try {
                return (bool)$setting['required'];
            } catch (\Exception $exception) {
                sprintf('Value of field required in %s setting should be bool type', self::parseLabel($setting));
            }
        }

        return false;
    }

    /**
     * @param array $setting
     * @return array
     */
    static function parseChoice(array $setting):array
    {
        try{
            return (array)$setting['choice'];
        }catch(\Exception $exception)
        {
            sprintf('Value of %s cannot be convert to array', self::parseLabel($setting));
        }
        return [];
    }

    /**
     * @param array $settings
     * @return string
     */
    static function parseTab(array $settings):string
    {
        if(key_exists('tab', $settings))
        {
            try{
                return (string)$settings['tab'];
            }catch(\Exception $exception)
            {
                sprintf('Value of %s cannot be convert to string', self::parseLabel($settings));
            }
        }

        return 'default';
    }

    /**
     * @param array $setting
     * @return bool
     */
    static function parseMultiple(array $setting):bool
    {
        if(key_exists('multiple', $setting)) {
            try {
                return (bool)$setting['multiple'];
            } catch (\Exception $exception) {
                sprintf('Value of field multiple in %s setting should be bool type', self::parseLabel($setting));
            }
        }

        return false;
    }
}