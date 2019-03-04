<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 11.02.2019
 * Time: 20:25
 */

namespace Stallfish\CmsCommonBundle\Service;

use Predis\Client;
use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;
use Stallfish\CmsCommonBundle\Settings\SettingType\BoolType;
use Stallfish\CmsCommonBundle\Settings\SettingType\ChoiceType;
use Stallfish\CmsCommonBundle\Settings\SettingType\ListType;
use Stallfish\CmsCommonBundle\Settings\SettingType\TextType;

class SettingsService
{
    /**
     * @var SettingAggregateService
     */
    private $settingAggregateService;

    /**
     * @var Client
     */
    private $redis;

    /**
     * SettingsService constructor.
     * @param SettingAggregateService $settingAggregateService
     */
    public function __construct(SettingAggregateService $settingAggregateService)
    {
        $this->settingAggregateService = $settingAggregateService;
        $this->redis = new Client();
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

    /**
     * @param string $label
     * @return array|bool|null|string
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getValue(string $label)
    {
        if(!$this->redis->exists($label) || !$this->redis->exists('type_' . $label))
        {
            $setting = $this->getSetting($label);
            $this->redis->set('type_'. $label, get_class($setting));
            if($setting instanceof ListType){
                $this->redis->set($label, (string)implode(';',$setting->getValue()));
            }else{
                $this->redis->set($label, (string)$setting->getValue());
            }
        }

        return $this->getSettingFromRedis($label);
    }

    /**
     * @param string $label
     * @return array|bool|null|string
     */
    private function getSettingFromRedis(string $label)
    {
        $value = $this->redis->get($label);
        switch($this->redis->get('type_' . $label))
        {
            case BoolType::class : return (bool)$value;
            case TextType::class : return (string)$value;
            case ListType::class : return (array)explode(';', $value);
            case ChoiceType::class : return (string)$value;
            default: return null;
        }

    }
}