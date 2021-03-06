<?php

namespace Acme\SearchBundle\Controller;

use Symfony\Component\Validator\Constraints\Count;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Acme\SearchBundle\Filter\PostFilter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\SearchBundle\Entity\Post;
use Acme\SearchBundle\Form\PostType;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{

    /**
     * Lists all Post entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeSearchBundle:Post')->findAll();

        return $this->render('AcmeSearchBundle:Post:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Post entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Post();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('post_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmeSearchBundle:Post:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Post entity.
    *
    * @param Post $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Post $entity)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Post entity.
     *
     */
    public function newAction()
    {
        $entity = new Post();
        $form   = $this->createCreateForm($entity);

        return $this->render('AcmeSearchBundle:Post:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSearchBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeSearchBundle:Post:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSearchBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeSearchBundle:Post:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Post entity.
    *
    * @param Post $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Post $entity)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Post entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSearchBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('post_edit', array('id' => $id)));
        }

        return $this->render('AcmeSearchBundle:Post:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Post entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeSearchBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('post'));
    }

    /**
     * Creates a form to delete a Post entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function searchAction($page = 1, $max = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $offset = ($page -1) * $max;
        $entity = $em->getRepository('AcmeSearchBundle:Post')
            ->createQueryBuilder('p')
            ->setFirstResult($offset)
            ->setMaxResults($max);
        
        //$form = $this->get('form.factory')->create(new PostFilter());
        
        
//         if ($this->get('request')->query->has('submit-filter')) {
            
//             $form->bind($this->get('request'));
            
//             $filterBuilder = $this->get('doctrine.orm.entity_manager')
//                 ->getRepository('AcmeSearchBundle:Post')
//                 ->createQueryBuilder('p');
//                 //->setFirstResult(0)
//                 //->setMaxResults($max);
            
//             $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
    
            
//             $posts = $filterBuilder->getQuery()->getResult();
            
        
//         }

        $posts = $entity->getQuery()->getResult();
        
        return $this->render('AcmeSearchBundle:Post:search.html.twig', array(
                //'form' => $form->createView(), 
                'posts' => $posts,
               
        ));
    }
    
    public function paginationAction($page = 1, $max = 5)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('AcmeSearchBundle:Post')
            ->createQueryBuilder('p');
           // ->setMaxResults($max);
        
        
        
        $posts = $entity->getQuery()->getResult();
        
        $qtdPaginas = (ceil(count($posts)/$max) > 0)? ceil(count($posts)/$max) : 1;
        
        $ultima = $qtdPaginas;
        $active = $page;
        if ($qtdPaginas > 5) {
            $inicial = (($active - 2) <= 0)? 1 : ($active - 2);
            $final = (($active + 2) >= $ultima)? $ultima : ($active + 2);
            ($active < 4)? $final = 5 : null;
            ($active > ($ultima-3))? $inicial = $ultima-4 : null;
        } else {
            $inicial = 1;
            $final = $qtdPaginas;
        }
        
        return $this->render('AcmeSearchBundle:Post:pagination.html.twig', array(
                //'form' => $form->createView(),
                'posts' => $posts,
                'ultima' => $ultima,
                'active' => $active,
                'inicial' => $inicial,
                'final' => $final
        ));
        
    }
}
