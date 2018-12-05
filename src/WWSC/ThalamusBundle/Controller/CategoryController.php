<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\Category;

/**
 * Category controler.
 *
 * In this controller describes the functions of category(files and messages).
 */
class CategoryController extends Controller {
    /**
     *  Method save.
     *
     *  This method is responsible for create and update new category.
     * 
     *  @return If successful updated or created category, return json object information about category. When an error occurs an error message.
     */
    public function saveAction(Request $request) {
        if($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))){
            $em = $this->getDoctrine()->getManager();
            if ($request->get('id')) {
                $oCategory = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Category')->find($request->get('id'));
                $oCategory->setName($request->get('name'));
                $em->flush();

                return new Response(json_encode(array(
                            'status' => 'success',
                            'id' => $oCategory->getId(),
                            'name' => $oCategory->getName(),
                )));
            }
            $oCategory = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Category')->findBy(array(
                'is_deleted' => 0,
                'project' => $oProject->getId(),
                'type' => $request->get('type'),
                'name' => $request->get('name'),
            ));
            if ($oCategory) {
                return new Response(json_encode(array('status' => 'error', 'msg' => 'Name has been alredy ben taken')));
            }
            $newCategoty = new Category();
            $newCategoty->setType($request->get('type'));
            $newCategoty->setProject($oProject);
            $newCategoty->setName($request->get('name'));
            $em->persist($newCategoty);
            $em->flush();

            return new Response(json_encode(array(
                        'status' => 'success',
                        'id' => $newCategoty->getId(),
                        'name' => $newCategoty->getName(),
            )));
        }
    }

    /**
     *  Method delete.
     * 
     *  This method is responsible for delete category
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $oCategory = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Category')->find($request->get('id'));
        $oCategory->setIsDeleted(1);
        $em->flush();

        return new Response(1);
    }
}
