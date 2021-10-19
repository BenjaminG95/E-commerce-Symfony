<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

     /**
     * @Route("/mon-panier", name="cart")
     */

    public function index(Cart $cart)
    {
        $cartInfos = [];

        foreach ( $cart->get() as $id => $quantity) {
          $cartInfos[] = [
            'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
            'quantity' => $quantity
          ];
        }


   
        return $this->render('cart/index.html.twig', [
            'cart' => $cartInfos
        ]);
    }

     /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);

       return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove_cart")
     */

    public function remove(Cart $cart)
    {
        $cart->remove();

       return $this->redirectToRoute('products');
    }


}
