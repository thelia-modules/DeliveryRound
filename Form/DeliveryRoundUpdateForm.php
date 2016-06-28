<?php
/**
 * Created by PhpStorm.
 * User: apenalver
 * Date: 28/06/2016
 * Time: 10:30
 */

namespace DeliveryRound\Form;

use DeliveryRound\DeliveryRound;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class DeliveryRoundUpdateForm
 * @package DeliveryRound/Form
 */
class DeliveryRoundUpdateForm extends DeliveryRoundForm
{
    /**
     * @inheritDoc
     */
    protected function buildForm()
    {
        parent::buildForm();

        $this->formBuilder
            ->add('id', 'integer', array(
                "label" => $this->translator->trans("Id", [], DeliveryRound::DOMAIN_NAME),
                "label_attr" => ["for" => "delivery-round-id"],
                "required" => true,
                "constraints" => [
                    new NotBlank()
                ],
                "attr" => array()
            ));
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return "deliveryround_update_form";
    }
}
