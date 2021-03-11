<?php


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{id}", requirements={"place_id" = "\d+"}, name="single_category", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
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

        $formatted = [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ];

        return new JsonResponse($formatted);
    }

    /**
     * @Route("/category_list", name="category_list", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductsAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category')
            ->findAll();

        /* @var $categories Category[] */

        $formatted = [];
        foreach ($categories as $category) {
            $formatted[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
            ];
        }
        return new JsonResponse($formatted);
    }
}