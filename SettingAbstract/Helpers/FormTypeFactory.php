<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 08.03.2019
 * Time: 19:46
 */

namespace Stallfish\CmsCommonBundle\Settings\Helper;


use Stallfish\CmsCommonBundle\Service\SettingValidatorService;
use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;
use Stallfish\CmsCommonBundle\Settings\SettingType\BoolType;
use Stallfish\CmsCommonBundle\Settings\SettingType\ChoiceType;
use Stallfish\CmsCommonBundle\Settings\SettingType\ListType;
use Stallfish\CmsCommonBundle\Settings\SettingType\TextType;
use Stallfish\CmsCommonBundle\Settings\SettingType\TypeInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FormTypeFactory
{

    private $formBuilder;

    private $settingValidator;

    public function __construct(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    public function addFields(array $settings)
    {
        /**
         * @var $setting AbstractType
         */
        foreach($settings as $setting)
        {
            $this->addField($setting);
        }
        return $this->formBuilder
            ->add('submit', SubmitType::class,[
                'label_format' => 'setting.save'
            ])
            ->getForm();
    }

    public function addField(TypeInterface $abstractType)
    {
        switch($abstractType->getType())
        {
            case AbstractType::TEXT_TYPE : $this->setTextType($abstractType);
                break;
            case AbstractType::CHOICE_TYPE : $this->setChoiceType($abstractType);
                break;
            case AbstractType::LIST_TYPE : $this->setListType($abstractType);
                break;
            case AbstractType::BOOL_TYPE : $this->setBoolType($abstractType);
                break;
        }

        return $this->formBuilder;
    }


    private function setTextType(TextType $textType)
    {
        $this->formBuilder = $this->formBuilder->add($textType->getLabel(), $textType->getFormFieldType(),
            [
                'label_format' => $textType->getLabel(),
                'constraints'  => SettingValidatorService::getValidators($textType),
                'data'         => $textType->getValue(),
                'attr'         => [
                    'placeholder'  => $textType->getLabel(),
                ]
            ]
        );
    }

    private function setChoiceType(ChoiceType $choiceType)
    {
        $this->formBuilder = $this->formBuilder->add($choiceType->getLabel(), $choiceType->getFormFieldType(),
            [
                'label_format' => $choiceType->getLabel(),
                'constraints'  => SettingValidatorService::getValidators($choiceType),
                'data'         => $choiceType->getValue(),
                'choices'      => $choiceType->getChoice()
            ]
        );
    }

    private function setListType(ListType $listType)
    {
        $this->formBuilder = $this->formBuilder->add($listType->getLabel(), $listType->getFormFieldType(),
            [
                'label_format' => $listType->getLabel(),
                'constraints'  => SettingValidatorService::getValidators($listType),
                'data'         => $listType->getValue(),
                'attr'         => [
                    'placeholder'  => $listType->getLabel(),
                ]
            ]
        );
    }

    private function setBoolType(BoolType $boolType)
    {
        $this->formBuilder = $this->formBuilder->add($boolType->getLabel(), $boolType->getFormFieldType(),
            [
                'label_format' => $boolType->getLabel(),
                'constraints'  => SettingValidatorService::getValidators($boolType),
                'data'         => $boolType->getValue(),
            ]
        );
    }

}