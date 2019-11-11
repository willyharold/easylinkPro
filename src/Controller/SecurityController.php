<?php
/**
 * Created by PhpStorm.
 * User: sikombea
 * Date: 22/05/2019
 * Time: 11:53
 */

namespace App\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Routing\Annotation\Route;


class SecurityController extends BaseController
{

    private $tokenManager;
    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * @Route("/artisan/login", name="fos_user_security_artisan_login")
     */
    public function login(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }
        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);
        $csrfToken = $this->tokenManager ? $this->tokenManager->getToken('authenticate')->getValue() : null;
        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'request' =>$request
        ));
    }

    protected function renderLogin(array $data)
    {
        //$requestAttributes = $this->container->get('request_stack')->attributes;
        $requestAttributes =$data["request"]->attributes->get('_route');
        if ($requestAttributes == 'fos_user_security_artisan_login') {
            return $this->render('@FOSUser/Security/login_artisan.html.twig', $data);
        } else {
            return $this->render('@FOSUser/Security/login_artisan.html.twig', $data);
        }

    }

     /**
     * @Route("/admin/login", name="fos_user_security_admin_login")
     */
    public function loginAdmin(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }
        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);
        $csrfToken = $this->tokenManager ? $this->tokenManager->getToken('authenticate')->getValue() : null;
        return $this->renderLogin2(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'request' =>$request
        ));
    }

    protected function renderLogin2(array $data)
    {
        //$requestAttributes = $this->container->get('request_stack')->attributes;
        $requestAttributes =$data["request"]->attributes->get('_route');
        if ($requestAttributes == 'fos_user_security_admin_login') {
            return $this->render('@FOSUser/Security/login_admin.html.twig', $data);
        } else {
            return $this->render('@FOSUser/Security/login_admin.html.twig', $data);
        }

    }

}