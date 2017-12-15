<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/14/17
 * Time: 10:58 PM
 */

namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



class AccueilController
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @Route("/", name = "accueil" )
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request) : Response
    {

        return new Response(
            $this->twig->render('pages/accueil.html.twig')
        );
    }
}