<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 13.02.2019
 * Time: 20:41
 */
namespace Stallfish\CmsCommonBundle\Settings\Twig;

use Stallfish\CmsCommonBundle\Service\SettingsService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class StallfishSettingsExtension
 * @package Stallfish\CmsCommonBundle\Settings\Twig
 */
class StallfishSettingsExtension extends AbstractExtension
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * StallfishSettingsExtension constructor.
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @return array|\Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('stallfish_setting', [$this, 'stallfishSetting']),
        ];
    }

    /**
     * @param string $label
     * @return string
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function stallfishSetting(string $label)
    {
        return $this->settingsService->get($label);
    }
}