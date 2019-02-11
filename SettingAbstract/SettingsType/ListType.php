<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 10.02.2019
 * Time: 02:21
 */

namespace Stallfish\CmsCommonBundle\Settings\SettingType;


class ListType extends AbstractType
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return self::LIST_TYPE;
    }
}