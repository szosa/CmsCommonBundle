<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 10.02.2019
 * Time: 01:10
 */

namespace Stallfish\CmsCommonBundle\Settings\SettingType;

/**
 * Interface TypeInterface
 * @package Stallfish\CmsCommonBundle\Settings\SettingType
 */
interface TypeInterface
{
    public function getLabel():string;

    public function getValue();

    public function getType():string;
}