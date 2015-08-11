<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadData
 *
 * @author Licya
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\News;
use AppBundle\Entity\Partner;
use AppBundle\Entity\Proposition;
use AppBundle\Entity\DailyMenu;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadData implements FixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {

            //Propositon Entity
            $prop = new Proposition();
            $prop->setTitle($faker->word);           
            $manager->persist($prop);

            //Category Entity
            $cat = new Category();
            $cat->setName($faker->word);
            $cat->setDescription($faker->sentence());
            $cat->setSort($i);
            $cat->setEnable(true);
            $manager->persist($cat);

            //Product Entity
            $prod = new Product();
            $prod->setName($faker->word);
            $prod->setDescription($faker->sentence());
            $prod->setMainPrice($faker->randomFloat(10, 100));
            $prod->setSecondPrice($faker->randomFloat(10, 100));
            $prod->setEnable(true);
            $prod->setCategory($cat);
            $prod->setProposition($prop);
            $manager->persist($prod);

            //News Entity
            $new = new News();
            $new->setTitle($faker->word);
            $new->setSubtitle($faker->word);
            $new->setDescription($faker->sentence());
            $new->setEnable(true);
            $new->setSort($i);
            $manager->persist($new);

            //Partner Entity
            $part = new Partner();
            $part->setName($faker->word);
            $part->setWebsiteLink($faker->email);
            $part->setEnable(true);
            $part->setSort($i);
            $manager->persist($part);

            //DailyMenu Entity
            $dail = new DailyMenu();
            $dail->setTitle($faker->word);
            $dail->setPrice($faker->randomFloat(10, 100));
            $dail->setDate($faker->dateTime);
            $dail->setEnable(true);
            $dail->setPropositions($prop);
            $manager->persist($dail);
        }
        $manager->flush();
    }

}
