<?php 

namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



class HomeController
{

	

	 private $twig;

    public function __construct(Environment $twig)
    {
    	$this->twig = $twig;
    }



    /**
	* @Route("/home", name = "home")
	*
	* @param Request $request 	
	* @return Response
	*/


	public function __invoke(Request $request) : Response 
	{	
		$name = $request->query->get('name','world');

		return new Response(

	   $this->twig->render('pages/home.html.twig',compact('name'))
	   );
	}
}