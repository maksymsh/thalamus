<?php

namespace WWSC\ThalamusBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use WWSC\ThalamusBundle\WWSCThalamusBundle;

class FOSUBUserProvider extends BaseClass
{
    /**
     * {@inheritdoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set'.ucfirst($service);
        $setter_id = 'setGoogleID';
        $setter_token = $setter.'AccessToken';

        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array('googleID' => $username) || null !== $previousUser = $this->userManager->findUserByEmail($response->getEmail()))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    public function loadUserByAuthCode($data)
    {
        return $this->userManager->findUserBy($data);
    }

    public function loadUserByEmail($email)
    {
        return $this->userManager->findUserByEmail($email);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $idToken = $response->getUsername();
        $user = $this->userManager->findUserByEmail($response->getEmail());
        if(!$user){
            $user = $this->userManager->findUserBy(array('googleID' => $idToken));
            //when the user is registrating
            if (null === $user) {
                // create new user here
                $aInfoName = explode(' ' ,$response->getRealName());
                $aInfoEmail = explode('@' ,$response->getEmail());
                $service = $response->getResourceOwner()->getName();
                $setter = 'set'.ucfirst($service);
                $setter_id = $setter.'ID';
                $setter_token = $setter.'AccessToken';
                // create new user here
                $user = $this->userManager->createUser();
                $user->$setter_id($idToken);
                $user->$setter_token($response->getAccessToken());
                $user->setUsername($response->getEmail());
                $user->setFirstName($aInfoName[0]);
                $user->setLastName($aInfoName[1]);
                $user->setEmail($response->getEmail());
                $user->setPassword(md5($idToken));
                $user->setEnabled(true);
                $this->userManager->updateUser($user);

                $em = WWSCThalamusBundle::getContainer()->get('doctrine')->getManager();
                $userProfile = new \WWSC\ThalamusBundle\Entity\UserProfile();
                $userProfile->setUser($user);
                $em->persist($userProfile);
                $em->flush();

                return $user;
            }

            //if user exists - go with the HWIOAuth way
            $user = parent::loadUserByOAuthUserResponse($response);
        }
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($serviceName).'AccessToken';

        //update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }
}