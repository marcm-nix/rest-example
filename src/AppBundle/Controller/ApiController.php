<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use AppBundle\Entity\Users as User;
use AppBundle\Entity\Food;


/**
 * @Route("/api")
 */
class ApiController extends FOSRestController
{
    /**
     * Method POST
     *
     * Param string  $name
     * Param float  $price
     * Param string _format "json|xml"
     *
     * @Route("/create/{name}/{price}.{_format}", requirements={"_format"="json|xml"})
     */
    public function postCreateAction($name, $price)
    {

        if(!$this->_accessVeriefer('create'))
            return ['status' => 'failure', 'message' => 'access denied'];

        $em = $this->getDoctrine()->getManager();
        $food = new Food();

        $food->setName($name);
        $food->setPrice($price);
        $em->persist($food);
        $em->flush();

        return ['status' => 'success', 'message' => 'added new product'];
    }

    /**
     *
     * Method GET
     *
     * Param string  $name
     * Param float  $price
     * Param string _format "json|xml"
     *
     * @Route("/read.{_format}", requirements={"_format"="json|xml"})
     */
    public function getReadAction()
    {
        if(!$this->_accessVeriefer('read'))
            return ['status' => 'failure', 'message' => 'access denied'];

        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:Food')->findAll();
    }

    /**
     *
     * Method POST
     *
     * Param integer  $id
     * Param float  $price
     * Param string _format "json|xml"
     *
     * @Route("/update/{id}/{price}.{_format}", requirements={"_format"="json|xml"})
     * @View()
     */
    public function postUpdateAction($id, $price)
    {
        if(!$this->_accessVeriefer('update'))
            return ['status' => 'failure', 'message' => 'access denied'];


        $em = $this->getDoctrine()->getManager();
        $food = $em->getRepository('AppBundle:Food')->find($id);

        if(!$food)
            return ['status' => 'failure', 'message' => 'no given product'];


        $food->setPrice($price);
        $em->persist($food);
        $em->flush();

        return ['status' => 'success', 'message' => 'product updated'];

    }

    /**
     *
     * Method POST
     *
     * Param integer $id 
     *
     * @Route("/delete/{id}.{_format}", requirements={"_format"="json|xml"})
     * @View()
     */
    public function postDeleteAction($id)
    {

        if(!$this->_accessVeriefer('delete'))
            return ['status' => 'failure', 'message' => 'access denied'];

        $em = $this->getDoctrine()->getManager();
        $food = $em->getRepository('AppBundle:Food')->find($id);

        if(!$food)
            return ['status' => 'failure', 'message' => 'no given product'];

        $em->remove($food);
        $em->flush();

        return ['status' => 'success', 'message' => 'product removed'];

    }



    /*
     * Param string $action "create|update|delete|read"
     *
     */
    private function _accessVeriefer($action)
    {
        $roles = $this->getUser()->getRoles();

        if(in_array(User::ROLE_SUPER_ADMIN, $roles))
            return true;


        $adminRights = ['create', 'update', 'delete'];
        $adminRights[] = 'read';
        if(in_array(User::ROLE_ADMIN, $roles) &&  in_array($action, $adminRights))
            return true;


        if(in_array(User::ROLE_USER, $roles) && action == 'read')
            return true;



        return false;


    } 
}
