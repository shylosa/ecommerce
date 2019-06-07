<?php
namespace App\Controller\Admin;
use App\Entity\Order;
use App\Form\MoneyTransformer;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
class OrderController extends CRUDController
{
    public function recalcAction($id)
    {
        $object = $this->admin->getSubject();
        $form = $this->admin->getForm();
        if (!\is_array($fields = $form->all()) || 0 === \count($fields)) {
            throw new \RuntimeException(
                'No editable field defined. Did you forget to implement the "configureFormFields" method?'
            );
        }
        $form->setData($object);
        $form->handleRequest($this->getRequest());
        if ($form->isSubmitted()) {
            $isFormValid = $form->isValid();
            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                /** @var Order $submittedObject */
                $submittedObject = $form->getData();
                foreach ($submittedObject->getOrderItems() as $item) {
                    $item->updateAmount();
                }
                $transformer = new MoneyTransformer();
                $result = [
                    'amount' => $transformer->transform($submittedObject->getAmount()),
                    'items' => [],
                ];
                foreach ($submittedObject->getOrderItems() as $item) {
                    $result['items'][] = $transformer->transform($item->getAmount());
                }
                return new JsonResponse($result);
            }
        }
        return new JsonResponse(false);
    }
}