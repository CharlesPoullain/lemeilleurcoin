<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\AdType;
use App\Entity\Ad;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CategoryController extends Controller
{

    /**
     * @Route("/category", name="category")
     */
    public function category() {
        $categoryRepo = $this->getDoctrine()->getRepository(Category::class );
        $categorys = $categoryRepo->findAll();

        return $this->render('category/category.html.twig', ["categorys" => $categorys]);
    }

    /**
     * @Route("/category/edit/{id}", name="categoryedit")
     */
    public function categoryEdit(Request $resquest, $id) {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($resquest);

        if($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            if (!$category) {
                throw $this->createNotFoundException(
                    'Pas de category trouvé pour l\'id '.$id
                );
            }
            $em->flush();
            $this->addFlash("success", "Votre categorie à bien été modifiée !");

            return $this->redirectToRoute('category');
        }

        return $this->render('category/category-edit.html.twig', [
            "categoryForm" => $categoryForm->createView(),
            "selectedcategory" => $category
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="categorydelete")
     */
    public function categoryDelete(Request $resquest, $id) {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);

        $em->remove($category);
        $em->flush();

        $this->addFlash("success", "Votre categorie à bien été suprimée !");

        return $this->redirectToRoute('category');

    }

    /**
     * @Route("/category/add", name="categoryadd")
     */
    public function categoryAdd(Request $resquest) {
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($resquest);
        if($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();

            $this->addFlash("success", "Votre catégorie à bien été ajouté !");

            return $this->redirectToRoute('category');

        }

        return $this->render('category/category-add.html.twig', [
            "categoryForm" => $categoryForm->createView()
        ]);

    }
}