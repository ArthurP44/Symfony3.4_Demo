<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Product;
use AppBundle\Form\CategoryType;
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
    public function getCategoryAction(Request $request)
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
    public function getCategoriesAction()
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/categories")
     * @param Request $request
     * @return Category
     */
    public function postCategoriesAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $category;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/categories/{id}")
     */
    public function removeCategoriesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')
            ->find($request->get('id'));

        /* @var $place Category */
        if($category){
            $em->remove($category);
            $em->flush();
        }
    }
}