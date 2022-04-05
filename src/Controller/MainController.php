<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Users;
use App\Form\SignUpFormType;
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

class MainController extends AbstractController
{
    private $emi;
    function __constructor(ManagerRegistry $emi){
        $this->emi = $emi;
    }

    /*
     * Return start page with categories
     * TODO add random item display on main view
     */
    #[Route("/", name: "main")]
    public function index(ManagerRegistry $registry): Response
    {
        $categories = $registry->getRepository(Category::class)->findAll();
        return $this->render('main.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @param int $id
     * @Route ("/category/{id}", name="category")
     */
    public function category(int $id, ProductRepository $product): Response{
        $items = $product->findBy(['category' => $id]);
        return $this->render('category.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * @param int $id
     * @Route ("/product/{id}", name="product")
     */
    public function product(int $id, ProductRepository $repository): Response{
        $item = $repository->find($id);
        return $this->render('product.html.twig', [
            'item' => $item
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(): Response{
        $fill = new Users();
        $form = $this->createForm(UserFormType::class, $fill);
        return $this->render('login.html.twig', [
            'form' => $form->createView()]);
    }

    /*
     * This class display sign up view and registers new users to database
     * TODO make hash passwords
     */
    #[Route('/sign_up', name: 'sign_up')]
    public function sign_up(Request $request,
                            EntityManagerInterface $manager,
                            UserPasswordHasherInterface $hasher): Response{
        $user = new Users();
        $form = $this->createForm(SignUpFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $newUser = $form->getData();
            $hashed = $hasher->hashPassword($newUser,$form['password']->getData());
            $newUser->setPassword($hashed);
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
