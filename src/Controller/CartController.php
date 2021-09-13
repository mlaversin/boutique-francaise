<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        $cartComplete = [];

        if($cart->get()) {
            foreach($cart->get() as $id => $quantity) {
                $product_object = $this->getDoctrine()->getRepository(Product::class)->findOneById($id);
                if (!$product_object) {
                    $cart->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        

        return $this->render('cart/index.html.twig', [
            'cart' => $cartComplete
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/delete/{id}", name="delete_to_cart")
     */
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    }
}
