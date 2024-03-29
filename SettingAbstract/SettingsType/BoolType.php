<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 10.02.2019
 * Time: 01:08
 */

namespace Stallfish\CmsCommonBundle\Settings\SettingType;

/**
 * Class BoolType
 * @package Stallfish\CmsCommonBundle\Settings\SettingType
 */
class BoolType extends AbstractType
{

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::BOOL_TYPE;
    }

    public function getValue(): bool
    {
        return (bool)parent::getValue();
    }

    public function getFormFieldType():string
    {
        return \Symfony\Component\Form\Extension\Core\Type\CheckboxType::class;
    }
}