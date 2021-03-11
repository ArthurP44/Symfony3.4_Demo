<?php


namespace AppBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;

class CategoryController extends Controller

//using FOSRestBundle => here the long way, with view, format (...)
{
    /**
     * @Rest\View()
     * @Rest\Get("/categories/{id}")
     * @param Request $request
     * @return View|JsonResponse
     */
    public function getProductAction(Request $request)
    {
        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category')
            ->find($request->get('id'));

        /* @var $category Category */

        if (empty($category)) {
            return new JsonResponse(['message' => 'category not found'], Response::HTTP_NOT_FOUND);
        }

        $view = View::create($category);
        $view->setFormat('json');

        return $view;
    }

    //using FOSRestBundle => here the short everything is set in config.yml + routing.yml (format, view...)
    /**
     * @Rest\View()
     * @Rest\Get("/categories")
     */
    public function getProductsAction()
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
    }
}