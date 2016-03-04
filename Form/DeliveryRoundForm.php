<?php

namespace DeliveryRound\Form;

use DeliveryRound\DeliveryRound;
use DeliveryRound\Model\Map\DeliveryRoundTableMap;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints;

/**
 * Class DeliveryRoundForm
 * @package DeliveryRound\Form
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'zipcode',
                'text',
                [
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                    'label' => $this->translator->trans('ZipCode', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'zipcode'],
                ]
            )
            ->add(
                'city',
                'text',
                [
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                    'label' => $this->translator->trans('City', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'city'],
                ]
            )
            ->add(
                'address',
                'text',
                [
                    'required' => false,
                    'label' => $this->translator->trans('Address', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'address'],
                ]
            )
            ->add(
                'day',
                'choice',
                [
                    'choices' => DeliveryRoundTableMap::getValueSet(DeliveryRoundTableMap::DAY),
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                    'label' => $this->translator->trans('Day', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'day'],
                ]
            )
            ->add(
                'delivery_period',
                'text',
                [
                    'required' => false,
                    'label' => $this->translator->trans('Delivery period', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'delivery_period'
                    ],
                ]
            );
    }

    public function getName()
    {
        return 'deliveryround_form';
    }
}