<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 11.02.2019
 * Time: 20:25
 */

namespace Stallfish\CmsCommonBundle\Service;

use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;

class SettingsService
{
    /**
     * @var SettingAggregateService
     */
    private $settingAggregateService;

    /**
     * SettingsService constructor.
     * @param SettingAggregateService $settingAggregateService
     */
    public function __construct(SettingAggregateService $settingAggregateService)
    {
        $this->settingAggregateService = $settingAggregateService;
    }

    /**
     * @param string $label
     * @return AbstractType
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getSetting(string $label):AbstractType
    {
        return $this->settingAggregateService->getSettingType($label);
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getAllSetting()
    {
        return $this->settingAggregateService->getAllSetting();
    }

    /**
     * @param string $label
     * @return string
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function get(string $label)
    {
        return $this->settingAggregateService->get($label);
    }
}