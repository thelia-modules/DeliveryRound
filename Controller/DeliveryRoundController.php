<?php

namespace DeliveryRound\Controller;

use DeliveryRound\DeliveryRound;
use DeliveryRound\Form\DeliveryRoundConfigForm;
use DeliveryRound\Form\DeliveryRoundDeleteForm;
use DeliveryRound\Form\DeliveryRoundForm;
use DeliveryRound\Form\DeliveryRoundUpdateForm;
use DeliveryRound\Model\DeliveryRound as DeliveryRoundModel;
use DeliveryRound\Model\DeliveryRoundQuery;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Propel;
use Symfony\Component\Routing\Attribute\Route;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Translation\Translator;
use Thelia\Form\Exception\FormValidationException;

/**
 * Class DeliveryRoundController
 * @package DeliveryRound\Controller
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundController extends BaseAdminController
{
    /**
     * @return mixed|Response
     */
    #[Route('/admin/module/DeliveryRound/config', name: 'deliveryround_config')]
    public function configureAction(): mixed
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["DeliveryRound"], AccessManager::CREATE)) {
            return $response;
        }

        $form = $this->createForm(DeliveryRoundConfigForm::getName());
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
                Translator::getInstance()->trans("DeliveryRound configuration", [], DeliveryRound::DOMAIN_NAME),
                $error,
                $form,
                $ex
            );
        }

        return $this->render('module-configure', array('module_code' => 'DeliveryRound'));
    }

    /**
     * @return mixed|Response
     */
    #[Route('/admin/module/DeliveryRound/addLocation', name: 'deliveryround_addlocation')]
    public function addLocationAction(): mixed
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["DeliveryRound"], AccessManager::CREATE)) {
            return $response;
        }

        $form = $this->createForm(DeliveryRoundForm::getName());
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
                Translator::getInstance()->trans("DeliveryRound configuration", [], DeliveryRound::DOMAIN_NAME),
                $error,
                $form,
                $ex
            );
        }

        return $this->render('module-configure', array('module_code' => 'DeliveryRound'));
    }

    /**
     * @return mixed|Response
     */
    #[Route('/admin/module/DeliveryRound/delete', name: 'deliveryround_delete')]
    public function deleteAction(): mixed
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["DeliveryRound"], AccessManager::DELETE)) {
            return $response;
        }

        $form = $this->createForm(DeliveryRoundDeleteForm::getName());
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
                Translator::getInstance()->trans("DeliveryRound configuration", [], DeliveryRound::DOMAIN_NAME),
                $error,
                $form,
                $ex
            );
        }

        return $this->render('module-configure', array('module_code' => 'DeliveryRound'));
    }

    /**
     * @return mixed|Response
     */
    #[Route('/admin/module/DeliveryRound/update', name: 'deliveryround_update')]
    public function updateAction(): mixed
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["DeliveryRound"], AccessManager::UPDATE)) {
            return $response;
        }

        $con = Propel::getConnection();
        $con->beginTransaction();

        $form = $this->createForm(DeliveryRoundUpdateForm::getName());
        $error = null;
        $ex = null;

        try {
            $vForm = $this->validateForm($form);
            $data = $vForm->getData();

            $model = DeliveryRoundQuery::create()->findOneById($data['id']);
            $model?->fromArray($data, TableMap::TYPE_FIELDNAME);
            $model?->save();

            $con->commit();
        } catch (FormValidationException $ex) {
            $error = $this->createStandardFormValidationErrorMessage($ex);
            $con->rollBack();
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
            $con->rollBack();
        }

        if ($error !== null) {
            $this->setupFormErrorContext(
                Translator::getInstance()->trans("DeliveryRound configuration", [], DeliveryRound::DOMAIN_NAME),
                $error,
                $form,
                $ex
            );
        }

        return $this->render('module-configure', array('module_code' => 'DeliveryRound'));
    }
}
