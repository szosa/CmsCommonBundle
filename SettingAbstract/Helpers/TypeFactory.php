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
use Stallfish\CmsCommonBundle\Settings\Helper\TypeSettingParser;

/**
 * Class TypeFactory
 * @package Stallfish\CmsCommonBundle\Settings\Helper
 */
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
        $label = TypeSettingParser::parseLabel($setting);
        $tab = TypeSettingParser::parseTab($setting);
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
        $label = TypeSettingParser::parseLabel($setting);
        $placeholder = TypeSettingParser::parsePlaceholder($setting);
        $required = TypeSettingParser::parseRequired($setting);
        $tab = TypeSettingParser::parseTab($setting);
        try{
            $value = (string)$value;
        }catch(\Exception $exception)
        {
            sprintf('Value of %s cannot be convert to string', $label);
        }

        return new TextType($label, $value, $placeholder, $required, $tab);
    }

    /**
     * @param array $setting
     * @param $value
     * @return ListType
     */
    static private function parseListType(array $setting, $value):ListType
    {
        $label = TypeSettingParser::parseLabel($setting);
        $tab = TypeSettingParser::parseTab($setting);
        $value = explode(';', $value);
        try{
            $value = (array)$value;
        }catch(\Exception $exception)
        {
            sprintf('Value of %s cannot be convert to array', $label);
        }
        return new ListType($label, $value, $tab);
    }

    /**
     * @param array $setting
     * @param $value
     * @return ChoiceType
     */
    static private function parseChoiceType(array $setting, $value):ChoiceType
    {
        $label = TypeSettingParser::parseLabel($setting);
        $choice = TypeSettingParser::parseChoice($setting);
        $required = TypeSettingParser::parseRequired($setting);
        $tab = TypeSettingParser::parseTab($setting);
        $multiple = TypeSettingParser::parseMultiple($setting);
        try{
            $value = (string)$value;
        }catch(\Exception $exception)
        {
            sprintf('Value of %s cannot be convert to string', $label);
        }
        return new ChoiceType($label, $value, $tab, $choice, $required, $multiple);
    }
}