<?php

namespace Stallfish\CmsCommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Stallfish\CmsCommonBundle\Entity\Traits\BaseEntityTrait;
use Sensio\Bundle\GeneratorBundle\Annotation\Translation;

/**
 * Settings
 *
 * @ORM\Table(name="stallfish_cms_settings")
 * @ORM\Entity(repositoryClass="Stallfish\CmsCommonBundle\Repository\SettingsRepository")
 */
class Settings
{

    use BaseEntityTrait;

    /**
     * @var int
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="setting_label", type="string", length=255, unique=true)
     */
    private $settingLabel;

    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="setting_value", type="string", length=255, nullable=true)
     */
    private $settingValue;


    /**
     * Set settingLabel
     *
     * @param string $settingLabel
     *
     * @return Settings
     */
    public function setSettingLabel($settingLabel)
    {
        $this->settingLabel = $settingLabel;

        return $this;
    }

    /**
     * Get settingLabel
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getSettingLabel()
    {
        return $this->settingLabel;
    }

    /**
     * Set settingValue
     *
     * @param string $settingValue
     *
     * @return Settings
     */
    public function setSettingValue($settingValue)
    {
        $this->settingValue = $settingValue;

        return $this;
    }

    /**
     * Get settingValue
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getSettingValue()
    {
        return $this->settingValue;
    }
}

