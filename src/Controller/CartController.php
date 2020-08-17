<?php

namespace App\Controller;

use App\Tools\Cart\CartTool;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartTool $cartTool)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartTool->getFullCart(),
            'total' => $cartTool->getTotal()
        ]);
    }


    /**
     *@Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartTool $cartTool)
    {
        $cartTool->add($id);

        return $this->redirectToRoute("cart_index");
    }


    /**
     *@Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartTool $cartTool)
    {
        $cartTool->remove($id);

        return $this->redirectToRoute("cart_index");
    }
}
