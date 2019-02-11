<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 11.02.2019
 * Time: 21:45
 */

namespace Stallfish\CmsCommonBundle\Settings\Helper;


use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;
use Stallfish\CmsCommonBundle\Settings\SettingType\BoolType;
use Stallfish\CmsCommonBundle\Settings\SettingType\ChoiceType;
use Stallfish\CmsCommonBundle\Settings\SettingType\ListType;
use Stallfish\CmsCommonBundle\Settings\SettingType\TextType;

class TypeFactory
{
    /**
     * @param array $setting
     * @param $value
     * @return AbstractType
     */
    static function getTypeObject(array $setting, $value):AbstractType
    {
        switch($setting['type']){
            case AbstractType::BOOL_TYPE: return self::parseBoolType($setting, $value);
            break;
            case AbstractType::TEXT_TYPE: return self::parseTextType($setting, $value);
            break;
            case AbstractType::LIST_TYPE: return self::parseListType($setting, $value);
            break;
            case AbstractType::CHOICE_TYPE: return self::parseChoiceType($setting, $value);
            break;
            default: return null;
        }
    }

    /**
     * @param array $setting
     * @param $value
     * @return BoolType
     */
    static private function parseBoolType(array $setting, $value):BoolType
    {
        $label = self::parseLabel($setting);
        $tab = self::parseTab($setting);
        try{
            $value = (bool)$value;
        }catch(\Exception $exception)
        {
            sprintf('Value of %s cannot be convert to bool', $label);
        }
        return new BoolType($label, $value, $tab);
    }

    /**
     * @param array $setting
     * @param $value
     * @return TextType
     */
    static private function parseTextType(array $setting, $value):TextType
    {
        $label = self::parseLabel($setting);
        $placeholder = self::parsePlaceholder($setting);
        $required = self::parseRequired($setting);
        try{
            $value = (string)$value;
        }catch(\Exception $exception)
        {
            sprintf('Value of %s cannot be convert to string', $label);
        }

        return new TextType($label, $value, $placeholder, $required);
    }

    /**
     * @param array $setting
     * @param $value
     * @return ListType
     */
    static private function parseListType(array $setting, $value):ListType
    {
        $label = self::parseLabel($setting);
        try{
            $value = (array)$value;
        }catch(\Exception $exception)
        {
            sprintf('Value of %s cannot be convert to array', $label);
        }
        return new ListType($label, $value);
    }

    /**
     * @param array $setting
     * @param $value
     * @return ChoiceType
     */
    static private function parseChoiceType(array $setting, $value):ChoiceType
    {
        $label = self::parseLabel($setting);
        $choice = self::parseChoice($setting);
        $required = self::parseRequired($setting);
        $tab = self::parseTab($setting);
        $multiple = self::parseMultiple($setting);
        try{
            $value = (string)$value;
        }catch(\Exception $exception)
        {
            sprintf('Value of %s cannot be convert to string', $label);
        }
        return new ChoiceType($label, $value, $tab, $choice, $required, $multiple);
    }

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