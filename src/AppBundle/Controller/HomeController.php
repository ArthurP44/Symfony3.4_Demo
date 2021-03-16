<?php


namespace AppBundle\Controller;

use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;
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
        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');

        $sentence = 'Your *lucky number* is : ';
        //$sentence = $this->get('markdown.parser')->transform($sentence);
        $key = md5($sentence);

        //caching $sentence with doctrine_cache
        if ($cache->contains($key)) {
            $sentence = $cache->fetch($key);
        } else {
            sleep(3);
            $sentence = $this->get('markdown.parser')
                ->transform($sentence);
            $cache->save($key, $sentence);
        }
        // caching $number with symfony cache
        $number = $this->cacheLuckyNumber();

        $result = $sentence.$number;

        return $this->render('pages/number.html.twig',[
            'number' => $result,
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
