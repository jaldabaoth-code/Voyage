<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserFixtures extends Fixture
{
    private const USERS_PASSWORDS = [
        'user' => [
            'password' => '123456789',
            'role' => 'ROLE_USER',
        ],
        'admin' => [
            'password' => 'admin123456789',
            'role' => 'ROLE_ADMIN',
        ],
    ];


    private UserPasswordEncoderInterface $passwordEncoder;
    private HttpClientInterface $client;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, HttpClientInterface $client)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->client = $client;
    }

    public function load(ObjectManager $manager)
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setUserusername('user');
        $contributor->setEmail('user@user.com');
        $contributor->setRoles(['ROLE_USER']);
        $contributor->setPassword($this->passwordEncoder->encodePassword(
            $contributor,
            '123456789'
        ));

        $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setUserusername('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin123456789'
        ));

        $manager->persist($admin);

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}
