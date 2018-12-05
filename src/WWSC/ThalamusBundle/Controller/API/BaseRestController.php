<?php

namespace WWSC\ThalamusBundle\Controller\API;

use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRestController extends FOSRestController
{
    /**
     * @param string $className
     *
     * @return EntityRepository
     */
    public function getRepository($className)
    {
        return $this->getDoctrine()->getManager()->getRepository($className);
    }

    public function baseSerialize($entity, $statusCode = 200, $additionalHeaders = []) {
        $response = new Response();
        if (!empty($additionalHeaders)) {
            foreach ($additionalHeaders as $key => $header) {
                $response->headers->set($key, $header);
            }
        }
        $response->setStatusCode($statusCode);

        $context = SerializationContext::create()->enableMaxDepthChecks();
        $context->setGroups(['default']);
        $context->setSerializeNull(true);
        $serializedEntity = $this->container->get(
            'jms_serializer')->serialize($entity,
            'json',
            $context);
        $response->setContent($serializedEntity);

        return $response;
    }

    public function handleForm(Request $request, $formType, $entity = null, array $options = array())
    {
        $formOptions = isset($options['formOptions']) ? $options['formOptions'] : array();
        $form = $this->get('form.factory')->createNamed(null, $formType, $entity,
            array_merge(
                array('csrf_protection' => false),
                $formOptions
            )
        );
        $form->submit($request->request->all());
        if ($form->isValid()) {
            return $form->getData();
        } else {
            return $this->serializeFormErrors($form);
        }
    }

    public function serializeFormErrors(\Symfony\Component\Form\Form $form)
    {
        $errors['errors'] = array();

        foreach ($form->getErrors() as $error) {
            $message = $error->getMessage();
            preg_match('/\`(.+)\`: (.+)/', $message, $matches);

            if (is_array($matches) && array_key_exists(1, $matches)) {
                $errors['errors'][$matches[1]] = $matches[2];
            } else {
                $errors['errors'][] = $message;
            }
        }

        $errors['errors'] = $this->serialize($form);

        return $errors;
    }

    private function serialize(\Symfony\Component\Form\Form $form)
    {
        $local_errors = array();
        foreach ($form->getIterator() as $key => $child) {
            foreach ($child->getErrors() as $error){
                $local_errors[$key] = $error->getMessage();
            }

            if (count($child->getIterator()) > 0) {
                $local_errors[$key] = $this->serialize($child);
            }
        }

        return $local_errors;
    }

    public function removeEntity($entity) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
    }
}
