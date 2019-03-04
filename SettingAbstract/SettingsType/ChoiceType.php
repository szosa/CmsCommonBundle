<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 10.02.2019
 * Time: 01:56
 */

namespace Stallfish\CmsCommonBundle\Settings\SettingType;

/**
 * Class ChoiceType
 * @package Stallfish\CmsCommonBundle\Settings\SettingType
 */
class ChoiceType extends AbstractType
{
    /**
     * @var array
     */
    private $choice;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var bool
     */
    private $multiple;

    /**
     * ChoiceType constructor.
     * @param string $label
     * @param $value
     * @param array $setting
     * @param $tab
     * @param array $choice
     * @param bool $required
     * @param bool $multiple
     */
    public function __construct(string $label, $value,array $setting, $tab, array $choice,  bool $required = false, bool $multiple = false)
    {
        parent::__construct($label, $value, $setting, $tab);
        $this->choice = $choice;
        $this->required = $required;
        $this->multiple = $multiple;
    }

    /**
     * @return array
     */
    public function getChoice():array
    {
        return $this->choice;
    }

    /**
     * @return bool
     */
    public function getRequired():bool
    {
        return $this->required;
    }

    /**
     * @return string
     */
    public function getType():string
    {
        return self::CHOICE_TYPE;
    }

    public function getValue():string
    {
        return parent::getValue();
    }

}