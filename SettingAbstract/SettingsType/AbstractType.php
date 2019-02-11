<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 10.02.2019
 * Time: 01:09
 */

namespace Stallfish\CmsCommonBundle\Settings\SettingType;

use Stallfish\CmsCommonBundle\Entity\Settings;

/**
 * Class AbstractType
 * @package Stallfish\CmsCommonBundle\Settings\SettingType
 */
abstract class AbstractType  implements TypeInterface
{
    const TEXT_TYPE = 'text';
    const BOOL_TYPE = 'bool';
    const CHOICE_TYPE = 'choice';
    const LIST_TYPE = 'list';

    /**
     * @var string
     */
    protected $label;

    /**
     * @var Settings
     */
    protected $setting;

    /**
     * @var
     */
    protected $value;

    /**
     * @var string
     */
    protected $tab;

    /**
     * AbstractType constructor.
     * @param string $label
     * @param $value
     * @param string|null $tab
     */
    public function __construct(string $label, $value, string $tab = null)
    {
        $this->setting = new Settings();
        $this->label = $label;
        $this->tab = $tab;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getLabel():string
    {
        return (string)$this->label;
    }

    /**
     * @return string
     */
    public function getValue():string
    {
        return $this->value;
    }
}