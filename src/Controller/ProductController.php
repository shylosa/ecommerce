<?php
namespace App\Controller;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product")
     */
    public function view(Product $product)
    {
        return $this->render('product/view.html.twig', [
            'product' => $product,
        ]);
    }
}