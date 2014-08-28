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
	* @Route("/infographic", name="infographic")
	* @Template()
	*/

	public function infographicAction()
	{

	    return $this->render('AcmeInfographicBundle:Infographic:info.html.twig', 
	        array(
	            'title' => 'Title of Infographic',
	            'slug' => 'slug-of-infographic',
	            'imgLogo' => '/uploads/logo_horizontal.png',
	            'staticImage' => '/uploads/social-media-2014-stats.jpg'	            
	        )
	    );
	}
	
	/**
	 * @Route("/send", name="send_infographic")
	 * 
	 * @return Response
	 */
	public function sendAction()
	{
	    $slug = array('slug' => 'slug-of-infographic');

	    $html = file_get_contents('http://symfony-test.localhost/infographic');
	    return new Response($html, 200, array(
	       'Content-Type' => 'application/force-download',
           'Content-Disposition' => 'attachment; filename="' .$slug['slug'].'.html')
	    );
	}
}
