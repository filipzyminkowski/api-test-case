<?php

namespace GlobeGroup\ApiTests\Components;

use Exception;
use GlobeGroup\ApiTests\Exception\NoConfigurationException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\User\UserInterface;

trait SecurityTrait
{
    protected function logIn(string $email, string $role)
    {
        /** @var Container $container */
        $container = self::$kernel->getContainer();

        $manager = $container->get('doctrine.orm.entity_manager');
        try {
            $object = $container->get('test.oauth.user');
        } catch (Exception $e) {
            throw new NoConfigurationException('No client entity provided in services.yaml.');
        }

        $object->setEmail($email);
        $object->setPlainPassword('demoTest1');
        $encoder = $container->get('security.password_encoder');
        $object->setPassword($encoder->encodePassword($object, md5(uniqid(mt_rand(), true))));
        $object->setRoles([$role]);

        $manager->persist($object);
        $manager->flush();

        if ($object instanceof UserInterface) {
            try {
                $client = $container->get('test.oauth.client');
            } catch (Exception $e) {
                throw new NoConfigurationException('No client entity provided in services.yaml.');
            }

            $client->setSecret('secret');
            $client->setAllowedGrantTypes(['password', 'refresh_token']);
            $client->setRandomId('random_id');
            $client->setRedirectUris([]);
            $manager->persist($client);
            $manager->flush();

            try {
                $token = $container->get('test.oauth.token');
            } catch (Exception $e) {
                throw new NoConfigurationException('No token entity provided in services.yaml.');
            }

            $token->setUser($object);
            $token->setToken('FOR_TESTING_PURPOSES_ONLY');
            $token->setClient($client);
            $manager->persist($token);
            $manager->flush();
        }

        $this->authorization = ['HTTP_AUTHORIZATION' => 'Bearer '.$token->getToken()];
    }
}
