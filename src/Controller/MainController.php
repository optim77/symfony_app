<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    /*
     * This class display sign up view and registers new users to database
     * TODO make hash passwords 
     */
    #[Route('/sign_up', name: 'sign_up')]
    public function sign_up(Request $request,
                            EntityManagerInterface $manager): Response{
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $newUser = $form->getData();
            #$hashed = $passwordHasher->hashPassword($newUser,$form->getData('password'));
            $manager->persist($newUser);
            $manager->flush();
            $this->addFlash(
                'success',
                'You are registered. Now you can login'
            );
            return $this->redirectToRoute('main');
        }
        return $this->render('sing_up.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact() : Response{
        return $this->render('contact.html.twig');
    }
}
