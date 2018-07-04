<?php

namespace App\Controller;

use App\Entity\Ad;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller{

    /**
     * @Route("/", name="home")
     */
    public function home() {
        $adRepo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $adRepo->findBy([], ["dateCreated" => "DESC"], 50 );

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

    /**
     * @Route("/test/{id}", name="test", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function test($id) {
        dump($id);
        die;
    }

    /**
     * @Route("/test2", name="test2")
     */
    public function test2(EntityManagerInterface $em) {

    }
}

