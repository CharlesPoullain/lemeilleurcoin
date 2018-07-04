<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends Controller{

    /**
     * @Route("/", name="home")
     */
    public function home(Request $req) {

        /* $this->getUser()->getId()); */

        $categId = $req->query->get('cat');

        $adRepo = $this->getDoctrine()->getRepository(Ad::class);
        $keyword = $req->query->get("q");

        $ads = $adRepo->findHomeAds($categId, $keyword);


        return $this->render("default/home.html.twig", ["ads" => $ads]);
    }

    /**
     * @Route("/foire-aux-questions", name="faq")
     */
    public function faq() {
        return $this->render("default/faq.html.twig", []);
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu() {
        return $this->render("default/cgu.html.twig", []);
    }

    public function listAllCategories() {
        $categoryRepo = $this->getDoctrine()->getRepository(Category::class );
        $categorys = $categoryRepo->findAll();
        return $this->render("default/category_list.html.twig", [ "categorys" => $categorys, "categoryId" => $_GET["cat"] ?? null]);
    }

}

