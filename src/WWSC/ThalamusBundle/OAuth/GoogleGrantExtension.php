<?php

namespace WWSC\ThalamusBundle\OAuth;

use FOS\OAuthServerBundle\Storage\GrantExtensionInterface;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use OAuth2\Model\IOAuth2Client;

/**
 * Play at bingo to get an access_token: May the luck be with you!
 */
class GoogleGrantExtension implements GrantExtensionInterface
{
    protected $userProvider = null;
    protected $resourceOwner = null;

    public function __construct(OAuthAwareUserProviderInterface $userProvider, ResourceOwnerInterface $resourceOwner)
    {
        $this->userProvider = $userProvider;
        $this->resourceOwner = $resourceOwner;
    }

    /*
    * {@inheritdoc}
    */
    public function checkGrantExtension(IOAuth2Client $client, array $inputData, array $authHeaders)
    {
        if (!isset($inputData['code'])) {
            return false;
        }
        $data = [
            'googleID' => $inputData['code'],
            'username' => $inputData['username'],
        ];

        if (!$user = $this->userProvider->loadUserByAuthCode($data)) {
            return false;
        }

        return ['data' => $user];
    }
}