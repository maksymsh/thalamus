<?php

namespace WWSC\ThalamusBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    protected $router;
    protected $security;
    protected $userManager;
    protected $service_container;

    public function __construct(RouterInterface $router, SecurityContext $security, $userManager, $service_container)
    {
        $this->router = $router;
        $this->security = $security;
        $this->userManager = $userManager;
        $this->service_container = $service_container;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        if ($request->isXmlHttpRequest()) {
            $result = array('success' => true, 'urlCreateNewAccount' => $this->router->generate('wwsc_thalamus_account_new'));
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        if($this->security->getToken()->getUser()->getLastLoggedAccount()){
            $language = $this->security->getToken()->getUser()->getLanguage();
            if('de' == $language || 'de_AT' == $language){
                $request->getSession()->set('_localeThalamus', 'de');
            }
            $oAccount = $this->service_container->get('doctrine')->getRepository('WWSCThalamusBundle:Account')->find($this->security->getToken()->getUser()->getLastLoggedAccount());
            $request->getSession()->set('account', (object) array('slug' => $oAccount->getSlug(), 'name' => $oAccount->getName(), 'id' => $oAccount->getId()));
            if(!$oAccount->getChekUserForAccount($this->security->getToken()->getUser())){
                $request->getSession()->getFlashBag()->add('notice', 'Bad credentials');
                $request->getSession()->getFlashBag()->add('status', 'error');
                $this->security->setToken(NULL);
                $url = $this->router->generate('fos_user_security_login');

                return new RedirectResponse($url);
            }

            $userManager = $this->service_container->get('fos_user.user_manager');
            $role = $this->security->getToken()->getUser()->getCompany()->getRoles();
            $this->security->getToken()->getUser()->setRoles(array($role));
            $userManager->updateUser($this->security->getToken()->getUser());
            $cookie = [];
            if ($apiAccessToken = $this->service_container->get('service.api')->getRestTokenAfterAuthorization($this->security->getToken()->getUser())) {
                $cookie = new Cookie('access_token', $apiAccessToken, time() + 86400, '/', null, false, false);
            }
            if($request->getSession()->get('ajaxLogin')){
                $response = new RedirectResponse($this->router->generate('wwsc_thalamus_account_new'));
                $response->headers->setCookie($cookie);

                return $response;
            }
            if($request->getSession()->get('_security.main.target_path')){
                $response = new RedirectResponse('/');
                $response->headers->setCookie($cookie);

                return $response;
            }else{
                if ('ROLE_FREELANCER' == $role) {
                    $response = new RedirectResponse($this->router->generate('wwsc_thalamus_account_tasks'));
                    $response->headers->setCookie($cookie);

                    return $response;
                }
                $response = new RedirectResponse($this->router->generate('wwsc_thalamus_account_dashboard'));
                $response->headers->setCookie($cookie);

                return $response;
            }
        }

        return new RedirectResponse($this->router->generate('wwsc_thalamus_account_new'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        if ($request->isXmlHttpRequest()) {
            $result = array('success' => false, 'message' => $exception->getMessage());
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }else{
            $request->getSession()->getFlashBag()->add('notice', $exception->getMessage());
            $request->getSession()->getFlashBag()->add('status', 'error');
            $url = $this->router->generate('fos_user_security_login');

            return new RedirectResponse($url);
        }

        return new Response();
    }
}
