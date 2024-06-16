<?php

namespace Poposki\Identity\Application\Http\Web\Controller;

use Poposki\Identity\Application\Form\UserRegisterType;
use Poposki\Identity\Application\Messenger\Command\UserRegisterCommand;
use Poposki\Kernel\Application\Http\Web\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'identity_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('identity/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route(path: '/logout', name: 'identity_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/signup', name: 'identity_signup')]
    public function signUp(Request $request)
    {
        $form = $this->createForm(UserRegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handle(new UserRegisterCommand(
                    $form->get('email')->getData(),
                    $form->get('password')->getData()
                ));

                $this->addFlash('global_success', 'You have successfully registered. We\'ve sent you an email to activate your account.');

                return $this->redirectToRoute('home');
            } catch (\Throwable $exception) {
                $this->addFlash('global_error', $exception->getMessage());
            }
        }

        return $this->render('identity/security/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
