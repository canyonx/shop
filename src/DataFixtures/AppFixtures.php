<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{

    protected $slugger;
    protected $encoder;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $encoder)
    {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {

        // Créer un administrateur
        $admin = new User();

        $hash = $this->encoder->hashPassword($admin, "admin");

        $admin->setName('admin')
            ->setEmail('admin@shop.fr')
            ->setPassword($hash)
            ->setRoles(["ROLE_ADMIN"])
            ->setAvatar('admin.jpg');

        $manager->persist($admin);


        $manager->flush();
    }
}
