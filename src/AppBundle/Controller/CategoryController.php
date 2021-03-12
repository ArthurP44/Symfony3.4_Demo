<?php


namespace AppBundle\Controller;

use AppBundle\Form\CategoryType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;
use FOS\RestBundle\View\View;

class CategoryController extends Controller

//***********GET**************
//using FOSRestBundle => here the long way, with view, format (...)

{
    /**
     * @Rest\View(serializerGroups={"category"})
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
            return View::create(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $view = View::create($category);
        $view->setFormat('json');

        return $view;
    }
    //***********GET**************
    //using FOSRestBundle => here the short everything is set in config.yml + routing.yml (format, view...)
    /**
     * @Rest\View(serializerGroups={"category"})
     * @Rest\Get("/categories")
     */
    public function getCategoriesAction()
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
    }

    //***********POST**************
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"category"})
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

    //***********DELETE**************
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT, serializerGroups={"category"})
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

    //***********PUT**************
    //difference between patch and put is the clearMissing attribute set to true/false (to partially/entirely update the resource)
    /**
     * @Rest\View(serializerGroups={"category"})
     * @Rest\Put("/categories/{id}")
     */
    public function updateCategoriesAction(Request $request)
    {
        return $this->updateCategory($request, true);
    }

    //***********PATCH**************
    /**
     * @Rest\View(serializerGroups={"category"})
     * @Rest\Patch("/categories/{id}")
     */
    public function patchCategoriesAction(Request $request)
    {
        return $this->updateCategory($request, false);
    }


    public function updateCategory(Request $request, $clearMissing)
    {
        $category = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Category')
            ->find($request->get('id'));
        /* @var $category Category */

        if(empty($category)){
            return View::create(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $category;
        } else {
            return $form;
        }
    }
}