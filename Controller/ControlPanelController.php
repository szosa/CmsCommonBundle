<?php

namespace Stallfish\CmsCommonBundle\Controller;

use Predis\Client;
use Stallfish\CmsCommonBundle\Settings\Helper\FormTypeFactory;
use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;
use Stallfish\CmsCommonBundle\Settings\SettingType\BoolType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/", name="control_panel")
     */
    public function indexAction(Request $request)
    {
        $settings = $this->get('stallfish.settings')->getAllSetting();
        $tabs = $this->prepareTab($settings);
        $formFactory = new FormTypeFactory($this->createFormBuilder());
        $form =  $formFactory->addFields($settings);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $this->saveSettings($form, $settings);
        }
        return $this->render('@CmsCommon/ControlPanel/index.html.twig',[
            'tabs' => $tabs,
            'settingsTab' => $settings,
            'form' => $form->createView(),
            'settings' => $settings
        ]);
    }

    /**
     * @param array $settings
     * @return array
     */
    private function prepareTab(array $settings):array
    {
        $tab = [];
        /**
         * @var $setting AbstractType
         */
        foreach($settings as $setting)
        {
            $tab[$setting->getTab()][] = $setting->getLabel();
        }

        return $tab;
    }

    /**
     * @param Form $formBuilder
     */
    private function saveSettings(Form $formBuilder, array $settings)
    {

        $em = $this->getDoctrine()->getManager();
        $data = $formBuilder->getData();
        $redis = new Client();
        foreach($settings as $key => $value)
        {
            $setting = $em->getRepository('CmsCommonBundle:Settings')->findOneBy(['settingLabel' => $key]);
            $setting->setSettingValue($data[$value->getLabel()]);
            $em->persist($setting);

            $redis->set($key, $data[$value->getLabel()]);
            $redis->set('type_' . $key, get_class($value));
        }

        $em->flush();
    }
}
