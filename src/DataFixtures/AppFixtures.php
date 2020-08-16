<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Fruit;
use App\Entity\Image;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        $category1 = new Category();
        $category1->setTitle("pommiers")
            ->setDescription("<p>" . join('</p><p>', $faker->paragraphs(5)) . "</p>")
            ->setImage("apples-01.jpg");

        $manager->persist($category1);

        $category2 = new Category();
        $category2->setTitle("poiriers")
            ->setDescription("<p>" . join('</p><p>', $faker->paragraphs(5)) . "</p>")
            ->setImage("pears-02.jpg");

        $manager->persist($category2);



        $categories = [$category1, $category2];


        foreach ($categories as $cat) {
            for ($i = 1; $i <= 20; $i++) {
                $fruit = new Fruit();

                $name = $faker->sentence(3);
                $introduction = $faker->paragraph(2);
                // appliquer ensuite {{ var|raw }} dans .html.twig ↴
                $content = "<p>" . join('</p><p>', $faker->paragraphs(5)) . "</p>";
                $coverImage = $faker->imageUrl(640, 480);

                $fruit->setName($name)
                    ->setIntroduction($introduction)
                    ->setContent($content)
                    ->setCoverImage($coverImage)
                    ->setPrice(mt_rand(1, 3))
                    ->setCategory($cat);


                for ($j = 1; $j <= mt_rand(2, 3); $j++) {
                    $image = new Image();

                    $image->setUrl($faker->imageUrl(640, 480))
                        ->setCaption($faker->sentence(3))
                        ->setFruit($fruit);

                    $manager->persist($image);
                }

                $manager->persist($fruit);
            }
        }


        $manager->flush();
    }
}
