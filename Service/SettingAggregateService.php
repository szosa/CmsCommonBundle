<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 11.02.2019
 * Time: 22:16
 */

namespace Stallfish\CmsCommonBundle\Service;


use Doctrine\ORM\EntityManager;
use Stallfish\CmsCommonBundle\Entity\Settings;
use Stallfish\CmsCommonBundle\Repository\SettingsRepository;
use Stallfish\CmsCommonBundle\Settings\Helper\TypeFactory;
use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;

class SettingAggregateService
{
    /**
     * @var SettingsRepository
     */
    private $settingsRepository;

    /**
     * @var SettingsParserService
     */
    private $settingsParserService;

    /**
     * @var EntityManager
     */
    private $em;

    private $settingArray;

    /**
     * SettingAggregate constructor.
     * @param SettingsRepository $settingsRepository
     * @param SettingsParserService $settingsParserService
     */
    public function __construct(EntityManager $em, SettingsParserService $settingsParserService)
    {
        $this->em = $em;
        $this->settingsRepository = $this->em->getRepository('CmsCommonBundle:Settings');
        $this->settingsParserService = $settingsParserService;
        $this->settingArray = $this->settingsParserService->parseAllSettings();
    }

    /**
     * @param string $label
     * @return AbstractType
     */
    public function getSettingType(string $label): AbstractType
    {
        $setting = $this->settingsRepository->find($label);

        if(is_null($setting))
        {
            $setting = $this->createSettingEntity($label);
        }
        return TypeFactory::getTypeObject($this->getSettingArray($label), $setting->getSettingValue());
    }

    /**
     * @return array
     */
    public function getAllSetting()
    {
        $return = [];
        foreach($this->settingArray as $key => $setting)
        {
            $return[$key] = $this->getSettingType($key);
        }

        return $return;
    }

    /**
     * @param string $label
     * @return array
     */
    private function getSettingArray(string $label): array
    {
        try {
            return (array)$this->settingArray[$label];
        } catch (\Exception $exception) {
            sprintf('Setting: %s dosen\'t exist', $label);
        }
        return [];
    }

    private function createSettingEntity(string $label):Settings
    {
        $setting = new Settings();
        $setting->setSettingLabel($label);

        return $setting;
    }
}