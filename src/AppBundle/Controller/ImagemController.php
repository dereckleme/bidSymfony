<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Imagem;
use AppBundle\Form\ImagemType;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Imagem controller.
 *
 * @Route("/admin/imagem")
 */
class ImagemController extends Controller
{
    /**
     * Lists all Imagem entities.
     *
     * @Route("/", name="admin_imagem_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imagems = $em->getRepository('AppBundle:Imagem')->findAll();

        return $this->render('imagem/index.html.twig', array(
            'imagems' => $imagems,
        ));
    }

    /**
     * Creates a new Imagem entity.
     *
     * @Route("/new", name="admin_imagem_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imagem = new Imagem();
        $form = $this->createForm('AppBundle\Form\ImagemType', $imagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file = $imagem->getSrc();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('imagem_directory'),
                $fileName
            );

            $imagem->setSrc($fileName);

            $em->persist($imagem);
            $em->flush();

            return $this->redirectToRoute('admin_imagem_show', array('id' => $imagem->getId()));
        }

        return $this->render('imagem/new.html.twig', array(
            'imagem' => $imagem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Imagem entity.
     *
     * @Route("/{id}", name="admin_imagem_show")
     * @Method("GET")
     */
    public function showAction(Imagem $imagem)
    {
        $deleteForm = $this->createDeleteForm($imagem);

        return $this->render('imagem/show.html.twig', array(
            'imagem' => $imagem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Imagem entity.
     *
     * @Route("/{id}/edit", name="admin_imagem_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Imagem $imagem)
    {
        if ($imagem->getSrc()) {
            $imagem->getSrc(
                new File($this->getParameter('imagem_directory').'/'.$imagem->getSrc())
            );
        }

        $deleteForm = $this->createDeleteForm($imagem);
        $editForm = $this->createForm('AppBundle\Form\ImagemType', $imagem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $file = $imagem->getSrc();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('imagem_directory'),
                $fileName
            );

            $imagem->setSrc($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($imagem);
            $em->flush();

            return $this->redirectToRoute('admin_imagem_edit', array('id' => $imagem->getId()));
        }

        return $this->render('imagem/edit.html.twig', array(
            'imagem' => $imagem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Imagem entity.
     *
     * @Route("/{id}", name="admin_imagem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Imagem $imagem)
    {
        $form = $this->createDeleteForm($imagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imagem);
            $em->flush();
        }

        return $this->redirectToRoute('admin_imagem_index');
    }

    /**
     * Creates a form to delete a Imagem entity.
     *
     * @param Imagem $imagem The Imagem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Imagem $imagem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_imagem_delete', array('id' => $imagem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
