<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $categoryNames = [
            'Test' => 'Catégorie Test',
            'PixelArt' => 'Catégorie PixelArt',
            'Développement' => 'Catégorie Développement',
            'Dessin' => 'Catégorie dessin',
        ];

        foreach ($categoryNames as $categoryName => $desc) {
            $category = new Category();
            $category
                ->setName($categoryName)
                ->setChapo($desc)
                ->setColorBackground('green')
                ->setColorText('green')
                ->setIcon('ph-folder');
            $manager->persist($category);
            $manager->flush();

            $categories[] = $category;
        }

        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle('Titre ' . $i);
            $article->setChapo('Description ' . $i);
            $article->setContent('Contenu ' . $i);
            $article->setCategory($faker->randomElement($categories));
            $article->setCreatedAt(new \DateTimeImmutable());
            $article->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($article);
            $manager->flush();
        }

        $user = new User();
        $user
            ->setIsVerified(1)
            ->setEmail("matheo.zeller@gmail.com")
            ->setPassword(password_hash("Playmate12\$p", PASSWORD_BCRYPT))
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);
        $manager->flush();
    }
}
