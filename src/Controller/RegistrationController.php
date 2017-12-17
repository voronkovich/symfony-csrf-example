<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/")
     */
    public function registerAction(Request $request, CsrfTokenManagerInterface $tokenManager): Response
    {
        /** @var CsrfToken $token */
        $token = $tokenManager->getToken('registration');

        if ('POST' === $request->getMethod()) {
            $_token = $request->request->get('_token');

            if ($tokenManager->isTokenValid(new CsrfToken('registration', $_token))) {
                $message = sprintf('User "%s" has been registered successfully.', $request->request->get('username'));
            } else {
                $message = 'CSRF token is not valid.';
            }
        }

        return $this->render('registration/register.html.twig', [
            'csrf_token' => $token,
            'message' => $message ?? '',
        ]);
    }
}
