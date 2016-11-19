<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Passagem;
use AppBundle\Form\PassagemType;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Passagem controller.
 *
 * @Route("/admin/passagem")
 */
class PassagemController extends Controller
{
    /**
     * Lists all Passagem entities.
     *
     * @Route("/", name="admin_passagem_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $passagems = $em->getRepository('AppBundle:Passagem')->findAll();

        return $this->render('passagem/index.html.twig', array(
            'passagems' => $passagems,
        ));
    }

    /**
     * Creates a new Passagem entity.
     *
     * @Route("/new", name="admin_passagem_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $passagem = new Passagem();
        $form = $this->createForm('AppBundle\Form\PassagemType', $passagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($passagem);
            $em->flush();

            return $this->redirectToRoute('admin_passagem_show', array('id' => $passagem->getId()));
        }

        return $this->render('passagem/new.html.twig', array(
            'passagem' => $passagem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Passagem entity.
     *
     * @Route("/{id}", name="admin_passagem_show")
     * @Method("GET")
     */
    public function showAction(Passagem $passagem)
    {
        $deleteForm = $this->createDeleteForm($passagem);

        return $this->render('passagem/show.html.twig', array(
            'passagem' => $passagem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Passagem entity.
     *
     * @Route("/{id}/edit", name="admin_passagem_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Passagem $passagem)
    {
        if ($passagem->getImagem()) {
            $passagem->setImagem(
                new File($this->getParameter('imagem_directory').'/'.$passagem->getImagem())
            );
        }

        $deleteForm = $this->createDeleteForm($passagem);
        $editForm = $this->createForm('AppBundle\Form\PassagemType', $passagem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $passagem->getImagem();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('imagem_directory'),
                $fileName
            );

            $passagem->setImagem($fileName);
            $em->persist($passagem);
            $em->flush();

            return $this->redirectToRoute('admin_passagem_edit', array('id' => $passagem->getId()));
        }

        return $this->render('passagem/edit.html.twig', array(
            'passagem' => $passagem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Passagem entity.
     *
     * @Route("/{id}", name="admin_passagem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Passagem $passagem)
    {
        $form = $this->createDeleteForm($passagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($passagem);
            $em->flush();
        }

        return $this->redirectToRoute('admin_passagem_index');
    }

    /**
     * Creates a form to delete a Passagem entity.
     *
     * @param Passagem $passagem The Passagem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Passagem $passagem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_passagem_delete', array('id' => $passagem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
