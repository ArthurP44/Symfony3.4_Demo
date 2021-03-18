<?php


namespace AppBundle\Service;


class Capitalizer
{
    public function capitalizeString($str)
    {
        return strtoupper($str);
    }

}