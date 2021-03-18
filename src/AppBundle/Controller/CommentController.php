<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommentController extends Controller
{
    /**
     * @Route("/comment/new", name="comment_new")
     * @param Request $request
     * @return Response|null
     */
    public function newAction(Request $request)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Comment created!');

            return $this->redirectToRoute('comment_list');
        }

        return $this->render(
            'form/newComment.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/comment/list", name="comment_list")
     * @param Request $request
     * @return Response|null
     */
    public function listAction(Request $request)
    {
        $comments = $this->getDoctrine()->getManager()->getRepository(Comment::class)->findAll();

        return $this->render('pages/comment/list.html.twig',[
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/comment/{id}", name="comment_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository(Comment::class)->findOneBy(['id' => $id]);

        return $this->render('pages/comment/show.html.twig',[
            'comment' => $comment
        ]);
    }



}