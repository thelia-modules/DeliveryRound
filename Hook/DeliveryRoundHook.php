<?php

namespace DeliveryRound\Hook;

use DeliveryRound\Form\DeliveryRoundConfigForm;
use DeliveryRound\Form\DeliveryRoundDeleteForm;
use DeliveryRound\Form\DeliveryRoundForm;
use DeliveryRound\Form\DeliveryRoundUpdateForm;
use DeliveryRound\Model\DeliveryRoundQuery;
use DeliveryRound\Model\Map\DeliveryRoundTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Form\TheliaFormFactory;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Template\Parser\ParserResolver;

/**
 * Class DeliveryRoundHook
 * @package DeliveryRound\Hook
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundHook extends BaseHook
{
    /** Sort keys accepted on the configuration page => [column, direction]. */
    private const ORDERS = [
        'day' => [DeliveryRoundTableMap::COL_DAY, Criteria::ASC],
        'day-reverse' => [DeliveryRoundTableMap::COL_DAY, Criteria::DESC],
        'city' => [DeliveryRoundTableMap::COL_CITY, Criteria::ASC],
        'city-reverse' => [DeliveryRoundTableMap::COL_CITY, Criteria::DESC],
        'zipcode' => [DeliveryRoundTableMap::COL_ZIP_CODE, Criteria::ASC],
        'zipcode-reverse' => [DeliveryRoundTableMap::COL_ZIP_CODE, Criteria::DESC],
    ];

    public function __construct(
        private readonly TheliaFormFactory $formFactory,
        ?EventDispatcherInterface $dispatcher = null,
        ?ParserResolver $parserResolver = null,
    ) {
        parent::__construct($dispatcher, $parserResolver);
    }

    public static function getSubscribedHooks(): array
    {
        return [
            'module.configuration' => [
                ['type' => 'back', 'method' => 'onModuleConfig'],
            ],
            'order-delivery.extra' => [
                ['type' => 'front', 'method' => 'onOrderDeliveryExtra'],
            ],
        ];
    }

    public function onModuleConfig(HookRenderEvent $event): void
    {
        $order = (string) ($this->getRequest()?->query->get('order', 'day') ?? 'day');
        $order = \array_key_exists($order, self::ORDERS) ? $order : 'day';
        [$column, $direction] = self::ORDERS[$order];

        $rounds = [];
        foreach (DeliveryRoundQuery::create()->orderBy($column, $direction)->find() as $deliveryRound) {
            $rounds[] = [
                'id' => $deliveryRound->getId(),
                'update_form' => $this->createFormView(DeliveryRoundUpdateForm::getName(), [
                    'id' => $deliveryRound->getId(),
                    'zipcode' => $deliveryRound->getZipCode(),
                    'city' => $deliveryRound->getCity(),
                    'address' => $deliveryRound->getAddress(),
                    'day' => $deliveryRound->getDay(),
                    'delivery_period' => $deliveryRound->getDeliveryPeriod(),
                ]),
                'delete_form' => $this->createFormView(DeliveryRoundDeleteForm::getName(), ['id' => $deliveryRound->getId()]),
            ];
        }

        $event->add($this->render('deliveryround/module-configuration.html.twig', [
            'config_form' => $this->createFormView(DeliveryRoundConfigForm::getName()),
            'add_form' => $this->createFormView(DeliveryRoundForm::getName()),
            'rounds' => $rounds,
            'order' => $order,
        ]));
    }

    public function onOrderDeliveryExtra(HookRenderEvent $event): void
    {
        $event->add($this->render('show-round-list.html.twig', [
            'rounds' => DeliveryRoundQuery::create()->orderByDay()->orderByCity()->find(),
        ]));
    }

    private function createFormView(string $name, array $data = []): \Symfony\Component\Form\FormView
    {
        return $this->formFactory->createForm($name, data: $data)->createView()->getView();
    }
}
