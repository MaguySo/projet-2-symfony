<?php


namespace App\Tools\Cart;

use App\Repository\FruitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartTool
{
    protected $session;
    protected $fruitRepository;

    public function __construct(SessionInterface $session, FruitRepository $fruitRepository)
    {
        $this->session = $session;
        $this->fruitRepository = $fruitRepository;
    }



    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'fruit' => $this->fruitRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $panierWithData;
    }


    public function getTotal(): float
    {
        $total = 0;


        foreach ($this->getFullCart() as $item) {
            $total += $item['fruit']->getprice() * $item['quantity'];
        }

        return $total;
    }
}
