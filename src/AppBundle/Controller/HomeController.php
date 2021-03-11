<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function indexAction()
    {
        $number = random_int(0, 100);

        return $this->render('pages/number.html.twig',[
            'number' => $number,
        ]);
    }
}
