<?php

namespace Stallfish\CmsCommonBundle\Controller;

use Predis\Client;
use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;
use Stallfish\CmsCommonBundle\Settings\SettingType\BoolType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/submit", name="control_panel_submit")
     */
    public function setControlPanel(Request $request)
    {
        $settings = $this->get('stallfish.settings')->getAllSetting();
        $requestSetting = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $redis = new Client();
        /** @var AbstractType $setting */
        foreach($settings as $key => $setting) {
            $settingEntity = $em->getRepository('CmsCommonBundle:Settings')->findOneBy(['settingLabel' => $key]);
            $settingEntity->setSettingValue(null);
            if (key_exists('setting_' . $setting->getLabel(), $requestSetting)) {
                if ($setting instanceof BoolType) {
                    if ($requestSetting['setting_' . $setting->getLabel()] == 'on') {
                        $settingEntity->setSettingValue(true);
                    } else {
                        $settingEntity->setSettingValue(false);
                    }
                } else {
                    $settingEntity->setSettingValue($requestSetting['setting_' . $setting->getLabel()]);
                }
            }
            $em->persist($settingEntity);
            $em->flush();
            $redis->set($settingEntity->getSettingLabel(), $settingEntity->getSettingValue());
            $redis->set('type_' . $settingEntity->getSettingLabel(), get_class($setting));
        }
        return $this->redirectToRoute('control_panel');
    }
}
