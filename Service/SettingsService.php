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
     * @return \Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType
     */
    public function getSetting(string $label):AbstractType
    {
        return $this->settingAggregateService->getSettingType($label);
    }

    public function getAllSetting()
    {
        return $this->settingAggregateService->getAllSetting();
    }
}