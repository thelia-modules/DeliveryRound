<?php
/**
 * Created by PhpStorm.
 * User: apenalver
 * Date: 28/06/2016
 * Time: 10:30
 */

namespace DeliveryRound\Form;

use DeliveryRound\DeliveryRound;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;

/**
 * Class DeliveryRoundUpdateForm
 * @package DeliveryRound/Form
 */
class DeliveryRoundUpdateForm extends DeliveryRoundForm
{
    /**
     * @inheritDoc
     */
    protected function buildForm(): void
    {
        parent::buildForm();

        $this->formBuilder
            ->add('id', IntegerType::class,
                [
                    "label" => Translator::getInstance()->trans("Id", [], DeliveryRound::DOMAIN_NAME),
                    "label_attr" => ["for" => "delivery-round-id"],
                    "required" => true,
                    "constraints" => [
                        new NotBlank()
                    ],
                    "attr" => array()
                ]
            );
    }

    /**
     * @inheritDoc
     */
    public static function getName(): string
    {
        return "deliveryround_update_form";
    }
}
