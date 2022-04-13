<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AddNewItemType extends AbstractType
{

    public function getCategory(EntityManagerInterface $entityManager){
        $items = $entityManager->getRepository(Category::class)->findAll();
        return $items;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'attr' => [
                    'class' => 'form-control col-8'
                ]
            ])
            ->add('price', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control col-3'
                ]
            ])
            ->add('stock', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control col-12'
                ]
            ])
            ->add('descriptions', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '8'
                ]
            ])
            ->add('image', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'mapped' => false,
                'constraints' =>[
                    new File([
                        'maxSize' => '10024k',
                        'mimeTypes' =>[
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file(jpeg, jpg, png).'
                    ])
                ]
            ])
            ->add('image2', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'constraints' =>[
                    new File([
                        'maxSize' => '10024k',
                        'mimeTypes' =>[
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file(jpeg, jpg, png).'
                    ])
                ]
            ])
            ->add('image3', FileType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'constraints' =>[
                    new File([
                        'maxSize' => '10024k',
                        'mimeTypes' =>[
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file(jpeg, jpg, png).'
                    ])
                ]
            ])
            ->add('image4', FileType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'constraints' =>[
                    new File([
                        'maxSize' => '10024k',
                        'mimeTypes' =>[
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file(jpeg, jpg, png).'
                    ])
                ]
            ])
            ->add('image5', FileType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'constraints' =>[
                    new File([
                        'maxSize' => '10024k',
                        'mimeTypes' =>[
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid file(jpeg, jpg, png).'
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
