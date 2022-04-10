<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private $repository;
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route("/category/{id<\d+>}", name: 'category')]
    public function category(int $id): Response{
        $items = $this->repository->findBy(['category' => $id], ['createdAt' => 'DESC']);
        return $this->render('category.html.twig', [
            'items' => $items
        ]);
    }

    #[Route('/product/{id<\d+>}', name: 'product')]
    public function product(int $id): Response{
        $item = $this->repository->find($id);
        return $this->render('product.html.twig', [
            'item' => $item
        ]);
    }
    public function addNew(){

    }
}
