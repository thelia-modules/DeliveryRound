<?php

namespace DeliveryRound\Form;

use DeliveryRound\DeliveryRound;
use DeliveryRound\Model\Map\DeliveryRoundTableMap;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints;

/**
 * Class DeliveryRoundForm
 * @package DeliveryRound\Form
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundForm extends BaseForm
{
    /**
     * @return void
     */
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'zipcode',
                TextType::class,
                [
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                    'label' => Translator::getInstance()->trans('ZipCode', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'delivery-round-zipcode'],
                ]
            )
            ->add(
                'city',
                TextType::class,
                [
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                    'label' => Translator::getInstance()->trans('City', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'delivery-round-city'],
                ]
            )
            ->add(
                'address',
                TextType::class,
                [
                    'required' => false,
                    'label' => Translator::getInstance()->trans('Address', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'delivery-round-address'],
                ]
            )
            ->add(
                'day',
                ChoiceType::class,
                [
                    'choices' => DeliveryRoundTableMap::getValueSet(DeliveryRoundTableMap::DAY),
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                    'label' => Translator::getInstance()->trans('Day', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'delivery-round-day'],
                ]
            )
            ->add(
                'delivery_period',
                TextType::class,
                [
                    'required' => false,
                    'label' => Translator::getInstance()->trans('Delivery period', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'delivery-round-delivery_period'
                    ],
                ]
            );
    }

    public static function getName(): string
    {
        return 'deliveryround_form';
    }
}
