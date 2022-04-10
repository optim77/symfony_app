<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\UserFormType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    private $emi;
    function __constructor(EntityManagerInterface $emi){
        $this->emi = $emi;
    }

    /*
     * Return start page with categories
     * TODO add random item display on main vieOw
     */
    #[Route("/", name: "main")]
    public function index(EntityManagerInterface $registry): Response
    {
        $categories = $registry->getRepository(Category::class)->findAll();
        $new_products = $registry->getRepository(Product::class)->findBy([], ['createdAt' => 'DESC'], 10);
        shuffle($new_products);
        return $this->render('main.html.twig', [
            'categories' => $categories,
            'new_products' => $new_products
        ]);
    }



    #[Route('/contact', name: 'contact')]
    public function contact() : Response{
        return $this->render('contact.html.twig');
    }
}
