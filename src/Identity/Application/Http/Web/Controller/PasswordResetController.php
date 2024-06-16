<?php

namespace Poposki\Identity\Application\Http\Web\Controller;

use Poposki\Identity\Application\Form\PasswordForgotType;
use Poposki\Identity\Application\Form\PasswordResetType;
use Poposki\Identity\Application\Messenger\Command\PasswordForgotCommand;
use Poposki\Identity\Application\Messenger\Command\PasswordResetCommand;
use Poposki\Kernel\Application\Http\Web\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

class PasswordResetController extends AbstractController
{
    #[Route(path: '/password/forgot', name: 'identity_password_forgot')]
    public function passwordForgot(Request $request): RedirectResponse|Response
    {
        $form = $this->createForm(PasswordForgotType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handle(new PasswordForgotCommand(
                    $form->get('email')->getData()
                ));

                $this->addFlash('global_success', 'Please follow the instructions in the email to reset your password.');

                return $this->redirectToRoute('identity_password_forgot');
            } catch (\Throwable $exception) {
                $this->addFlash('global_error', 'Oh wow, well... seems like something went wrong, maybe give it another try later.');
            }
        }

        return $this->render('identity/security/password_forgot.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/password/reset/{token}', name: 'identity_password_reset')]
    public function passwordReset(Request $request): RedirectResponse|Response
    {
        $form = $this->createForm(PasswordResetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->handle(new PasswordResetCommand(
                    $form->get('password')->getData(),
                    $request->get('token')
                ));

                // flash a success message

                return $this->redirectToRoute('home');
            } catch (ResetPasswordExceptionInterface $exception) {
                $this->addFlash('global_error', sprintf(
                    '%s - %s',
                    ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE,
                    $exception->getReason()
                ));

                return $this->redirectToRoute('identity_password_forgot');
            } catch (\Throwable $exception) {
                $this->addFlash('global_error', 'Oh wow, well... seems like something went wrong, maybe give it another try later.');

                return $this->redirectToRoute('identity_password_forgot');
            }
        }

        return $this->render('identity/security/password_reset.html.twig', [
            'form' => $form,
        ]);
    }
}
