<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 01.03.2019
 * Time: 19:56
 */

namespace Stallfish\CmsCommonBundle\Service;

use Stallfish\CmsCommonBundle\Settings\SettingType\AbstractType;
use Symfony\Component\Validator\Validation;

class SettingValidatorService
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var array
     */
    private $validators;

    /**
     * @var AbstractType
     */
    private $object;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private $symfonyValidator;

    /**
     * @var
     */
    private $violations;

    /**
     * @var
     */
    private $isValid;

    /**
     * @var array
     */
    private $errorMessage = [];

    /**
     * SettingValidatorService constructor.
     * @param AbstractType $abstractType
     */
    public function __construct(AbstractType $abstractType)
    {
        $this->object = $abstractType;
        $this->validators = $this->setValidators();
        $this->symfonyValidator = Validation::createValidator();
        $this->value = $abstractType->getValue();
        $this->validate();
    }

    /**
     * @return bool
     */
    public function isValid():bool
    {
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getErrorMessage():array
    {
        return $this->errorMessage;
    }

    /**
     * @return array
     */
    private function setValidators()
    {
        $validatorsArray = [];
        foreach($this->object->getParametersArray()['validators'] as $validatorParameters)
        {
            try {
                $validator = new \ReflectionClass('Symfony\Component\Validator\Constraints\\'.$validatorParameters['class']);
                if(key_exists('params', $validatorParameters) && is_array($validatorParameters['params']) && !empty($validatorParameters['params']))
                {
                    $validatorsArray[] = $validator->newInstance($validatorParameters['params']);
                }else{
                    $validatorsArray[] = $validator->newInstance();
                }
            }catch(\Exception $e)
            {
                printf('StallfishCommonBundle: Don\'t find validator: %s', $validatorParameters['class']);
            }
        }

        return $validatorsArray;
    }

    private function validate()
    {
        $this->violations = $this->symfonyValidator->validate($this->value, $this->validators);
        foreach($this->violations as $violation)
        {
            $this->errorMessage[] = $violation->getMessage();
        }
        $this->isValid = (bool)count($this->errorMessage);
    }

}