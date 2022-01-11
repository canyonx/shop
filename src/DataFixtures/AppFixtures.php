<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use DateTime;
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

        // Créer des catégories
        for ($c = 0; $c < 2; $c++) {
            $category = new Category();

            $category->setName("Catégorie $c")
                ->setSlug(strtolower($this->slugger->slug($category->getName())));

            $manager->persist($category);

            // Créer des produits
            for ($p = 0; $p < 6; $p++) {
                $product = new Product();

                $product->setName("Produit $c$p")
                    ->setPrice(mt_rand(0, 400))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setDescription(file_get_contents('http://loripsum.net/api/1/short'))
                    ->setCreatedAt(new DateTime())
                    ->setStock(true)
                    ->setShowcase(true)
                    ->addCategory($category);

                $manager->persist($product);
            }
        }



        $manager->flush();
    }
}
