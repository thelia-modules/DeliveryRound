<?php

namespace DeliveryRound\Controller;

use DeliveryRound\DeliveryRound;
use DeliveryRound\Model\DeliveryRound as DeliveryRoundModel;
use DeliveryRound\Model\DeliveryRoundQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;

/**
 * Class DeliveryRoundController
 * @package DeliveryRound\Controller
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundController extends BaseAdminController
{
    /**
     * @return mixed|\Thelia\Core\HttpFoundation\Response
     */
    public function configureAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["DeliveryRound"], AccessManager::CREATE)) {
            return $response;
        }

        $form = $this->createForm('deliveryround_config_form');
        $error = null;
        $ex = null;

        try {
            $vForm = $this->validateForm($form);

            // Configure price
            DeliveryRound::setConfigValue('price', $vForm->get('price')->getData());

        } catch (FormValidationException $ex) {
            $error = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }

        if ($error !== null) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("DeliveryRound configuration", [], DeliveryRound::DOMAIN_NAME),
                $error,
                $form,
                $ex
            );
        }

        return $this->render('module-configure', array('module_code' => 'DeliveryRound'));
    }

    /**
     * @return mixed|\Thelia\Core\HttpFoundation\Response
     */
    public function addLocationAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["DeliveryRound"], AccessManager::CREATE)) {
            return $response;
        }

        $form = $this->createForm('deliveryround_form');
        $error = null;
        $ex = null;

        try {
            $vForm = $this->validateForm($form);

            // Create new entry
            (new DeliveryRoundModel())
                ->setZipCode($vForm->get('zipcode')->getData())
                ->setCity($vForm->get('city')->getData())
                ->setAddress($vForm->get('address')->getData())
                ->setDay($vForm->get('day')->getData())
                ->setDeliveryPeriod($vForm->get('delivery_period')->getData())
                ->save();

        } catch (FormValidationException $ex) {
            $error = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }

        if ($error !== null) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("DeliveryRound configuration", [], DeliveryRound::DOMAIN_NAME),
                $error,
                $form,
                $ex
            );
        }

        return $this->render('module-configure', array('module_code' => 'DeliveryRound'));
    }

    /**
     * @return mixed|\Thelia\Core\HttpFoundation\Response
     */
    public function deleteAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["DeliveryRound"], AccessManager::DELETE)) {
            return $response;
        }

        $form = $this->createForm('deliveryround_delete_form');
        $error = null;
        $ex = null;

        try {
            $vForm = $this->validateForm($form);

            // Remove entry
            DeliveryRoundQuery::create()->filterById($vForm->get('id')->getData())->delete();

        } catch (FormValidationException $ex) {
            $error = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
        }

        if ($error !== null) {
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("DeliveryRound configuration", [], DeliveryRound::DOMAIN_NAME),
                $error,
                $form,
                $ex
            );
        }

        return $this->render('module-configure', array('module_code' => 'DeliveryRound'));
    }
}