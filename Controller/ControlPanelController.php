<?php

namespace Stallfish\CmsCommonBundle\Controller;

use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ControlPanelController
 * @package Stallfish\CmsCommonBundle\Controller
 * @Route("cms/control-panel")
 */
class ControlPanelController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/", name="control_panel")
     */
    public function indexAction()
    {
        $settings = $this->get('stallfish.settings')->getAllSetting();
        $tabSetting = [];
        $tabs = [];
        /** @var AbstractType $setting */
        foreach ($settings as $setting)
        {
            $tab = $setting->getTab();
            $tabs[$tab] =$tab;
            $tabSetting[$tab][$setting->getLabel()] = $setting;
        }
        return $this->render('@CmsCommon/ControlPanel/index.html.twig',[
            'tabs' => $tabs,
            'settingsTab' => $tabSetting
        ]);
    }
}
