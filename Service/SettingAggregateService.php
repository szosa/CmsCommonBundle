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

/**
 * Class SettingAggregateService
 * @package Stallfish\CmsCommonBundle\Service
 */
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

    /**
     * @var array
     */
    private $settingArray;

    /**
     * @var array
     */
    private $settingLabels;

    /**
     * SettingAggregateService constructor.
     * @param EntityManager $em
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
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getSettingType(string $label): AbstractType
    {
        $setting = $this->settingsRepository->find($label);
        if(is_null($setting) && key_exists($label, $this->settingArray))
        {
            $setting = $this->createSettingEntity($label);
        }
        if(is_null($setting)){
            throw new \Exception(sprintf('Setting: %s dosen\'t exist', $label));
        }
        return TypeFactory::getTypeObject($this->getSettingArray($label), $setting->getSettingValue());
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
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

    /**
     * @param string $label
     * @return Settings
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createSettingEntity(string $label):Settings
    {
        $setting = new Settings();
        $setting->setSettingLabel($label);
        $this->em->persist($setting);
        $this->em->flush();

        return $setting;
    }

    /**
     * @param string $label
     * @return string
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function get(string $label)
    {
        $setting = $this->getSettingType($label);

        return $setting->getValue();
    }
}