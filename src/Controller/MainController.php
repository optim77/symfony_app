<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Form\UserFormType;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $emi;
    function __constructor(EntityManagerInterface $emi){
        $this->emi = $emi;
    }

    #[Route("/", name: "main")]
    public function index(): Response
    {
        return $this->render('main.html.twig');
    }

    /**
     * @param int $id
     * @Route ("/category/{id}", name="category")
     */
    public function category( int $id): Response{
        return $this->render('category.html.twig');
    }

    /**
     * @param int $id
     * @Route ("/product/{id}", name="product")
     */
    public function product(int $id): Response{
        return $this->render('product.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function login(): Response{
        $fill = new User();
        $form = $this->createForm(User::class, $fill);
        return $this->render('login.html.twig', ['form' => $form]);
    }

    #[Route('/sign_up', name: 'sign_up')]
    public function sign_up(): Response{
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        return $this->render('sing_up.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact() : Response{
        return $this->render('contact.html.twig');
    }
}
