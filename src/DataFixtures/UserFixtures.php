<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private HttpClientInterface $client;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, HttpClientInterface $client)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->client = $client;
    }

    public function load(ObjectManager $manager)
    {
        // Creation of an user type “contributor” (= author)
        $contributor = new User();
        $contributor->setUsername('user');
        $contributor->setEmail('user@user.com');
        $contributor->setRoles(['ROLE_USER']);
        $contributor->setPassword($this->passwordEncoder->encodePassword($contributor, '123456789'));
        $manager->persist($contributor);
        // Creation of an user tupe “administrator”
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'admin123456789'));
        $manager->persist($admin);
        // Backup of the 2 new users
        $manager->flush();
    }
}
