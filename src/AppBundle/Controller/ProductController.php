<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Product;
use AppBundle\Event\ProductPublishedEvent;
use AppBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
     * @param EventDispatcherInterface $dispatcher
     * @return Response
     */
    public function createAction(Request $request, EventDispatcherInterface $dispatcher)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            //use event to display message after flush
            $event = new ProductPublishedEvent($product);
            $dispatcher->dispatch(ProductPublishedEvent::NAME, $event);

            // comment return because the message willnot be seen with redirect
            //return $this->redirectToRoute('product_show');
        }

        return $this->render(
            'form/newProduct.html.twig',
            [
                'form' => $form->createView(),
            ]
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

        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findAll();

        return $this->render('pages/product/show.html.twig',[
            'products' => $products,
            'comments' => $comments
        ]);

    }

    /**
     * @Route("/list", name="_list")
     */
    public function getCommentsOrdered()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')
            ->findProductOrderedByCommentNumber();

        return $this->render('pages/product/list.html.twig',[
            'products' => $products
        ]);
    }

}