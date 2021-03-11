<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use AppBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product")
 */
class ProductController extends Controller
{
    /**
     * @Route("/new", name="_new")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_show');
        }

        return $this->render(
            'form/newProduct.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/show", name="_show")
     */
    public function showAction()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('pages/show.html.twig',[
            'products' => $products
        ]);

    }

    // if you have multiple entity managers, use the registry to fetch them
    public function editAction()
    {
        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $otherEntityManager = $doctrine->getManager('other_connection');
    }
}