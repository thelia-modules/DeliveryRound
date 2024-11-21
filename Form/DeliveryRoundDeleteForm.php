<?php

namespace DeliveryRound\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints;

/**
 * Class DeliveryRoundDeleteForm
 * @package DeliveryRound\Form
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundDeleteForm extends BaseForm
{
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'id',
                IntegerType::class,
                [
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                ]
            );
    }

    public static function getName(): string
    {
        return 'deliveryround_delete_form';
    }
}
