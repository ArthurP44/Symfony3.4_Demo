<?php


namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('currency_EUR', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice($number)
    {
        return $number.'€';
    }

}