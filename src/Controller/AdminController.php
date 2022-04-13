<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddNewItemType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

##[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'app_admin')]

    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    #[Route('/add_new_item', name: 'app_admin_add_new')]
    public function add_new(Request $request,
                            EntityManagerInterface $entityManager,
                            SluggerInterface $slugger,
                            FileUploader $fileUploader){
        $product = new Product();
        $form = $this->createForm(AddNewItemType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            $image2 = $form->get('image2')->getData();
            $image3 = $form->get('image3')->getData();
            $image4 = $form->get('image4')->getData();
            $image5 = $form->get('image5')->getData();
            if($image){
                $imageFilename = $fileUploader->upload($image);
                $product->setImage($imageFilename);
            }
            if($image2){
                $imageFilename = $fileUploader->upload($image2);
                $product->setImage2($imageFilename);
            }
            if($image3){
                $imageFilename = $fileUploader->upload($image3);
                $product->setImage3($imageFilename);
            }
            if($image4){
                $imageFilename = $fileUploader->upload($image4);
                $product->setImage4($imageFilename);
            }
            if($image5){
                $imageFilename = $fileUploader->upload($image5);
                $product->setImage5($imageFilename);
            }

            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'New item was added'
            );
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/addNew.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/manage/', name: 'app_admin_manage')]
    public function manage(EntityManagerInterface $entityManager): Response{
        $items = $entityManager->getRepository(Product::class)->findAll();
        return$this->render('admin/manage.html.twig',[
            'items' => $items
        ]);
    }

    #[Route('/admin/delete/{id<\d+>}', name: 'app_admin_delete_item')]
    public function delete(int $id): Response{
        $item = $this->entityManager->getRepository(Product::class)->find($id);
        $this->entityManager->remove($item);
        $this->entityManager->flush();
        $this->addFlash(
            'success',
            'Item is deleted'
        );
        return $this->redirectToRoute('app_admin_manage');
    }

    #[Route('/admin/edit/{id<\d+>}', name: 'app_admin_edit_item')]
    public function edit(int $id): Response{
        $item = $this->entityManager->getRepository(Product::class)->find($id);
        $form = $this->createForm(AddNewItemType::class, $item);
        return $this->render('admin/addNew.html.twig', [
            'form' => $form->createView(),
            'action' => 'edit'
        ]);

    }

}
