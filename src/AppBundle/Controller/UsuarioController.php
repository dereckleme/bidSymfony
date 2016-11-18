<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UsuarioDadosCadastro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuario", name="AppBundleUsuarioHome")
     */
    public function indexAction()
    {
        // não existe dados de cadastro
        if (!$this->getUser()->getDadosCadastro()) {
            return $this->redirect($this->generateUrl('fos_user_registration_confirmed'));
        }

        return $this->render('AppBundle:Usuario:index.html.twig', array(
            'user' => $this->getUser()
        ));
    }

    /**
     * @Route("/usuario/alterarSenha", name="AppBundleUsuarioAlterarSenha")
     */
    public function mudarSenhaAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('AppBundle:Usuario:alterarSenha.html.twig', array(
            'user' => $this->getUser(),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/usuario/editar_cadastro", name="AppBundleUsuarioEditar")
     */
    public function editarAction()
    {
        return $this->render('AppBundle:Usuario:editar.html.twig', array(
        ));
    }

    /**
     * @Route("/usuario/salvar_dados_usuario", name="AppBundleUsuarioSalvarDados")
     * @Template()
     */
    public function saveDadosCadastroAction(Request $request)
    {
        if (!$this->getUser()->getDadosCadastro()) {
            $cadastro = new UsuarioDadosCadastro();
        } else {
            $cadastro = $this->getUser()->getDadosCadastro();
        }

        $form = $this->createFormBuilder($cadastro)
            ->add('endereco', TextType::class)
            ->add('numero', IntegerType::class)
            ->add('estado', EntityType::class, array(
                // query choices from this entity
                'class' => 'AppBundle\Entity\Estado',
                'choice_label' => 'nome'
            ))
            ->add('cpf', TextType::class,array(
                'attr' => array('id' => 'cpf')
            ))
            ->add('cep', TextType::class, array(
                'attr' => array('id' => 'cep')
            ))
            ->add('complemento', TextType::class)
            ->add('bairro', TextType::class)
            ->add('dataNascimento', TextType::class, array(
                'attr' => array('placeholder' => 'dd/mm/yyyy', 'id' => 'dataNascimento')
            ))
            ->add('telefoneRes', TextType::class,array(
                'attr' => array('id' => 'telefoneRes')
            ))
            ->add('telefoneCel', TextType::class,array(
                'attr' => array('id' => 'telefoneCel')
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'green darken-3 btn')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cadastro);
            $em->flush();

            $usuario = $em->getReference("AppBundle\Entity\Usuario", $this->getUser()->getId());
            $usuario->setDadosCadastro($cadastro);

            $em->persist($usuario);
            $em->flush();

            return $this->redirect($this->generateUrl('AppBundleUsuarioHome'));
        }

        return array(
            'form' => $form->createView(),
            'user' => $this->getUser()
        );
    }

    /**
     * @Route("/usuario/comprar_lances", name="AppBundleUsuarioComprarLances")
     */
    public function compraLancesAction()
    {
        return $this->render('AppBundle:Usuario:comprar_lances.html.twig', array(
            // ...
        ));
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }
}
