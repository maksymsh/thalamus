<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SortElementsController extends Controller {
    public function changeSortAction(Request $request) {
        /**
         *  Method changing sorting items.
         * 
         *  This method is responsible for changing the sorting items (Drag-and-drop)
         */
        $aElements = $this->getDoctrine()->getRepository('WWSCThalamusBundle:'.$request->get('type'))->findBy(array(
            $request->get('field') => $request->get('value'),
        ));
        $aIds = json_decode($request->request->get('order'));
        $em = $this->getDoctrine()->getManager();
        if('TaskItem' == $request->get('type')){
            $oTask = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Task')->find($request->get('value'));
        }
        foreach ($aIds as $key => $val) {
            $oElement = $this->getDoctrine()->getRepository('WWSCThalamusBundle:'.$request->get('type'))->find($val);
            $oElement->setSort($key);
            $oElement->setSaveToLog(0);
            if('TaskItem' == $request->get('type')){
               $oElement->setTask($oTask);
            }
            $em->persist($oElement);
            $em->flush();
        }

        return new Response(1);
    }

    /**
     *  Method changing sorting items in table of Tasks page.
     *
     *  This method is responsible for changing the sorting items (Drag-and-drop)
     */
    public function changeSortTasksAction(Request $request)
    {
        $aIds = json_decode($request->request->get('order'));
        $em = $this->getDoctrine()->getManager();

        foreach ($aIds as $key => $id) {
            $oTaskItem = $this->getDoctrine()->getRepository('WWSCThalamusBundle:TaskItem')->find($id);
            $oTaskItem->setSortTasks($key);
            $oTaskItem->setSaveToLog(0);
            $em->persist($oTaskItem);
        }

        $em->flush();

        return new Response(1);
    }
}
