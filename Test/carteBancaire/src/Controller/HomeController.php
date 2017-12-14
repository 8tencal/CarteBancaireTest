<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class HomeController
{

	/**
	* @Route("/", name = "home" )
	*
	* @param Request $request 	
	* @return Response
	*/

	public function __invoke(Request $request) : Response 
	{
		return new Response('Bitch');
	}
}