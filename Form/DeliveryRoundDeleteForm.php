<?php

namespace DeliveryRound\Form;

use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints;

/**
 * Class DeliveryRoundDeleteForm
 * @package DeliveryRound\Form
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundDeleteForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'id',
                'integer',
                [
                    'constraints' => [new Constraints\NotBlank()],
                    'required' => true,
                ]
            );
    }
}