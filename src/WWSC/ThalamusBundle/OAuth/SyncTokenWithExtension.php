<?php

namespace WWSC\ThalamusBundle\OAuth;

use FOS\OAuthServerBundle\Storage\GrantExtensionInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use OAuth2\Model\IOAuth2Client;

/**
 * Play at bingo to get an access_token: May the luck be with you!
 */
class SyncTokenWithExtension implements GrantExtensionInterface
{
    protected $userProvider = null;

    public function __construct(OAuthAwareUserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /*
    * {@inheritdoc}
    */
    public function checkGrantExtension(IOAuth2Client $client, array $inputData, array $authHeaders)
    {
        if (!isset($inputData['username']) || !isset($inputData['password'])) {
            return false;
        }
        $email = $inputData['username'];
        if (!$user = $this->userProvider->loadUserByEmail($email)) {
            return false;
        }
        if($inputData['password'] != $user->getPassword()){
            return false;
        }

        return ['data' => $user];
    }
}