<?php

namespace DeliveryRound\Form;

use DeliveryRound\DeliveryRound;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints;

/**
 * Class DeliveryRoundConfigForm
 * @package DeliveryRound\Form
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundConfigForm extends BaseForm
{
    /**
     * @return void
     */
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'price',
                NumberType::class,
                [
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                    'label' => Translator::getInstance()->trans('Price', [], DeliveryRound::DOMAIN_NAME),
                    'label_attr' => ['for' => 'price'],
                    'data' => DeliveryRound::getConfigValue('price', 0)
                ]
            );
    }

    public static function getName(): string
    {
        return 'deliveryround_config_form';
    }
}
