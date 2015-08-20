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
    /** @var \Faker\Generator */
    private $faker;
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create('fr_FR');
        
        for ($i = 0; $i < 10; $i++) {
            //News Entity
            $new = new News();
            $new->setTitle($this->faker->word);
            $new->setSubtitle($this->faker->word);
            $new->setDescription($this->faker->sentence());
            $new->setEnable(true);
            $new->setSort($i);
            $manager->persist($new);

            //Partner Entity
            $part = new Partner();
            $part->setName($this->faker->word);
            $part->setWebsiteLink($this->faker->email);
            $part->setEnable(true);
            $part->setSort($i);
            $manager->persist($part);
        }
        
        for ($i = 0; $i < rand(2, 4); $i++) {
            //DailyMenu Entity
            $dail = new DailyMenu();
            $dail->setTitle($this->faker->word);
            $dail->setPrice($this->faker->randomFloat(10, 100));
            $dail->setDate($this->faker->dateTime);
            $dail->setEnable(true);
            $manager->persist($dail);
            
            for ($j = 0; $j < rand(2, 4); $j++) {
                //Propositon Entity
                $prop = new Proposition();
                $prop->setTitle($this->faker->word);           
                $prop->setDailyMenu($dail);
                $manager->persist($prop);
                
                //Product Entity
                $prod = $this->createProduct();
                $prod->setProposition($prop);
                $manager->persist($prod);
            }
        }
        
        for ($i = 0; $i < rand(2, 4); $i++) {
            //Category Entity
            $cat = new Category();
            $cat->setName($this->faker->word);
            $cat->setDescription($this->faker->sentence());
            $cat->setSort($i);
            $cat->setEnable(true);
            $manager->persist($cat);

            //Product Entity
            $prod = $this->createProduct();
            $prod->setCategory($cat);
            $manager->persist($prod);
        }
        
        $manager->flush();
    }

    /**
     * @return Product
     */
    private function createProduct()
    {
        $prod = new Product();
        $prod->setName($this->faker->word);
        $prod->setDescription($this->faker->sentence());
        $prod->setMainPrice($this->faker->randomFloat(10, 100));
        $prod->setSecondPrice($this->faker->randomFloat(10, 100));
        $prod->setEnable(true);
        
        return $prod;
    }
}
