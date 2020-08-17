<?php

namespace App\Controller;

use App\Entity\Fruit;
use App\Form\FruitType;
use App\Repository\FruitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FruitController extends AbstractController
{
    /**
     * @Route("/fruits", name="fruits_index")
     */
    public function index(FruitRepository $repo)
    {
        $fruits = $repo->findAll();
        return $this->render('fruit/index.html.twig', [
            'fruits' => $fruits
        ]);
    }

    /**
     * CREER UN FRUIT - Formulaire
     * 
     * @Route("/fruits/new", name="fruits_create")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $fruit = new Fruit();

        $form = $this->createForm(FruitType::class, $fruit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($fruit->getImages() as $image) {
                $image->setFruit($fruit);
                $manager->persist($image);
            }

            $manager->persist($fruit);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le fruit {$fruit->getName()} est bien enregistré !"
            );

            return $this->redirectToRoute('fruits_show', [
                'slug' => $fruit->getSlug()
            ]);
        }

        return $this->render('fruit/new.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * EDITER UN FRUIT - Afficher le formulaire - Utilisation du ParamConverter
     * 
     * @Route("/fruits/{slug}/edit", name="fruits_edit")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @return Response
     */
    public function edit(Request $request, Fruit $fruit, EntityManagerInterface $manager)
    {
        $form = $this->createForm(FruitType::class, $fruit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($fruit->getImages() as $image) {
                $image->setFruit($fruit);
                $manager->persist($image);
            }

            $manager->persist($fruit);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de {$fruit->getName()} sont réalisées"
            );

            return $this->redirectToRoute('fruits_show', [
                'slug' => $fruit->getSlug()
            ]);
        }


        return $this->render('fruit/edit.html.twig', [
            'form' => $form->createView(),
            'fruit' => $fruit
        ]);
    }



    /**
     * AFFICHER UN SEUL FRUIT (slug) - Utilisation du ParamConverter
     *
     * @Route("/fruits/{slug}", name="fruits_show")
     * 
     * @return Response
     */
    public function show(Fruit $fruit)
    {
        return $this->render('fruit/show.html.twig', [
            'fruit' => $fruit
        ]);
    }

    /**
     * SUPPRIMER UNE ANNONCE
     * 
     * @Route("/fruits/{slug}/delete", name="fruits_delete")
     * @IsGranted("ROLE_ADMIN")
     *
     * @param fruit $fruit
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(fruit $fruit, EntityManagerInterface $manager)
    {
        $manager->remove($fruit);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le fruit {$fruit->getName()} est supprimé !"
        );

        return $this->redirectToRoute("fruits_index");
    }
}
