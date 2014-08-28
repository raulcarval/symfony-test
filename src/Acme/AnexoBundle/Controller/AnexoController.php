<?php

namespace Acme\AnexoBundle\Controller;

use Acme\AnexoBundle\Entity\Anexo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AnexoController extends Controller
{
    /**
     * @Route("/anexo/", name="anexo_file")
     * @Template()
     */
    public function uploadAction(Request $request)
    {

        $anexo = new Anexo();
        $form = $this->createFormBuilder($anexo)->add('name')
                ->add('file', 'file', array('attr' => array('multiple' => 'multiple')))->getForm();

        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {
                $data  = $request->file->get($form->getName());
                
                foreach ($data['files'] as $file) {
                    $anexo->upload();
                }
                
                $em = $this->getDoctrine()->getManager();
                $anexo->upload();
                $em->persist($anexo);
                $em->flush();

                return $this->render('AcmeAnexoBundle:Default:index.html.twig');
            }
        }
        return array('upload_form' => $form->createView());
    }
}
