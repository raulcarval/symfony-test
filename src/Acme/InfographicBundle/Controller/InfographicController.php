<?php

namespace Acme\InfographicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\Response;

class InfographicController extends Controller
{
	/**
	* @Route("/info")
	* @Template()
	*/

	public function infoAction()
	{

	    return $this->render('AcmeInfographicBundle:Info:info.html.twig', 
	        array(
	            'title' => 'Title of Infographic',
	            'slug' => 'slug-of-infographic',
	            'imgLogo' => '/uploads/logo_horizontal.png',
	            'staticImage' => '/uploads/social-media-2014-stats.jpg'	            
	        )
	    );
	}
	
	/**
	 * @Route("/send")
	 */
	public function sendAction()
	{
	    $html = file_get_contents('http://symfony-test.localhost/info');
	    return new Response($html);
	    
	}
}
