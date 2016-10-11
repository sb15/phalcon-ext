<?php

namespace Sb\Phalcon\Form;

use Phalcon\Forms\Form;
use Phalcon\Filter;

/**
 * Class Basic
 * @package Form
 *
 * @property \Sb\Phalcon\Model\Repository modelsRepository
 * @property \Sb\Phalcon\Form\Repository formsRepository
 */
class Basic extends Form
{
    const FORM_ELEMENT_CHECK = '\\Phalcon\\Forms\\Element\\Check';
    const FORM_ELEMENT_DATE = '\\Phalcon\\Forms\\Element\\Date';
    const FORM_ELEMENT_EMAIL = '\\Phalcon\\Forms\\Element\\Email';
    const FORM_ELEMENT_FILE = '\\Phalcon\\Forms\\Element\\File';
    const FORM_ELEMENT_HIDDEN = '\\Phalcon\\Forms\\Element\\Hidden';
    const FORM_ELEMENT_NUMERIC = '\\Phalcon\\Forms\\Element\\Numeric';
    const FORM_ELEMENT_PASSWORD = '\\Phalcon\\Forms\\Element\\Password';
    const FORM_ELEMENT_RADIO = '\\Phalcon\\Forms\\Element\\Radio';
    const FORM_ELEMENT_SELECT = '\\Phalcon\\Forms\\Element\\Select';
    const FORM_ELEMENT_SUBMIT = '\\Phalcon\\Forms\\Element\\Submit';
    const FORM_ELEMENT_TEXT = '\\Phalcon\\Forms\\Element\\Text';
    const FORM_ELEMENT_TEXTAREA = '\\Phalcon\\Forms\\Element\\TextArea';

    const FORM_FILTER_EMAIL = "email";
    const FORM_FILTER_ABSINT = "absint";
    const FORM_FILTER_INT = "int";
    const FORM_FILTER_INT_CAST = "int!";
    const FORM_FILTER_STRING = "string";
    const FORM_FILTER_FLOAT = "float";
    const FORM_FILTER_FLOAT_CAST = "float!";
    const FORM_FILTER_ALPHANUM = "alphanum";
    const FORM_FILTER_TRIM = "trim";
    const FORM_FILTER_STRIPTAGS = "striptags";
    const FORM_FILTER_LOWER = "lower";
    const FORM_FILTER_UPPER = "upper";

    const FROM_VALIDATOR_ALNUM = '\\Phalcon\\Validation\\Validator\\Alnum';
    const FROM_VALIDATOR_ALPHA = '\\Phalcon\\Validation\\Validator\\Alpha';
    const FROM_VALIDATOR_BETWEEN = '\\Phalcon\\Validation\\Validator\\Between';
    const FROM_VALIDATOR_CONFIRMATION = '\\Phalcon\\Validation\\Validator\\Confirmation';
    const FROM_VALIDATOR_CREDIT_CARD = '\\Phalcon\\Validation\\Validator\\CreditCard';
    const FROM_VALIDATOR_DIGIT = '\\Phalcon\\Validation\\Validator\\Digit';
    const FROM_VALIDATOR_EMAIL = '\\Phalcon\\Validation\\Validator\\Email';
    const FROM_VALIDATOR_EXCLUSION_IN = '\\Phalcon\\Validation\\Validator\\ExclusionIn';
    const FROM_VALIDATOR_FILE = '\\Phalcon\\Validation\\Validator\\File';
    const FROM_VALIDATOR_IDENTICAL = '\\Phalcon\\Validation\\Validator\\Identical';
    const FROM_VALIDATOR_INCLUSION_IN = '\\Phalcon\\Validation\\Validator\\InclusionIn';
    const FROM_VALIDATOR_NUMERICALITY = '\\Phalcon\\Validation\\Validator\\Numericality';
    const FROM_VALIDATOR_PRESENCE_OF = '\\Phalcon\\Validation\\Validator\\PresenceOf';
    const FROM_VALIDATOR_REGEX = '\\Phalcon\\Validation\\Validator\\Regex';
    const FROM_VALIDATOR_STRING_LENGTH = '\\Phalcon\\Validation\\Validator\\StringLength';
    const FROM_VALIDATOR_UNIQUENESS = '\\Phalcon\\Validation\\Validator\\Uniqueness';
    const FROM_VALIDATOR_URL = '\\Phalcon\\Validation\\Validator\\Url';

    //protected $fields = [];

    protected $fields = [
        'email' => [
            'type' => [
                self::FORM_ELEMENT_EMAIL => [
                    //'placeholder' => 'Email',
                    'class' => 'form-control fg-input input-lg',
                ]
            ],
            'label' => 'Email',
            'filters' => [
                self::FORM_FILTER_TRIM
            ],
            'validators' => [
                'PresenceOf' => [
                    'message' => 'Поле Email обязательно для заполнения',
                ],
                'Email' => [
                    'message' => 'Email не верен',
                ]
            ]
        ],
    ];


    public function initialize()
    {
        // fields, validators, filters

        foreach ($this->fields as $fieldName => $field) {
            $elementClass = array_keys($field['type'])[0];
            $attributes = $field['type'][$elementClass];

            /** @var \Phalcon\Forms\ElementInterface $element */
            $element = new $elementClass($fieldName, $attributes);

            $element->setFilters($field['filters']);

            foreach ($field['validators'] as $validatorClass => $validatorOptions) {

                /** @var \Phalcon\Validation\ValidatorInterface $validator */
                $validator = new $validatorClass($validatorOptions);
                $element->addValidator($validator);

            }

            if (array_key_exists('label', $field)) {
                $element->setLabel($field['label']);
            }

            $this->add($element);
        }

    }

    public function renderThemed($name, $attributes = null)
    {
        //
        return parent::render($name, $attributes);
    }

    public function getJavascriptValidationOptions()
    {

    }

    public function isValidAfterBind($post, $entity)
    {

    }

}