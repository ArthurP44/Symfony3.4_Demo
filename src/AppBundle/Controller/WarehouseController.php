<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Warehouse;
use AppBundle\Form\WarehouseType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class WarehouseController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"warehouse"})
     * @Rest\Get("/categories/{id}/warehouses")
     */
    public function getWarehousesAction(Request $request)
    {
        $category = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Category')
            ->find($request->get('id'));
        /* @var $category Category */

        if (empty($category)) {
            return $this->categoryNotFound();
        }

        return $category->getWarehouses();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"warehouse"})
     * @Rest\Post("/categories/{id}/warehouses")
     */
    public function postWarehousesAction(Request $request)
    {
        $category = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Category')
            ->find($request->get('id'));
        /* @var $category Category */

        if (empty($category)) {
            return $this->categoryNotFound();
        }

        $warehouse = new Warehouse();
        $warehouse->setCategory($category);
        $form = $this->createForm(WarehouseType::class, $warehouse);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($warehouse);
            $em->flush();
            return $warehouse;
        } else {
            return $form;
        }

    }

    private function categoryNotFound()
    {
        return View::create(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
    }
}