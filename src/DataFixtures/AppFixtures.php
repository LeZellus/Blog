<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Attachment;
use App\Entity\Category;
use App\Entity\Log;
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

        for ($ii = 0; $ii < 20; $ii++) {
            $attachment = new Attachment();
            $attachment->setImage('toutou.jpg');
            $manager->persist($attachment);

            $attachments[] = $attachment;
        }
        $manager->flush();

        foreach ($categoryNames as $categoryName => $desc) {
            $category = new Category();
            $category
                ->setName($categoryName)
                ->setChapo($desc)
                ->setColorBackground('bg-green-200')
                ->setColorText('text-green-600')
                ->setIcon('ph-folder');
            $manager->persist($category);

            $categories[] = $category;
        }
        $manager->flush();

        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle('Un titre plutôt long pour décrire l\'article ' . $i);
            $article->addAttachment($faker->randomElement($attachments));
            $article->setChapo('Voici une petite description, elle n\'est pas très grande  ' . $i);
            $article->setContent('Voici un petit contenu, il n\'est pas très grand mais il fera l\'affaire pour se rendre compte ' . $i);
            $article->setCategory($faker->randomElement($categories));
            $article->setIsPublish($faker->numberBetween(0, 1));
            $manager->persist($article);
        }
        $manager->flush();

        for ($i = 0; $i < 20; $i++) {
            $log = new Log();
            $log->setContent('Voici un log, le numéro ' . $i);
            $log->setVersion($i);
            $manager->persist($log);
        }
        $manager->flush();

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
