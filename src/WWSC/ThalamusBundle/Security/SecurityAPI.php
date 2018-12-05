<?php

namespace WWSC\ThalamusBundle\Security;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\OAuthServerBundle\Controller\TokenController;
use OAuth2\OAuth2;
use Doctrine\ORM\EntityManager;

/**
 * Class SecurityAPIController.
 */
class SecurityAPI extends  TokenController
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param OAuth2 $server
     */
    public function __construct(OAuth2 $server, EntityManager $entityManager )
    {
        parent::__construct($server);
        $this->em = $entityManager;
    }

    /**
     * Get access token.
     *
     * @ApiDoc(
     *  section="Security",
     *  output="FOS\OAuthServerBundle\Model\TokenInterface",
     *  requirements={
     *      { "name"="client_id", "dataType"="string", "description"="The client application's identifier"},
     *      { "name"="client_secret", "dataType"="string", "description"="The client application's secret"},
     *      { "name"="grant_type", "dataType"="string", "requirement"="refresh_token|authorization_code|password|client_credentials|custom", "description"="Grant type"},
     *  },
     *  parameters={
     *      { "name"="username", "dataType"="string", "required"=false, "description"="User name (for `password` grant type)"},
     *      { "name"="password", "dataType"="string", "required"=false, "description"="User password (for `password` grant type)"},
     *      { "name"="refresh_token", "dataType"="string", "required"=false, "description"="The authorization code received by the authorization server(for `refresh_token` grant type`"},
     *  }
     * )
     */
    public function tokenAction(Request $request)
    {
        $result = parent::tokenAction($request);

        return $result;
    }
}
