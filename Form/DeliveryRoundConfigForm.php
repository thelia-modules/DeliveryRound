<?php

namespace DeliveryRound\Form;

use DeliveryRound\DeliveryRound;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints;

/**
 * Class DeliveryRoundConfigForm
 * @package DeliveryRound\Form
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundConfigForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'price',
                'number',
                [
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                    'label' => $this->translator->trans('Price', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'price'],
                    'data' => DeliveryRound::getConfigValue('price', 0)
                ]
            );
    }

    public function getName()
    {
        return 'deliveryround_config_form';
    }
}