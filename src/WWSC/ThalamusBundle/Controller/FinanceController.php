<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\Finance;
use WWSC\ThalamusBundle\Form\FinanceForm;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Task controler.
 *
 * In this controller describes the functions of describes the functions of adding, editing, deleting and display task.
 */
class FinanceController extends Controller {
    /**
     *  Method list.
     * 
     *  This method is responsible for display tasks and persons on  the page "To-dos"
     */
    public function listAction(Request $request) {
        $this->getRequest()->getSession()->set('active_module', 'finance');
        if ($oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            if (!$this->container->get('security.context')->isGranted('ROLE_PROVIDER') || ($oProject->getProjectleader('id') != $this->getUser()->getId() && 'ROLE_ACCOUNTING' != $this->getUser()->getRole())) {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
            if(!$request->getSession()->get('aDateRangeFilter') && 2 == $oProject->getType()){
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
                if('de' == $this->getUser()->getLanguageCode()){
                    $aFilter = array($request->get('project') => ['date_from' => date('01-m-Y'), 'date_to' => date($daysInMonth.'-m-Y')]);
                }
                else{
                    $aFilter = array($request->get('project') => ['date_from' => date('Y-m-01'), 'date_to' => date('Y-m-'.$daysInMonth)]);
                }
                $request->getSession()->set('aDateRangeFilter', $aFilter);
            }

            if(!$aFinanceFilter = $request->get('aFinanceFilter')){
                $aFinanceFilter = array('velues' => 0, 'hide-all-paid' => 1);
            }else{
                $aFinanceFilter['hide-all-paid'] = isset($aFinanceFilter['hide-all-paid']) ? $aFinanceFilter['hide-all-paid'] : 0;
            }
            $aFinancesProject = \WWSC\ThalamusBundle\Entity\Finance::getFinanseAllProject(false, $oProject->getId(), 'all', false, $oProject->getSlug());
            if(!isset($aFinancesProject[0])){
                $aFinancesProject = array();
            }else{
                $aFinancesProject = $aFinancesProject[0];
            }
            $aFinance = Finance::getCostProject($oProject->getId(), $oProject->getSlug(), $aFinanceFilter);

            return $this->render('WWSCThalamusBundle:Finance:list.html.twig', array(
                'aFinance' => $aFinance,
                'aFinanceFilter' => $aFinanceFilter,
                'aFilterValues' => Finance::$aFilterValues,
                'aFinancesProject' => $aFinancesProject,
                'projectSlug' => $request->get('project'),
                'projectName' => $oProject->getName(),
                'aProjectType' => array('1' => 'Fixed price', '2' => 'Time & material'),
                'totalAmount' => $oProject->getTotalAmount($aFinanceFilter),
            ));
        }
    }    

    public function listProjectAction(Request $request) {
         if (('ROLE_ACCOUNTING' != $this->getUser()->getRole() && !$this->getUser()->getResponsibleProjects('has-responsible-project')) || !$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        $this->getRequest()->getSession()->set('active_module', false, 'finance');
        $aData = Finance::getFinanseAllProject(true, false, $request->get('company'), $request->get('show-closed-projects'));

        return $this->render('WWSCThalamusBundle:Finance:list-project.html.twig', array(
            'aFinances' => $aData['aFinances'],
            'aFinancesTotal' => $aData['aTotalFinces'],
            'aProjectType' => array('1' => 'Fixed price', '2' => 'Time & material'),
            'company' => $request->get('company'),
        ));
    }

    /**
     *  Method add.
     *
     *  This method is responsible for create new item  for task.
     */
    public function addAction(Request $request) {
        $fFinance = $this->createForm(new FinanceForm());
        $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        if ('POST' == $request->getMethod()) {
            $fFinance->bind($request);
            if ($fFinance->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $fFinance = $fFinance->getData();
                $fFinance = $fFinance->setProject($oProject);
                $em->persist($fFinance);
                $em->flush();
                if(!$aFinanceFilter = $request->get('aFinanceFilter')){
                    $aFinanceFilter = false;
                }
                $aFinance = Finance::getCostProject($oProject->getId(), $oProject->getSlug(), $aFinanceFilter);
                $aFinancesProject = \WWSC\ThalamusBundle\Entity\Finance::getFinanseAllProject(false, $oProject->getId(),'all', false, $oProject->getSlug())[0];
                $aData = array();
                $aData['htmlFinance'] = $this->renderView('WWSCThalamusBundle:Finance:data-table.html.twig', array('aFinance' => $aFinance, 'totalAmount' => $oProject->getTotalAmount($aFinanceFilter)));
                $aData['headerFinance'] = $this->renderView('WWSCThalamusBundle:Finance:header-finance.html.twig', array('aFinancesProject' => $aFinancesProject));

                return new JsonResponse($aData);
            } else {
                return new JsonResponse(array('error' => 'incorrect data'));
            }
        }

        return new JsonResponse(array('htmlFinanceForm' => $this->renderView('WWSCThalamusBundle:Finance:add.html.twig', array('form' => $fFinance->createView(), 'projectSlug' => $request->get('project')))));
    }

    /**
     *  Method edit.
     *
     *  This method is responsible  for edit task
     */
    public function editAction(Request $request) {
        $oFinance = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Finance')->find($request->get('id'));
        $fFinance = $this->createForm(new FinanceForm(), $oFinance);
        if ('POST' == $request->getMethod()) {
            $fFinance->bind($request);
            if ($fFinance->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $fFinance = $fFinance->getData();
                $em->persist($fFinance);
                $em->flush();
                if(!$aFinanceFilter = $request->get('aFinanceFilter')){
                    $aFinanceFilter = false;
                }
                $aFinance = Finance::getCostProject($fFinance->getProject()->getId(), $fFinance->getProject()->getSlug(), $aFinanceFilter); 
                $aFinancesProject = \WWSC\ThalamusBundle\Entity\Finance::getFinanseAllProject(false, $fFinance->getProject()->getId(),'all', false,  $fFinance->getProject()->getSlug())[0];
                $aData = array();
                $aData['htmlFinance'] = $this->renderView('WWSCThalamusBundle:Finance:data-table.html.twig', array('aFinance' => $aFinance, 'totalAmount' => $oFinance->getProject()->getTotalAmount($aFinanceFilter)));
                $aData['headerFinance'] = $this->renderView('WWSCThalamusBundle:Finance:header-finance.html.twig', array('aFinancesProject' => $aFinancesProject));

                return new JsonResponse($aData);
            }
        }

        return new JsonResponse(array('htmlFinanceForm' => $this->renderView('WWSCThalamusBundle:Finance:edit.html.twig', array('form' => $fFinance->createView(), 'oFinance' => $oFinance))));
    }    

    /**
     *  Method delete.
     * 
     *  This method is responsible for delete finanse
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $oFinance = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Finance')->find($request->get('id'));
        $oFinance->setIsDeleted(1);
        $em->flush();
        $aFinancesProject = \WWSC\ThalamusBundle\Entity\Finance::getFinanseAllProject(false, $oFinance->getProject()->getId(),'all', false, $oFinance->getProject()->getSlug())[0];
        if(!$aFinanceFilter = $request->get('aFinanceFilter')){
            $aFinanceFilter = false;
        }
        $aData = array();
        $aData['totalAmount'] = $oFinance->getProject()->getTotalAmount($aFinanceFilter);
        $aData['headerFinance'] = $this->renderView('WWSCThalamusBundle:Finance:header-finance.html.twig', array('aFinancesProject' => $aFinancesProject));

        return new JsonResponse($aData);
    }

    public function dublicateAction(Request $request) {
        $oFinance = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Finance')->find($request->get('id'));
        $oProject = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        $newFinance = clone $oFinance;
        $em = $this->getDoctrine()->getManager();
        $em->persist($newFinance);
        $em->flush();
        if(!$aFinanceFilter = $request->get('aFinanceFilter')){
            $aFinanceFilter = false;
        }
        $aFinance = Finance::getCostProject($oFinance->getProject()->getId(),$oFinance->getProject()->getSlug(), $aFinanceFilter);
        $aFinancesProject = \WWSC\ThalamusBundle\Entity\Finance::getFinanseAllProject(false, $oFinance->getProject()->getId(),'all', false, $oFinance->getProject()->getSlug())[0];
        $aData = array();
        $aData['htmlFinance'] = $this->renderView('WWSCThalamusBundle:Finance:data-table.html.twig', array('aFinance' => $aFinance, 'totalAmount' => $oProject->getTotalAmount($aFinanceFilter)));
        $aData['headerFinance'] = $this->renderView('WWSCThalamusBundle:Finance:header-finance.html.twig', array('aFinancesProject' => $aFinancesProject));

        return new JsonResponse($aData);
    }

      public function exportToCsvAction(Request $request){
       if($request->get('auth')){
           if($oUser = $this->getDoctrine()->getRepository('WWSCThalamusBundle:User')->findOneBy(array('salt' => $request->get('token')))){
                if($token = new UsernamePasswordToken($oUser, null, 'main', $oUser->getRoles())){
                    $this->container->get('security.context')->setToken($token);
                    $language = $this->getUser()->getLanguage();
                    if('de' == $language || 'de_AT' == $language){
                         $request->getSession()->set('_localeThalamus', 'de');
                    }
                    $oAccount = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Account')->find($this->getUser()->getLastLoggedAccount());
                    $request->getSession()->set('account', (object) array('slug' => $oAccount->getSlug(), 'name' => $oAccount->getName(), 'id' => $oAccount->getId()));
                    $auth = true;
                }
           }else{
               return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
           }
       }

        if ('ROLE_ACCOUNTING' != $this->getUser()->getRole() || !$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        $fileName = date('ymd').'-finance-export';
        $aColumns = array('Net value', 'Calculated gross value', 'Invoice-Date', 'Invoice Due Date', 'Status', 'Billable', 'Text', 'Deeplink', 'Project-Name', 'Project-URL');
        $response = new StreamedResponse();
        $aAllCostLines = Finance::allCostLines($request->get('hide-payd-costs'));
        //$aProjectType = array('1' => 'Fixed price', '2' => 'Time & material');
        $aCostStatus = Finance::$aStatus;
        $response->setCallback(
            function () use($aAllCostLines, $aColumns, $aCostStatus) {
                $handle = fopen('php://output', 'r+');
                fputcsv($handle, $aColumns,',');
                foreach ($aAllCostLines as $aCostLine) {
                    $data = array(
                        $this->getUser()->formatPrice($aCostLine['net_value']),
                        $this->getUser()->formatPrice($aCostLine['gross_value']),
                        date('d.m.y', strtotime($aCostLine['invoice_date'])),
                        date('d.m.y', strtotime($aCostLine['due_date'])),
                        isset($aCostStatus[$aCostLine['status']]) ? $aCostStatus[$aCostLine['status']] : null,
                        $aCostLine['billable'],
                        $aCostLine['description'],
                        $this->generateUrl('wwsc_thalamus_project_finance', array('project' => $aCostLine['project_slug']), true).'#cost-id-'.$aCostLine['f_id'],
                        $aCostLine['project_name'],
                        //$aCostLine['projectleader'],
                        //$aCostLine['project_type']?$aProjectType[$aCostLine['project_type']]:null,
                        $this->generateUrl('wwsc_thalamus_project_overview', array('project' => $aCostLine['project_slug']), true),
                      );
                    fputcsv($handle, $data, ',');
                }
                fclose($handle);
            }
        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="'.$fileName.'.csv"'
        );

       return $response;
   }

    public function exportTimeToCsvAction(Request $request){
        if($request->get('auth')){
            if($oUser = $this->getDoctrine()->getRepository('WWSCThalamusBundle:User')->findOneBy(array('salt' => $request->get('token')))){
                if($token = new UsernamePasswordToken($oUser, null, 'main', $oUser->getRoles())){
                    $this->container->get('security.context')->setToken($token);
                    $language = $this->getUser()->getLanguage();
                    if('de' == $language || 'de_AT' == $language){
                        $request->getSession()->set('_localeThalamus', 'de');
                    }
                    $oAccount = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Account')->find($this->getUser()->getLastLoggedAccount());
                    $request->getSession()->set('account', (object) array('slug' => $oAccount->getSlug(), 'name' => $oAccount->getName(), 'id' => $oAccount->getId()));
                    $auth = true;
                }
            }else{
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
        }

        if ('ROLE_ACCOUNTING' != $this->getUser()->getRole() || !$this->container->get('security.context')->isGranted('ROLE_PROVIDER')) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $fileName = date('ymd').'-all-time-export';
        $aAllUsersTimeLines = Finance::getAccountUsersTime();
        $aAllCompaniesTimeLines = Finance::getCompaniesTime();
        $aAllUserCompanies = array_merge($aAllUsersTimeLines, $aAllCompaniesTimeLines);
        foreach($aAllUserCompanies as $aUsersCompaniesLine)
        {
            $aData[] = array(date('m.Y', strtotime($aUsersCompaniesLine['date'])) => array(
                'name' => isset($aUsersCompaniesLine['roles']) && 'ROLE_PROVIDER' === $aUsersCompaniesLine['roles'] ? $aUsersCompaniesLine['name'].' TOTAL' : $aUsersCompaniesLine['name'],
                'billable' => $aUsersCompaniesLine['billable'],
                'notbillable' => $aUsersCompaniesLine['notbillable'],
                'total' => $aUsersCompaniesLine['billable'] + $aUsersCompaniesLine['notbillable'],
                'roles' => isset($aUsersCompaniesLine['roles']) ? $aUsersCompaniesLine['roles'] : null,
            ));
        }

        foreach ($aData as $key => $value) {
            foreach ($value as $k => $v) {
                if(null !== $v['roles'])
                {
                   unset($aData[$key][$k]['billable']);
                   unset($aData[$key][$k]['notbillable']);
                }
                $aUsersCompaniesNames[$v['name']] = $v['roles'];
                $result[$k][] = $v;
            }
        }
        $aUsersCompaniesNames['All Freelancers Total'] = 'ROLE_FREELANCER';
        $aHeders[] = ' ';
        $aNames = array();
        foreach($aUsersCompaniesNames as $key => $name)
        {
            if('ROLE_FREELANCER' === $name){
                $aNames[] = $key;
                $aHeders[] = 'Total';
            }else {
                $aNames[] = 0 == count($aNames) ? 'Full month' : ' ';
                $aNames[] = $key;
                $aNames[] = ' ';
                $aHeders[] = 'Billable';
                $aHeders[] = 'Nonbillable';
                $aHeders[] = 'Total';
            }
           if('ROLE_PROVIDER' === $name)
            {
                $aNames[] = ' ';
            }
        }
        $response = new StreamedResponse();
        $response->setCallback(
            function () use($result, $aNames,$aHeders) {
                $handle = fopen('php://output', 'r+');
                fputcsv($handle, $aNames, ',');
                fputcsv($handle, $aHeders, ',');
                        foreach ($result as $date => $aUsers) {
                            $aDate[] = $date;
                            $total = 0;
                            foreach ($aUsers as $value) {
                                        if ('ROLE_FREELANCER' == $value['roles']) {
                                            $aDate[] = $value['total'];
                                            $total += $value['total'];
                                        } else {
                                            $aDate[] = $value['billable'];
                                            $aDate[] = $value['notbillable'];
                                            $aDate[] = $value['total'];
                                        }
                            }
                            $aDate[] = $total;
                            fputcsv($handle, $aDate, ',');
                            $aDate = '';
                        }
                fclose($handle);
            }
        );

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="'.$fileName.'.csv"'
        );

        return $response;
    }

    public function output($input, $exit = false)
    {
        echo '<pre>';
        print_r($input);
        echo '</pre>';

        if(true === $exit){
            exit;
        }
    }

    public function dateRangeFilterAction(Request $request){
    if($request->get('project')){
        if(!$aDateRangeFilter = $request->getSession()->get('aDateRangeFilter')){
            $aDateRangeFilter = array();
        }
        $aDateRangeFilter[$request->get('project')] = $request->get('aFilter');        
        $request->getSession()->set('aDateRangeFilter', $aDateRangeFilter);
    }

    return new JsonResponse(1);
   }
    
}
