<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('Tesla 3');
        $product->setPrice(35000);
        $product->setDescriptions('lorem ipsum');
        $product->setImage('https://tinyurl.com/y96m4keh');
        $product->setStock(20);
        //$product->setCategory($this->getReference('category'));
        $manager->persist($product);
        $manager->flush();
        $this->addReference('category', $product);
    }
}
