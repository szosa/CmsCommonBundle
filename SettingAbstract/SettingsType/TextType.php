<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 10.02.2019
 * Time: 01:52
 */

namespace Stallfish\CmsCommonBundle\Settings\SettingType;

/**
 * Class TextType
 * @package Stallfish\CmsCommonBundle\Settings\SettingType
 */
class TextType extends AbstractType
{
    /**
     * @var string
     */
    private $placeholder;

    /**
     * @var bool
     */
    private $required;

    /**
     * TextType constructor.
     * @param string $label
     * @param string $value
     * @param string $placeholder
     * @param bool $required
     */
    public function __construct(string $label, string $value, string $placeholder, bool $required = false)
    {
        parent::__construct($label, $value);
        $this->placeholder = $placeholder;
        $this->required = $required;
    }

    /**
     * @return string
     */
    public function getPlaceholder():string
    {
        return $this->placeholder;
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
    public function getType(): string
    {
        return self::TEXT_TYPE;
    }
}