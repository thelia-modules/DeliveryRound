<?php

namespace DeliveryRound\Controller;

use DeliveryRound\DeliveryRound;
use DeliveryRound\Form\DeliveryRoundConfigForm;
use DeliveryRound\Form\DeliveryRoundDeleteForm;
use DeliveryRound\Form\DeliveryRoundForm;
use DeliveryRound\Form\DeliveryRoundUpdateForm;
use DeliveryRound\Model\DeliveryRound as DeliveryRoundModel;
use DeliveryRound\Model\DeliveryRoundQuery;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Translation\Translator;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;

/**
 * Class DeliveryRoundController
 * @package DeliveryRound\Controller
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundController extends BaseAdminController
{
    #[Route('/admin/module/DeliveryRound/config', name: 'deliveryround_config', methods: ['POST'])]
    public function configureAction(Request $request): Response
    {
        return $this->handle($request, DeliveryRoundConfigForm::getName(), AccessManager::UPDATE, static function (Form $form): void {
            DeliveryRound::setConfigValue('price', $form->get('price')->getData());
        });
    }

    #[Route('/admin/module/DeliveryRound/addLocation', name: 'deliveryround_addlocation', methods: ['POST'])]
    public function addLocationAction(Request $request): Response
    {
        return $this->handle($request, DeliveryRoundForm::getName(), AccessManager::CREATE, function (Form $form): void {
            $this->hydrate(new DeliveryRoundModel(), $form)->save();
        });
    }

    #[Route('/admin/module/DeliveryRound/update', name: 'deliveryround_update', methods: ['POST'])]
    public function updateAction(Request $request): Response
    {
        return $this->handle($request, DeliveryRoundUpdateForm::getName(), AccessManager::UPDATE, function (Form $form): void {
            if (null === $deliveryRound = DeliveryRoundQuery::create()->findPk((int) $form->get('id')->getData())) {
                throw new \RuntimeException(Translator::getInstance()->trans('This delivery round does not exist.', [], DeliveryRound::DOMAIN_NAME));
            }

            $this->hydrate($deliveryRound, $form)->save();
        });
    }

    #[Route('/admin/module/DeliveryRound/delete', name: 'deliveryround_delete', methods: ['POST'])]
    public function deleteAction(Request $request): Response
    {
        return $this->handle($request, DeliveryRoundDeleteForm::getName(), AccessManager::DELETE, static function (Form $form): void {
            DeliveryRoundQuery::create()->filterById((int) $form->get('id')->getData())->delete();
        });
    }

    /**
     * Checks the access, validates the form, runs the action and always redirects back to the
     * module configuration page, with a flash message telling what happened.
     *
     * @param callable(Form): void $action
     */
    private function handle(Request $request, string $formName, string $access, callable $action): Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['DeliveryRound'], $access)) {
            return $response;
        }

        $translator = Translator::getInstance();
        $form = $this->createForm($formName);

        try {
            $action($this->validateForm($form, 'POST'));

            $request->getSession()->getFlashBag()->add('success', $translator->trans('Delivery rounds updated.', [], DeliveryRound::DOMAIN_NAME));
        } catch (FormValidationException $ex) {
            $request->getSession()->getFlashBag()->add('danger', $this->createStandardFormValidationErrorMessage($ex));
        } catch (\Exception $ex) {
            $request->getSession()->getFlashBag()->add('danger', $ex->getMessage());
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/DeliveryRound'));
    }

    private function hydrate(DeliveryRoundModel $deliveryRound, Form $form): DeliveryRoundModel
    {
        return $deliveryRound
            ->setZipCode(trim((string) $form->get('zipcode')->getData()))
            ->setCity((string) $form->get('city')->getData())
            ->setAddress($form->get('address')->getData())
            ->setDay($form->get('day')->getData())
            ->setDeliveryPeriod($form->get('delivery_period')->getData());
    }
}
