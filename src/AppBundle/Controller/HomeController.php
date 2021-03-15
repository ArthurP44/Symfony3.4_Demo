<?php


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Simple\FilesystemCache;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $number = $this->cacheLuckyNumber();

        return $this->render('pages/number.html.twig',[
            'number' => $number,
        ]);
    }

    // cache & return lucky number
    public function cacheLuckyNumber(){
        $cache = new FilesystemCache();

        // if this cache item doesn't exist
        if (!$cache->has('result.luckyNumber')){
            //store data in cache item & save it
            $cache->set('result.luckyNumber', random_int(0, 100), 5);
        }
        //retrieve cached data
        return $cache->get('result.luckyNumber');
    }
}
