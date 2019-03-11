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
     */
    public function __construct()
    {
        $this->symfonyValidator = Validation::createValidator();
    }

    public function setParametersToValidate(AbstractType $abstractType)
    {
        $this->object = $abstractType;
        if(key_exists('validators', $abstractType->getParametersArray())) {
            $this->validators = $this->setValidators();
            $this->value = $abstractType->getValue();
            $this->validate();
        }else{
            $this->isValid = true;
            $this->errorMessage = [];
        }
        return $this;
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
        return self::getValidators($this->object);
    }

    /**
     * @param AbstractType $abstractType
     * @return array
     */
    public static function getValidators(AbstractType $abstractType)
    {
        $validatorsArray = [];
        if(key_exists('validators', $abstractType->getParametersArray()))
        {
            foreach($abstractType->getParametersArray()['validators'] as $validatorName => $validatorParameters)
            {
                try {
                    $validator = new \ReflectionClass('Symfony\Component\Validator\Constraints\\' . $validatorName);
                    if(is_array($validatorParameters))
                    {
                        $validatorsArray[] = $validator->newInstance($validatorParameters);
                    }else{
                        $validatorsArray[] = $validator->newInstance();
                    }
                }catch(\Exception $e)
                {
                    printf('StallfishCommonBundle: Don\'t find validator: %s', $validatorName);
                }
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
        if(count($this->errorMessage)){
            $this->isValid = false;
        }else{
            $this->isValid = true;
        }
    }

}