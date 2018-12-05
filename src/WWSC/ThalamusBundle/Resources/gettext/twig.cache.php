<?php
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Account\all-people.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    All People
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-12">
            <div class="panel-heading col-md-12">
                <div class="col-md-6">
                    Every company and person in your system
                </div>
                <div class="col-md-6">
                    ';
        // line 13
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo ' 
                    <div class="btn-add-company btn-right">
                        <a href="#add-new-company"  data-toggle="modal" class="btn btn-default btn-md">
                            <i class="glyphicon glyphicon-plus"></i> Add a new company 
                        </a>
                        <small>(you can add people to it next)</small>
                    </div>
                    ';
        }
        // line 21
        echo '                </div>    
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 main">
                        <div class="modal fade" id="add-new-company">
                            ';
        // line 27
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller('WWSCThalamusBundle:Company:add'));
        echo '
                        </div>
                    </div>
                    ';
        // line 30
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 31
        echo '                    <div class="list-company col-md-12">
                        ';
        // line 32
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aCompanies']) ? $context['aCompanies'] : $this->getContext($context, 'aCompanies')));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oCompany']) {
            // line 33
            echo '                            ';
            if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || ($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())))) {
                // line 34
                echo '                            <div class="company  col-xs-12">
                                <div class="title-panel col-xs-12">
                                    ';
                // line 36
                if (($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array()))) {
                    echo ' 
                                        Your company:
                                    ';
                }
                // line 39
                echo '                                    ';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'name', array()), 'html', null, true);
                echo '
                                    <small>( ';
                // line 40
                echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'roleName', array()), 'html', null, true);
                echo ' )</small>
                                </div>
                                ';
                // line 42
                if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || ($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())))) {
                    // line 43
                    echo '                                <div class="btn-add-new-person">
                                    <a href="';
                    // line 44
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_add', array('company' => $this->getAttribute($context['oCompany'], 'id', array()))), 'html', null, true);
                    echo '" class="btn btn-default btn-md">
                                        <i class="glyphicon glyphicon-plus"></i> Add a new person
                                    </a>
                                </div>
                                ';
                }
                // line 48
                echo '        
                                <div class="item col-md-4">
                                    <div class="avatar">
                                        <img src="';
                // line 51
                echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter($this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/company_icon.png'), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
                echo '">
                                    </div>
                                    <div class="desc">
                                        ';
                // line 54
                $this->env->loadTemplate('WWSCThalamusBundle:Company:block_info_company.html.twig')->display(array_merge($context, array('company' => $context['oCompany'])));
                // line 55
                echo '                                        ';
                if ((($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())) || $this->env->getExtension('security')->isGranted('ROLE_PROVIDER'))) {
                    echo '                    
                                            <a href="';
                    // line 56
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_company_edit', array('id' => $this->getAttribute($context['oCompany'], 'id', array()))), 'html', null, true);
                    echo '">Edit</a> <small> this company</small>
                                        ';
                }
                // line 58
                echo '                                    </div>
                                </div>
                                ';
                // line 60
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oCompany'], 'companyUser', array()));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index' => 1,
                  'first' => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context['_key'] => $context['companyUser']) {
                    // line 61
                    echo '                                    ';
                    $context['oUser'] = $this->getAttribute($context['companyUser'], 'user', array());
                    // line 62
                    echo '                                    <div class="item col-md-4">
                                        <div class="avatar">
                                            ';
                    // line 64
                    if ($this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'avatar', array())) {
                        // line 65
                        echo '                                                ';
                        $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'avatar', array()));
                        // line 66
                        echo '                                            ';
                    } else {
                        // line 67
                        echo '                                                ';
                        $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
                        // line 68
                        echo '                                            ';
                    }
                    // line 69
                    echo '                                            <img src="';
                    echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
                    echo '">
                                            ';
                    // line 70
                    if ($this->getAttribute($context['companyUser'], 'enabled', array())) {
                        // line 71
                        echo '                                                ';
                        if (((isset($context['accountOwnerId']) ? $context['accountOwnerId'] : $this->getContext($context, 'accountOwnerId')) == $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'id', array()))) {
                            // line 72
                            echo '                                                    <div class="badge badge-owner">OWNER</div>
                                                ';
                        }
                        // line 73
                        echo '   
                                            ';
                    } else {
                        // line 75
                        echo '                                                <div class="badge badge-invited">INVITED</div>      
                                            ';
                    }
                    // line 76
                    echo '   
                                        </div>
                                        <div class="desc">
                                            ';
                    // line 79
                    $this->env->loadTemplate('WWSCThalamusBundle:User:block_info_user.html.twig')->display(array_merge($context, array('user' => (isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')))));
                    // line 80
                    echo '                                            ';
                    if ((($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())) || $this->env->getExtension('security')->isGranted('ROLE_PROVIDER'))) {
                        echo '   
                                                <a href="';
                        // line 81
                        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_edit', array('id' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'id', array()))), 'html', null, true);
                        echo '"">Edit</a>
                                            ';
                    }
                    // line 83
                    echo '                                        </div>
                                    </div>
                                ';
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['companyUser'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 86
                echo '                            </div>
                            ';
            }
            // line 88
            echo '                        ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo '                   
                    </div>            
                </div><!--/span-->
            </div>  
        </div>
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (264 => 88,  260 => 86,  244 => 83,  239 => 81,  234 => 80,  232 => 79,  227 => 76,  223 => 75,  219 => 73,  215 => 72,  212 => 71,  210 => 70,  205 => 69,  202 => 68,  199 => 67,  196 => 66,  193 => 65,  191 => 64,  187 => 62,  184 => 61,  167 => 60,  163 => 58,  158 => 56,  153 => 55,  151 => 54,  145 => 51,  140 => 48,  132 => 44,  129 => 43,  127 => 42,  122 => 40,  117 => 39,  111 => 36,  107 => 34,  104 => 33,  87 => 32,  84 => 31,  82 => 30,  76 => 27,  68 => 21,  57 => 13,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Account\dashboard.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Dashboard 
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
<div class="row dashboard-account">
    <div class="panel panel-default col-md-9">
        <div class="panel-heading">
            Welcome to your Thalamus
        </div>
        <div class="panel-body">
            <div class="row">
                ';
        // line 13
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 14
        echo '                ';
        if (twig_test_empty($this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'projects', array()))) {
            // line 15
            echo '                    ';
            if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
                echo ' 
                    <div class="panel-offer">
                        <h1><a href="';
                // line 17
                echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_add');
                echo "\">Create your first project</a></h1>
                        It takes just a few seconds and you'll be up and running
                    </div>
                    ";
            }
            // line 21
            echo '                ';
        } else {
            // line 22
            echo '                    ';
            if ( !twig_test_empty($this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'projectsForDashboard', array()))) {
                // line 23
                echo '                        ';
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'projectsForDashboard', array()));
                foreach ($context['_seq'] as $context['_key'] => $context['aProject']) {
                    // line 24
                    echo '                                <div class="dashboard-today">
                                    <a href="';
                    // line 25
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_overview', array('project' => $this->getAttribute($context['aProject'], 'slug', array(), 'array'))), 'html', null, true);
                    echo '">
                                        ';
                    // line 26
                    echo twig_escape_filter($this->env, $this->getAttribute($context['aProject'], 'name', array(), 'array'), 'html', null, true);
                    echo '
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped dashboard-log">
                                        <tbody>
                                            ';
                    // line 32
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['aProject'], 'log', array(), 'array'));
                    foreach ($context['_seq'] as $context['_key'] => $context['aLog']) {
                        // line 33
                        echo '                                                <tr>
                                                    <td class="type col-md-2" ><span class="';
                        // line 34
                        echo twig_escape_filter($this->env, twig_lower_filter($this->env, $this->getAttribute($context['aLog'], 'object_type', array(), 'array')), 'html', null, true);
                        echo '">';
                        echo twig_escape_filter($this->env, $this->getAttribute($context['aLog'], 'object_type', array(), 'array'), 'html', null, true);
                        echo '</span></td>
                                                    <td class="item">
                                                        ';
                        // line 37
                        echo '                                                            ';
                        echo $this->getAttribute($context['aLog'], 'description', array(), 'array');
                        echo '
                                                        ';
                        // line 38
                        echo '</td>
                                                    <td class="action">';
                        // line 39
                        echo twig_escape_filter($this->env, $this->getAttribute($context['aLog'], 'action', array(), 'array'), 'html', null, true);
                        echo '</td>
                                                    <td class="author">';
                        // line 40
                        echo twig_escape_filter($this->env, $this->getAttribute($context['aLog'], 'first_name', array(), 'array'), 'html', null, true);
                        echo ' ';
                        echo twig_escape_filter($this->env, $this->getAttribute($context['aLog'], 'last_name', array(), 'array'), 'html', null, true);
                        echo '</td>
                                                    <td class="author">';
                        // line 41
                        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context['aLog'], 'created', array(), 'array'), 'M j'), 'html', null, true);
                        echo '</td>
                                                </tr>
                                            ';
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['aLog'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 44
                    echo '                                        </tbody>
                                    </table>
                                </div>
                        ';
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['aProject'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 48
                echo '                    ';
            }
            // line 49
            echo '                ';
        }
        // line 50
        echo '            </div>
            <div class="row">
                <div class="info-panel global-feeds dashboard-feeds">
                    <h4>Your global feeds <span>(<a href="#" target="_blank">read me first</a>)</span></h4>
                    <div>
                        <img  src="';
        // line 55
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/feedIcon.png'), 'html', null, true);
        echo '"><a href="#">Global RSS Feed</a>:Be notified about major activities across all your projects.<br>
                    </div>
                    <div>
                        <img  src="';
        // line 58
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/calendar-icon.png'), 'html', null, true);
        echo '"><a href="#">Global iCalendar</a>:Get milestones from all your projects in a single iCalendar feed.
                    </div>
                </div>
            </div>
        </div>
    </div>                          
    <div class="col-md-3 sidebar sidebar-user">
        <div class="col">
            ';
        // line 66
        if ((($this->getAttribute($this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'primaryCompany', array()), 'id', array()) != $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())) && $this->getAttribute($this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'primaryCompany', array()), 'logo', array()))) {
            // line 67
            echo '                <div class="info-panel box-company-logo">
                    <img src="';
            // line 68
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(($this->env->getExtension('assets')->getAssetUrl('uploads/company/').$this->getAttribute($this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'primaryCompany', array()), 'logo', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 242, 1 => 242), 'mode' => 'inset'))), 'html', null, true);
            echo '">
                </div>
            ';
        }
        // line 71
        echo '            ';
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'logo', array())) {
            // line 72
            echo '                <div class="info-panel box-company-logo">
                    <img src="';
            // line 73
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(($this->env->getExtension('assets')->getAssetUrl('uploads/company/').$this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'logo', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 242, 1 => 242), 'mode' => 'inset'))), 'html', null, true);
            echo '">
                </div>
            ';
        }
        // line 76
        echo '            <div class="title-panel">Questions? Need help?</div>
            <div class="info-panel">
                No problem. Check the well-stocked help section, the screenshot and video tours.
            </div>
            ';
        // line 80
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'projects', array())) > 0)) {
            echo '  
            <div class="title-panel">Projects</div>
            <div class="info-panel sidebar-people-on-project">
                ';
            // line 83
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'projects', array(0 => true), 'method'));
            foreach ($context['_seq'] as $context['_key'] => $context['aCompProjects']) {
                // line 84
                echo '                    <div class="item-compnay">';
                echo twig_escape_filter($this->env, $this->getAttribute($context['aCompProjects'], 'company_name', array(), 'array'), 'html', null, true);
                echo '</div>
                        <div class="list-projects">
                            ';
                // line 86
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['aCompProjects'], 'projects', array(), 'array'));
                foreach ($context['_seq'] as $context['_key'] => $context['aProject']) {
                    // line 87
                    echo '                            <div class="item-project">
                                <a href="';
                    // line 88
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_overview', array('project' => $this->getAttribute($context['aProject'], 'slug', array(), 'array'))), 'html', null, true);
                    echo '">
                                  ';
                    // line 89
                    echo twig_escape_filter($this->env, $this->getAttribute($context['aProject'], 'name', array(), 'array'), 'html', null, true);
                    echo '
                                </a>
                            </div>    
                            ';
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['aProject'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 93
                echo '                            </div>
                ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['aCompProjects'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 95
            echo '            </div>
            ';
        }
        // line 96
        echo '     
            ';
        // line 97
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo '     
            <div class="btn-add-new-project">
                <a href="';
            // line 99
            echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_add');
            echo '" class="btn btn-default btn-md">
                    <i class="glyphicon glyphicon-plus"></i> Create new project
                </a>
            </div>
            ';
        }
        // line 103
        echo '        
        </div>
    </div><!--/span-->
</div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (275 => 103,  267 => 99,  262 => 97,  259 => 96,  255 => 95,  248 => 93,  238 => 89,  234 => 88,  231 => 87,  227 => 86,  221 => 84,  217 => 83,  211 => 80,  205 => 76,  199 => 73,  196 => 72,  193 => 71,  187 => 68,  184 => 67,  182 => 66,  171 => 58,  165 => 55,  158 => 50,  155 => 49,  152 => 48,  143 => 44,  134 => 41,  128 => 40,  124 => 39,  121 => 38,  116 => 37,  109 => 34,  106 => 33,  102 => 32,  93 => 26,  89 => 25,  86 => 24,  81 => 23,  78 => 22,  75 => 21,  68 => 17,  62 => 15,  59 => 14,  57 => 13,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Account\error_account.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('::base.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return '::base.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "    <div class=\"row\">
        <div class=\"dialog-error\">
            <div>
                <h3>The account you were looking for doesn't exist.</h3>
                <p>Go to the registration page <a href=\"https://thalamus.io/\">thalamus.io</a></p>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (39 => 3,  36 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Account\header.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="';
        // line 10
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_dashboard');
        echo '">';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'account'), 'method'), 'name', array()), 'html', null, true);
        echo '</a>
        </div>
        <div class="collapse navbar-collapse">
            <div id="settings_signout_and_help">
                <span class="account">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                          Account: <strong>';
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'account'), 'method'), 'name', array()), 'html', null, true);
        echo ' </strong>
                          <span class="caret"></span>
                        </a>
                        ';
        // line 20
        if ((twig_length_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'companies', array())) > 1)) {
            // line 21
            echo '                            <ul class="dropdown-menu">
                                ';
            // line 22
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'companies', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oCompany']) {
                // line 23
                echo '                                    <li  ';
                if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'account'), 'method'), 'slug', array()) == $this->getAttribute($this->getAttribute($context['oCompany'], 'account', array()), 'slug', array()))) {
                    echo 'class="active" ';
                }
                echo ' ><a href="';
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_change', array('account' => $this->getAttribute($this->getAttribute($context['oCompany'], 'account', array()), 'id', array()))), 'html', null, true);
                echo '">';
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context['oCompany'], 'account', array()), 'name', array()), 'html', null, true);
                echo '</a></li>
                                ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCompany'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 25
            echo '                            </ul>
                        ';
        }
        // line 27
        echo '                    </div>|
                </span>
                <span class="name">';
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
        echo '</span>
                <span class="pipe">|</span>
                <a href="';
        // line 31
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_myinfo');
        echo '" title="Review and edit your account information">My info</a>
                <span class="pipe">|</span>
                <a href="';
        // line 33
        echo $this->env->getExtension('routing')->getPath('fos_user_security_logout');
        echo '" title="Sign out and clear the cookie off your machine">Sign out</a>
                ';
        // line 34
        $this->env->loadTemplate('WWSCThalamusBundle:Task:search-task-form.html.twig')->display($context);
        // line 35
        echo '                <a href="#" class="help" target="_blank"><span>HELP</span></a>
            </div>
            <ul class="nav navbar-nav">
                <li ';
        // line 38
        if (('dashboard' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' ><a href="';
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_dashboard');
        echo '">Dashboard</a></li>
                <li ';
        // line 39
        if (('my-todos' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' ><a href="';
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_my_todos');
        echo '">my To-DoS</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li ';
        // line 42
        if (('all-people' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' ><a href="';
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_all_people');
        echo '">All People</a></li>
                <li class="print"><a href="javascript:window.print()"  title="print"><img height=18px src="';
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/print_icon.png'), 'html', null, true);
        echo '"></a></li>
            </ul>
        </div>
    </div>
</div>
            ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (129 => 43,  121 => 42,  111 => 39,  103 => 38,  98 => 35,  96 => 34,  92 => 33,  87 => 31,  80 => 29,  76 => 27,  72 => 25,  57 => 23,  53 => 22,  50 => 21,  48 => 20,  42 => 17,  30 => 10,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Account\new-account.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('::base.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return '::base.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Create new account
';
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        echo "   
<div class=\"container new-account\">
        <div class=\"row\">
            <div class=\"panel panel-default  col-xs-offset-2  col-lg-7\">
            <div class=\"panel-heading\">
                You're just 60 seconds away from your new Thalamus account.
            </div>
            <div class=\"panel-body\">
                <div class=\"row\">
                    <div class=\"col-md-12 panel-info\">
                        <div class=\"col-md-6\">
                            <p><strong>Hi ";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
        echo ',</strong> <span class="logout">(<a href="';
        echo $this->env->getExtension('routing')->getPath('fos_user_security_logout');
        echo "\" rel=\"nofollow\">I'm not ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
        echo '</a>)</span></p>
                            <p>After your account is created, you can sign in with the same <strong>username and password</strong> that you use with your other accounts.</p>
                        </div>
                        <div class="col-md-6">
                            ';
        // line 20
        $this->env->loadTemplate('WWSCThalamusBundle:User:my_info_block.html.twig')->display(array_merge($context, array('oUser' => $this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()))));
        // line 21
        echo '                       </div>
                   </div>
                   <div class="col-md-12">
                        <form  class="form-horizontal form-new-account" action="';
        // line 24
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_new');
        echo '"  method="POST">                              
                            ';
        // line 25
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 26
        echo '                            ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 27
            echo '                                <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                            ';
        }
        // line 29
        echo "                            <div  class=\"col-md-12\">
                                <h3>A few details and you're on your way</h3>
                            </div>
                            <div  class=\"col-md-12\">
                                <div  class=\"col-md-2\">Company:</div>
                                 <div  class=\"col-md-8\">
                                     ";
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'widget');
        echo '<small>(Or non-profit, organization, group, school, etc.)</small>
                                 </div>
                             </div>
                              <div  class="col-md-12">
                                <div  class="col-md-2">Time zone:</div>
                                 <div  class="col-md-8">
                                     ';
        // line 41
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'timeZone', array()), 'widget');
        echo "
                                 </div>
                             </div>
                             <div class=\"col-md-12 panel-offer\">
                               You have selected the Free plan. There is no time limit on the free plan — you can use it for free as long as you'd like. You can always upgrade to a paying plan later if you need multiple projects, more file storage, etc.
                             </div>
                             <hr>
                             ";
        // line 48
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                            <div class="form-group">
                                 <div class="col-xs-9">
                                     <input type="submit" class="btn btn-primary" value="Create my account">
                                 </div>
                            </div>  
                        </form> 
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (124 => 48,  114 => 41,  105 => 35,  97 => 29,  91 => 27,  88 => 26,  86 => 25,  82 => 24,  77 => 21,  75 => 20,  60 => 16,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Account\registration.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('::base.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return '::base.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Registration
';
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        // line 6
        echo '    <div class="container registration">
        <div class="row">
            <div class="panel panel-default  col-xs-offset-2  col-lg-7">
                <div class="panel-heading">
                   ';
        // line 10
        echo $this->env->getExtension('translator')->getTranslator()->trans('Registration', array(), 'messages');
        // line 11
        echo '                </div>
                <div class="panel-body">
                    ';
        // line 13
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 14
        echo '                    ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 15
            echo '                        <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                    ';
        }
        // line 17
        echo '                    <div class="panel-offer">
                        Already have a Thalamus account?<br>
                        <a  href="#sigin-modal" data-toggle="modal">Sign in here.</a> to skip this form and use the username you already have.
                    </div>
                    <div class="modal fade" id="sigin-modal">
                         ';
        // line 22
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller('WWSCThalamusBundle:Security:login', array('ajaxLogin' => true)));
        echo " }
                    </div>
                    <h4>A few details and you're on your way</h4> 
                    <form  class=\"form-horizontal form-registration\" action=\"";
        // line 25
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_registration_account');
        echo '"  method="POST">                              
                        <div class="form-group">
                            ';
        // line 27
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'first_name', array()), 'label');
        echo '
                            <div class="col-md-6">
                                ';
        // line 29
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'first_name', array()), 'widget');
        echo '
                            </div>
                        </div>
                        <div class="form-group">
                            ';
        // line 33
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'last_name', array()), 'label');
        echo '
                            <div class="col-md-6">
                                ';
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'last_name', array()), 'widget');
        echo '
                            </div>
                        </div>
                        <div class="form-group">
                            ';
        // line 39
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'email', array()), 'label');
        echo '
                            <div class="col-md-6">
                                ';
        // line 41
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'email', array()), 'widget');
        echo '
                            </div>
                        </div>    
                        <div class="form-group">
                            ';
        // line 45
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'account', array()), 'label');
        echo '
                            <div class="col-md-6">
                                ';
        // line 47
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'account', array()), 'widget');
        echo '
                                <div class="help">(Or non-profit, organization, group, school, etc.)</div>
                            </div>
                        </div>
                        <div class="form-group">
                            ';
        // line 52
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'timezone', array()), 'label');
        echo '
                            <div class="col-xs-8">
                                ';
        // line 54
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'timezone', array()), 'widget');
        echo '
                            </div>
                        </div>       
                        <fieldset class="credentials">
                            <legend>Now choose a password</legend>
                            <div class="form-group plain-password">
                                <div class="col-xs-offset-1 col-md-6">
                                    ';
        // line 61
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'plainPassword', array()), 'widget');
        echo '
                                </div>
                            </div>
                            ';
        // line 64
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                        </fieldset> 
                        <hr>
                        <div class="form-group">
                            <div class="col-xs-9">
                                <input type="submit" class="btn btn-primary" value="Create my account">
                            </div>
                        </div>
                    </form>
                </div>
            </div>           
        </div>    
    </div><!--/.container-->
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (159 => 64,  153 => 61,  143 => 54,  138 => 52,  130 => 47,  125 => 45,  118 => 41,  113 => 39,  106 => 35,  101 => 33,  94 => 29,  89 => 27,  84 => 25,  78 => 22,  71 => 17,  65 => 15,  62 => 14,  60 => 13,  56 => 11,  54 => 10,  48 => 6,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Category\list.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<ul id="category-file-list">
    <li><a ';
        // line 2
        if (('' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' href="?cat">';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'), 'html', null, true);
        echo 'All files</a></li>
    ';
        // line 3
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aCategory']) ? $context['aCategory'] : $this->getContext($context, 'aCategory')));
        foreach ($context['_seq'] as $context['_key'] => $context['oCategory']) {
            // line 4
            echo '        <li>
            <a  ';
            // line 5
            if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method') == $this->getAttribute($context['oCategory'], 'id', array()))) {
                echo ' class="active" ';
            }
            echo '  data-cat-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '" href="?cat=';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '">
                ';
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'name', array()), 'html', null, true);
            echo '
            </a>
            <span class="actions-panel">
                 <a class="btn-rename-category" data-name="';
            // line 9
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'name', array()), 'html', null, true);
            echo '" data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '">Rename</a> 
                 <a class="btn-delete-category" data-id="';
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '"><img src="/bundles/wwscthalamus/images/remove_icon.png"></a>
            </span>
        </li>
    ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCategory'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo '    <li class="btn-add-new-categoty"><a href="#">Add new category</a></li>
</ul>    ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (69 => 14,  59 => 10,  53 => 9,  47 => 6,  37 => 5,  34 => 4,  30 => 3,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Comment\add.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="avatar-user">
    ';
        // line 2
        if ($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'avatar', array())) {
            // line 3
            echo '        ';
            $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'avatar', array()));
            // line 4
            echo '    ';
        } else {
            // line 5
            echo '        ';
            $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
            // line 6
            echo '    ';
        }
        // line 7
        echo '    <img src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 48, 1 => 48)))), 'html', null, true);
        echo '">
</div>    
<form class="form-add-comment" action="';
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_comment_add', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'type' => (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')), 'parent' => $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'id', array()))), 'html', null, true);
        echo '" method="Post">
    <div class="error"></div>
    <div class="form-group">
        <p>Leave a comment...</p>
        <div class="markdown">
        ';
        // line 14
        if (($this->getAttribute((isset($context['form']) ? $context['form'] : null), 'time_tracker', array(), 'any', true, true) && ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || $this->env->getExtension('security')->isGranted('ROLE_FREELANCER')))) {
            // line 15
            echo '            <textarea id="wwsc_thalamusbundle_comment_description" name="wwsc_thalamusbundle_comment[description]"  data-provide="markdown" rows="5"></textarea>
        ';
        } else {
            // line 17
            echo '            <textarea id="wwsc_thalamusbundle_comment_description" name="wwsc_thalamusbundle_comment[description]" required="required" data-provide="markdown" rows="5"></textarea>
        ';
        }
        // line 19
        echo '        </div>
    </div>
    ';
        // line 21
        if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || $this->env->getExtension('security')->isGranted('ROLE_FREELANCER'))) {
            echo ' 
        ';
            // line 22
            if ($this->getAttribute((isset($context['form']) ? $context['form'] : null), 'time_tracker', array(), 'any', true, true)) {
                // line 23
                echo '            <div class="form-group time-tracker-form">
                <h3> Time tracking to this comment</h3>
                ';
                // line 25
                $this->env->loadTemplate('WWSCThalamusBundle:Comment:time-tracker-form.html.twig')->display(array_merge($context, array('form' => $this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'time_tracker', array()))));
                echo '  
            </div>
        ';
            }
            // line 27
            echo ' 
    ';
        }
        // line 29
        echo '    ';
        if (('TaskItem' == (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')))) {
            // line 30
            echo '        ';
            if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
                // line 31
                echo '            <div class="col-md-12 form-group">
                ';
                // line 32
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'private', array()), 'widget');
                echo '  
                Private: (Visible only to agency companies)
            </div>   
        ';
            }
            // line 36
            echo '        <div class="col-md-12 info-panel">
            <div class="col-md-6">
                Status
                <select id="wwsc_thalamusbundle_task_item_state" name="wwsc_thalamusbundle_task_item[state]" class="form-control">
                    <option value=""> Select please ...</option>
                    ';
            // line 41
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context['aTaskItemStates']) ? $context['aTaskItemStates'] : $this->getContext($context, 'aTaskItemStates')));
            foreach ($context['_seq'] as $context['taskItemStateKey'] => $context['tasItemState']) {
                // line 42
                echo '                        <option ';
                if (($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'state', array()) == $context['taskItemStateKey'])) {
                    echo 'selected="selected" ';
                }
                echo ' value="';
                echo twig_escape_filter($this->env, $context['taskItemStateKey'], 'html', null, true);
                echo '">';
                echo twig_escape_filter($this->env, $context['tasItemState'], 'html', null, true);
                echo '</option>
                    ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['taskItemStateKey'], $context['tasItemState'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 44
            echo "                </select>
            </div>
            <div class=\"col-md-6\">
                Who's responsible?
                <select id=\"wwsc_thalamusbundle_task_item_responsible\" name=\"wwsc_thalamusbundle_task_item[responsible]\" class=\"form-control\">
                    <option value=\"";
            // line 49
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), 'html', null, true);
            echo '">Me (';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
            echo ' ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
            echo ')</option>
                    <option disabled value="">----------</option>
                    ';
            // line 51
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'task', array()), 'project', array()), 'subspeople', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oResponsibleCompany']) {
                // line 52
                echo '                        ';
                if (((('ROLE_PROVIDER' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array')) || ((1 == $this->getAttribute($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'task', array()), 'visibleClient', array())) && ('ROLE_CLIENT' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array')))) || ((1 == $this->getAttribute($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'task', array()), 'visibleFreelancer', array())) && ('ROLE_FREELANCER' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array'))))) {
                    // line 53
                    echo '                            ';
                    if ($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'any', true, true)) {
                        // line 54
                        echo '                                ';
                        if (((twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array')) > 1) || ((1 == twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))) && (false == twig_in_filter($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), twig_get_array_keys_filter($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))))))) {
                            // line 55
                            echo '                                    <option disabled value="">';
                            echo twig_escape_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'name', array(), 'array'), 'html', null, true);
                            echo '</option>
                                    ';
                            // line 56
                            $context['_parent'] = (array) $context;
                            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'));
                            foreach ($context['_seq'] as $context['key'] => $context['val']) {
                                // line 57
                                echo '                                        ';
                                if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()) != $context['key'])) {
                                    // line 58
                                    echo '                                            <option ';
                                    if (($context['key'] == $this->getAttribute($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'responsible', array()), 'id', array()))) {
                                        echo ' selected ';
                                    }
                                    echo '  value=';
                                    echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                                    echo ' >';
                                    echo twig_escape_filter($this->env, $context['val'], 'html', null, true);
                                    echo '</option>
                                        ';
                                }
                                // line 60
                                echo '                                    ';
                            }
                            $_parent = $context['_parent'];
                            unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                            $context = array_intersect_key($context, $_parent) + $_parent;
                            // line 61
                            echo '                                    <option disabled value="">----------</option>
                                ';
                        }
                        // line 63
                        echo '                            ';
                    }
                    // line 64
                    echo '                        ';
                }
                echo '    
                    ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oResponsibleCompany'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 66
            echo '                </select>
            </div>
        </div>
    ';
        }
        // line 70
        echo '    <div class="form-group">    
        ';
        // line 71
        $this->env->loadTemplate('WWSCThalamusBundle:File:attachment-form.html.twig')->display($context);
        echo '  
    </div>
    <input type="hidden" id="wwsc_thalamusbundle_comment__token" name="wwsc_thalamusbundle_comment[_token]" value="';
        // line 73
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'vars', array()), 'value', array()), 'html', null, true);
        echo '">
    ';
        // line 74
        if (('TaskItem' == (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')))) {
            // line 75
            echo '        ';
            $this->env->loadTemplate('WWSCThalamusBundle:SubscribeEmail:block-subscribed-people.html.twig')->display(array_merge($context, array('aSubsCompanies' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'task', array()), 'project', array()), 'subspeople', array()), 'activeSubscribed' => $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'activeSubscribed', array()), 'type' => 'Task', 'oParent' => $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'task', array()))));
            echo ' 
    ';
        }
        // line 77
        echo '    <div class="form-group  btn-action"> 
        <button class="btn btn-save btn-primary" type="submit">Add this Comment</button>
    </div>    
</form>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (227 => 77,  221 => 75,  219 => 74,  215 => 73,  210 => 71,  207 => 70,  201 => 66,  192 => 64,  189 => 63,  185 => 61,  179 => 60,  167 => 58,  164 => 57,  160 => 56,  155 => 55,  152 => 54,  149 => 53,  146 => 52,  142 => 51,  133 => 49,  126 => 44,  111 => 42,  107 => 41,  100 => 36,  93 => 32,  90 => 31,  87 => 30,  84 => 29,  80 => 27,  74 => 25,  70 => 23,  68 => 22,  64 => 21,  60 => 19,  56 => 17,  52 => 15,  50 => 14,  42 => 9,  36 => 7,  33 => 6,  30 => 5,  27 => 4,  24 => 3,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Comment\comment-info.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div id="c_';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'id', array()), 'html', null, true);
        echo '" data-id="comment-';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'id', array()), 'html', null, true);
        echo '" class="comment-item ';
        echo ($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'private', array())) ? ('comment-item-private') : ('');
        echo '  info-panel col-md-11">
    <div class="avatar-user">
        ';
        // line 3
        if ($this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'userCreated', array()), 'avatar', array())) {
            // line 4
            echo '            ';
            $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'userCreated', array()), 'avatar', array()));
            // line 5
            echo '        ';
        } else {
            // line 6
            echo '            ';
            $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
            // line 7
            echo '        ';
        }
        // line 8
        echo '        <img src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 48, 1 => 48)))), 'html', null, true);
        echo '">
    </div>
    <div class="comment-info">
        <div class="title">
            <span class="user-created"> ';
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo '  ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo '    </span> 
            <span class="date-created"> ';
        // line 13
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'created', array()), 'D, d M H:i a'), 'html', null, true);
        echo '  </span>
            ';
        // line 14
        if ($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'canBeEdited', array())) {
            // line 15
            echo '                | <a class="btn-edit-comment"  href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_comment_edit', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'id' => $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'id', array()))), 'html', null, true);
            echo '"> Edit </a> <small> (for another ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'canBeEdited', array()), 'html', null, true);
            echo ' ) </small>
            ';
        }
        // line 17
        echo '            ';
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo ' 
                <a class="btn-delete-comment" href="';
            // line 18
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_comment_delete', array('id' => $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'id', array()))), 'html', null, true);
            echo '">
                    <img src="';
            // line 19
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/remove_icon.png'), 'html', null, true);
            echo '">
                </a>
            ';
        }
        // line 22
        echo '        </div>
        <div class="description">
            ';
        // line 24
        echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'description', array()));
        echo '
            ';
        // line 25
        if (($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'timeTracker', array()) && ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || ($this->env->getExtension('security')->isGranted('ROLE_FREELANCER') && ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'userCreated', array()), 'company', array()), 'id', array())))))) {
            // line 26
            echo '                <div class="time-tracker-info">
                    <span  class="title"> reported: </span>
                    <span  class="desccription"> ';
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'timeTracker', array()), 'description', array()), 'html', null, true);
            echo ' </span>
                    <span class="date"> ';
            // line 29
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'timeTracker', array()), 'date', array()), 'D, d M'), 'html', null, true);
            echo '  </span>|<span class="time"> Time: ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'timeTracker', array()), 'time', array()), 'html', null, true);
            echo ' hr</span>
                </div>
            ';
        }
        // line 32
        echo '            ';
        if ($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'files', array())) {
            // line 33
            echo '                ';
            $this->env->loadTemplate('WWSCThalamusBundle:File:attachments-list.html.twig')->display(array_merge($context, array('aAttachments' => (isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'slugProject' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))));
            // line 34
            echo '            ';
        }
        echo '      
        </div>
    </div>
</div>
        ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (118 => 34,  115 => 33,  112 => 32,  104 => 29,  100 => 28,  96 => 26,  94 => 25,  90 => 24,  86 => 22,  80 => 19,  76 => 18,  71 => 17,  63 => 15,  61 => 14,  57 => 13,  51 => 12,  43 => 8,  40 => 7,  37 => 6,  34 => 5,  31 => 4,  29 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Comment\edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<script type=\"text/javascript\">
\$('.attachment-files').fileupload({
    url: \"";
        // line 3
        echo twig_escape_filter($this->env, $this->env->getExtension('oneup_uploader')->endpoint('files'), 'html', null, true);
        echo "\",
    dataType: 'json',
    downloadTemplateId: null,
    type: 'POST'
});
</script>
<form class=\"form-edit-comment\" data-id-comment=\"comment-";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'id', array()), 'html', null, true);
        echo '" action="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_comment_edit', array('id' => $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'id', array()), 'project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo '" method="Post">
    <div class="error"></div>
    <div class="form-group">
        <p>Edit this comment…</p>
        ';
        // line 13
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
        echo '
    </div>
    ';
        // line 15
        if ($this->getAttribute((isset($context['form']) ? $context['form'] : null), 'time_tracker', array(), 'any', true, true)) {
            // line 16
            echo '        <div class="form-group time-tracker-form">
            <h3> Time tracking to this comment</h3>
            ';
            // line 18
            $this->env->loadTemplate('WWSCThalamusBundle:Comment:time-tracker-form.html.twig')->display(array_merge($context, array('form' => $this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'time_tracker', array()))));
            echo '  
        </div>
    ';
        }
        // line 21
        echo '    ';
        if (('TaskItem' == $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'type', array()))) {
            // line 22
            echo '        ';
            if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
                // line 23
                echo '            <div class="col-md-12 form-group">
                ';
                // line 24
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'private', array()), 'widget');
                echo '  
                Private: (Visible only to agency companies)
            </div>   
        ';
            }
            // line 27
            echo '  
        <div class="col-md-12 info-panel">
            <div class="col-md-6">
                Status
                <select id="wwsc_thalamusbundle_task_item_state" name="wwsc_thalamusbundle_task_item[state]" class="form-control">
                    <option value=""> Select please ...</option>
                    ';
            // line 33
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context['aTaskItemStates']) ? $context['aTaskItemStates'] : $this->getContext($context, 'aTaskItemStates')));
            foreach ($context['_seq'] as $context['taskItemStateKey'] => $context['tasItemState']) {
                // line 34
                echo '                        <option ';
                if (($this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'parentInfo', array()), 'state', array()) == $context['taskItemStateKey'])) {
                    echo 'selected="selected" ';
                }
                echo ' value="';
                echo twig_escape_filter($this->env, $context['taskItemStateKey'], 'html', null, true);
                echo '">';
                echo twig_escape_filter($this->env, $context['tasItemState'], 'html', null, true);
                echo '</option>
                    ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['taskItemStateKey'], $context['tasItemState'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 36
            echo "                </select>
            </div>
            <div class=\"col-md-6\">
                Who's responsible?
                <select id=\"wwsc_thalamusbundle_task_item_responsible\" name=\"wwsc_thalamusbundle_task_item[responsible]\" class=\"form-control\">
                    <option value=\"";
            // line 41
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), 'html', null, true);
            echo '">Me (';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
            echo ' ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
            echo ')</option>
                    <option disabled value="">----------</option>
                    ';
            // line 43
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'parentInfo', array()), 'task', array()), 'project', array()), 'subspeople', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oResponsibleCompany']) {
                // line 44
                echo '                        ';
                if (((('ROLE_PROVIDER' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array')) || ((1 == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'parentInfo', array()), 'task', array()), 'visibleClient', array())) && ('ROLE_CLIENT' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array')))) || ((1 == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'parentInfo', array()), 'task', array()), 'visibleFreelancer', array())) && ('ROLE_FREELANCER' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array'))))) {
                    // line 45
                    echo '                            ';
                    if ($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'any', true, true)) {
                        // line 46
                        echo '                                ';
                        if (((twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array')) > 1) || ((1 == twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))) && (false == twig_in_filter($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), twig_get_array_keys_filter($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))))))) {
                            // line 47
                            echo '                                    <option disabled value="">';
                            echo twig_escape_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'name', array(), 'array'), 'html', null, true);
                            echo '</option>
                                    ';
                            // line 48
                            $context['_parent'] = (array) $context;
                            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'));
                            foreach ($context['_seq'] as $context['key'] => $context['val']) {
                                // line 49
                                echo '                                        ';
                                if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()) != $context['key'])) {
                                    // line 50
                                    echo '                                            <option ';
                                    if (($context['key'] == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'parentInfo', array()), 'responsible', array()), 'id', array()))) {
                                        echo ' selected ';
                                    }
                                    echo ' value=';
                                    echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                                    echo ' >';
                                    echo twig_escape_filter($this->env, $context['val'], 'html', null, true);
                                    echo '</option>
                                        ';
                                }
                                // line 52
                                echo '                                    ';
                            }
                            $_parent = $context['_parent'];
                            unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                            $context = array_intersect_key($context, $_parent) + $_parent;
                            // line 53
                            echo '                                    <option disabled value="">----------</option>
                                ';
                        }
                        // line 55
                        echo '                            ';
                    }
                    // line 56
                    echo '                        ';
                }
                // line 57
                echo '                    ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oResponsibleCompany'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 58
            echo '                </select>
            </div>
        </div>
    ';
        }
        // line 62
        echo '    <div class="form-group">
        ';
        // line 63
        $this->env->loadTemplate('WWSCThalamusBundle:File:attachment-form.html.twig')->display(array_merge($context, array('aFiles' => $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'files', array()), 'project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))));
        echo ' 
    </div>
    ';
        // line 65
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
    ';
        // line 66
        if (('TaskItem' == $this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'type', array()))) {
            // line 67
            echo '        ';
            $this->env->loadTemplate('WWSCThalamusBundle:SubscribeEmail:block-subscribed-people.html.twig')->display(array_merge($context, array('aSubsCompanies' => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'parentInfo', array()), 'task', array()), 'project', array()), 'subspeople', array()), 'activeSubscribed' => $this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'parentInfo', array()), 'activeSubscribed', array()), 'type' => 'Task', 'oParent' => $this->getAttribute($this->getAttribute((isset($context['oComment']) ? $context['oComment'] : $this->getContext($context, 'oComment')), 'parentInfo', array()), 'task', array()))));
            echo ' 
    ';
        }
        // line 69
        echo '    <div class="form-group  btn-action"> 
        <button class="btn btn-save btn-primary" type="submit">Update this Comment</button>
    </div>    
</form>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (202 => 69,  196 => 67,  194 => 66,  190 => 65,  185 => 63,  182 => 62,  176 => 58,  170 => 57,  167 => 56,  164 => 55,  160 => 53,  154 => 52,  142 => 50,  139 => 49,  135 => 48,  130 => 47,  127 => 46,  124 => 45,  121 => 44,  117 => 43,  108 => 41,  101 => 36,  86 => 34,  82 => 33,  74 => 27,  67 => 24,  64 => 23,  61 => 22,  58 => 21,  52 => 18,  48 => 16,  46 => 15,  41 => 13,  32 => 9,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Comment\list.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="col-md-12">  
    <div class="comments-list col-md-12">
        ';
        // line 3
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aComment']) ? $context['aComment'] : $this->getContext($context, 'aComment')));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oComment']) {
            // line 4
            echo '            ';
            $this->env->loadTemplate('WWSCThalamusBundle:Comment:comment-info.html.twig')->display(array_merge($context, array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'oComment' => $context['oComment'])));
            echo '  
        ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oComment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 6
        echo '    </div>
    <div class="col-md-12"> 
        <div class="form-comment col-md-11">  
            ';
        // line 9
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller('WWSCThalamusBundle:Comment:add', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'type' => (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')), 'parent' => (isset($context['parent']) ? $context['parent'] : $this->getContext($context, 'parent')))));
        echo '
        </div>
    </div>
</div>  ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (62 => 9,  57 => 6,  40 => 4,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Comment\time-tracker-form.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="col-md-12 info-panel">
    <div class=" from-group col-md-12">
        <span class="col-md-2">Description:</span>
        <div class="col-md-10"><input type="text" id="wwsc_thalamusbundle_comment_time_tracker_description" name="wwsc_thalamusbundle_comment[time_tracker][description]" required="required" class="form-control" value="';
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'vars', array()), 'value', array()), 'html', null, true);
        echo '" pattern=".{3,255}"></div>
    </div>
    <div class=" from-group col-md-12">
        <span class="col-md-2">Time:</span>
        <div class="col-md-2"><input type="text" id="wwsc_thalamusbundle_comment_time_tracker_time" name="wwsc_thalamusbundle_comment[time_tracker][time]" required="required" class="form-control" value="';
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'time', array()), 'vars', array()), 'value', array()), 'html', null, true);
        echo '" pattern="^([0-9])*([.]([0-9]){1,2}|[:](([0-5][0-9])|([6-9])))?$"></div>
        <span class="col-md-3"><small>(eg 2.5, or 2:30)</small></span>
    </div>
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (31 => 8,  24 => 4,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Company\add.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="modal-content new-company">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h1 class="form-add-company-heading">Add a new company</h1>
    </div>
    <form class="form-add-company" action="';
        // line 6
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_add_company');
        echo "\"  method=\"Post\">
        <p>After you add a company you'll be able to add people to that company.</p>
        <div class=\"form-group\">
            <label>Enter a new company name</label>
            <div class=\"col-xs-12\">
                ";
        // line 11
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'widget');
        echo '
            </div>
        </div>
        <div class="form-group">
            <label>Select the role of company</label>
            <div class="col-xs-12">
                ';
        // line 17
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'roles', array()), 'widget');
        echo '
            </div>
        </div>    
        ';
        // line 20
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
        <button class="btn btn-sm btn-primary" type="submit">Create company</button>
    </form>
</div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (49 => 20,  43 => 17,  34 => 11,  26 => 6,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Company\block_info_company.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="name">';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'name', array()), 'html', null, true);
        echo '</div>
<ul>
    ';
        // line 3
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'address1', array())) {
            // line 4
            echo '        <li>';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'address1', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 6
        echo '        ';
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'address2', array())) {
            // line 7
            echo '        <li>';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'address2', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 9
        echo '    <li>
        ';
        // line 10
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'city', array())) {
            // line 11
            echo '            ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'city', array()), 'html', null, true);
            echo ' ,
        ';
        }
        // line 13
        echo '        ';
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'state', array())) {
            // line 14
            echo '            ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'state', array()), 'html', null, true);
            echo '
        ';
        }
        // line 16
        echo '        ';
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'zip', array())) {
            // line 17
            echo '            ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'zip', array()), 'html', null, true);
            echo '
        ';
        }
        // line 19
        echo '        ';
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'country', array())) {
            // line 20
            echo '            ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'country', array()), 'html', null, true);
            echo '
        ';
        }
        // line 22
        echo '    </li>
    ';
        // line 23
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'office', array())) {
            // line 24
            echo '        <li>O: ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'office', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 26
        echo '        ';
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'fax', array())) {
            // line 27
            echo '        <li>F: ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'fax', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 29
        echo '</ul>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (100 => 29,  94 => 27,  91 => 26,  85 => 24,  83 => 23,  80 => 22,  74 => 20,  71 => 19,  65 => 17,  62 => 16,  56 => 14,  53 => 13,  47 => 11,  45 => 10,  42 => 9,  36 => 7,  33 => 6,  27 => 4,  25 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Company\edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Edit company
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading col-md-12">
                <div class="col-md-6">
                    Edit ';
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'name', array()), 'html', null, true);
        echo '
                </div> 
                ';
        // line 12
        if ((0 == $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'primaryCompany', array()))) {
            // line 13
            echo '                    <div class="col-md-6">
                        <div class="btn-delete-company  btn-right">
                            <a href="';
            // line 15
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_company_delete', array('id' => $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'id', array()))), 'html', null, true);
            echo '" class="btn btn-default btn-md">
                                <i class="glyphicon glyphicon-plus"></i> Delete company 
                            </a>
                        </div>
                    </div>        
                ';
        }
        // line 20
        echo '          
            </div>
            <div class="panel-body">
                <div class="row">
                    ';
        // line 24
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 25
        echo '                    ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 26
            echo '                        <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                    ';
        }
        // line 28
        echo '                    <div class="panel-forms">
                        <form  action="';
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_company_edit', array('id' => $this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'id', array()))), 'html', null, true);
        echo '" ';
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'enctype');
        echo " method=\"Post\">
                            <p>After you add a company you'll be able to add people to that company.</p>
                            <fieldset>
                                ";
        // line 32
        if ($this->getAttribute((isset($context['form']) ? $context['form'] : null), 'roles', array(), 'any', true, true)) {
            // line 33
            echo '                                    ';
            if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
                echo ' 
                                    <div class="form-group col-xs-12">
                                        ';
                // line 35
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'roles', array()), 'label');
                echo '
                                        <div class="col-md-4">  
                                            ';
                // line 37
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'roles', array()), 'widget');
                echo '
                                        </div>
                                    </div>
                                    ';
            }
            // line 40
            echo '      
                                ';
        }
        // line 41
        echo '        
                                <div class="form-group col-xs-12">
                                    ';
        // line 43
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'label');
        echo '
                                    <div class="col-md-4">  
                                        ';
        // line 45
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    ';
        // line 49
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'address1', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 51
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'address1', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    ';
        // line 55
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'address2', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 57
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'address2', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    ';
        // line 61
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'city', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 63
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'city', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    ';
        // line 67
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'state', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 69
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'state', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group  col-xs-12">
                                    ';
        // line 73
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'zip', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 75
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'zip', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group  col-xs-12">
                                    ';
        // line 79
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'country', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 81
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'country', array()), 'widget');
        echo '
                                    </div>
                                </div>   
                                <div class="form-group  col-xs-12">
                                    ';
        // line 85
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'language', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 87
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'language', array()), 'widget');
        echo '
                                    </div>
                                </div>   
                                <div class="form-group  col-xs-12">
                                    ';
        // line 91
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'timeZone', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 93
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'timeZone', array()), 'widget');
        echo '
                                    </div>
                                </div>   
                                <div class="form-group  col-xs-12">
                                    ';
        // line 97
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'webAddress', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 99
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'webAddress', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group  col-xs-12">
                                    ';
        // line 103
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'office', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 105
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'office', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group  col-xs-12">
                                    ';
        // line 109
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'fax', array()), 'label');
        echo '
                                    <div class="col-md-4">
                                        ';
        // line 111
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'fax', array()), 'widget');
        echo '
                                    </div>
                                </div>
                            </fieldset>    
                            <!-- <h4>Can the people in this company view Private items?</h4>
                            <p>Normally the only people who can view private messages and to-dos are people in your own company, but this setting allows you to grant people in other companies the ability to see private items. Use this option with care.</p> 
                            <fieldset>
                                <div class="form-group col-xs-12">
                                    ';
        // line 119
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'private', array()), 'widget');
        echo '
                                    <div class="col-xs-10">
                                        Yes, allow everyone in this company to view items marked Private
                                    </div>
                                </div>
                            </fieldset>    -->
                            <h4>Company logo</h4>
                            <p>Your logo appears on  the Dashboard, and Overview pages.</p>
                            <div class="form-group company-logo col-xs-12">
                                ';
        // line 128
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'logo', array()), 'widget');
        echo '
                                ';
        // line 129
        if ($this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'logo', array())) {
            // line 130
            echo '                                    <div>
                                        <img src="';
            // line 131
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(($this->env->getExtension('assets')->getAssetUrl('uploads/company/').$this->getAttribute((isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')), 'logo', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 180, 1 => 120)))), 'html', null, true);
            echo "\">
                                        <img class=\"remove_img\" data-img-id='wwsc_thalamusbundle_company_logo'  src=\"";
            // line 132
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/remove_icon.png'), 'html', null, true);
            echo '">
                                    </div>
                                ';
        }
        // line 135
        echo '                                <div class="col-md-4">
                                    ';
        // line 136
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'logoFile', array()), 'widget');
        echo '
                                </div>    
                            </div>
                            ';
        // line 139
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                            <div class="form-group col-xs-12 btn-action">
                                <button class="btn btn-sm btn-primary btn-save" type="submit">Save changes</button>
                                or <a class="btn-cancel" href="';
        // line 142
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_all_people');
        echo '"> Cancel </a> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>                          
        <div class="col-md-3 sidebar sidebar-company">
            <div class="col">
                <div class="title-panel">Original Version</div>
                <div class="info-panel">
                    ';
        // line 153
        $this->env->loadTemplate('WWSCThalamusBundle:Company:block_info_company.html.twig')->display(array_merge($context, array('company' => (isset($context['company']) ? $context['company'] : $this->getContext($context, 'company')))));
        // line 154
        echo '                </div>   
            </div>
        </div><!--/span-->
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (340 => 154,  338 => 153,  324 => 142,  318 => 139,  312 => 136,  309 => 135,  303 => 132,  299 => 131,  296 => 130,  294 => 129,  290 => 128,  278 => 119,  267 => 111,  262 => 109,  255 => 105,  250 => 103,  243 => 99,  238 => 97,  231 => 93,  226 => 91,  219 => 87,  214 => 85,  207 => 81,  202 => 79,  195 => 75,  190 => 73,  183 => 69,  178 => 67,  171 => 63,  166 => 61,  159 => 57,  154 => 55,  147 => 51,  142 => 49,  135 => 45,  130 => 43,  126 => 41,  122 => 40,  115 => 37,  110 => 35,  104 => 33,  102 => 32,  94 => 29,  91 => 28,  85 => 26,  82 => 25,  80 => 24,  74 => 20,  65 => 15,  61 => 13,  59 => 12,  54 => 10,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Content\flash_notice.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'flashbag', array()), 'peek', array(0 => 'status'), 'method') && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'flashbag', array()), 'peek', array(0 => 'notice'), 'method'))) {
            // line 2
            echo '    <div class="alert alert-';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'flashbag', array()), 'get', array(0 => 'status'), 'method'), 0, array(), 'array'), 'html', null, true);
            echo '" role="alert">
        ';
            // line 3
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'flashbag', array()), 'get', array(0 => 'notice'), 'method'), 0, array(), 'array'), 'html', null, true);
            echo '
    </div>
';
        }
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (26 => 3,  21 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Content\footer.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<footer>
    <p>&copy; wwsc 2015</p>
</footer>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function getDebugInfo()
    {
        return array (19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Content\layout.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('::base.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return '::base.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo '    <script>
        var google_client_id = "';
        // line 5
        echo twig_escape_filter($this->env, (isset($context['google_client_id']) ? $context['google_client_id'] : $this->getContext($context, 'google_client_id')), 'html', null, true);
        echo '";
        var google_client_secret = "';
        // line 6
        echo twig_escape_filter($this->env, (isset($context['google_client_secret']) ? $context['google_client_secret'] : $this->getContext($context, 'google_client_secret')), 'html', null, true);
        echo '";
        var google_api_key = "';
        // line 7
        echo twig_escape_filter($this->env, (isset($context['google_api_key']) ? $context['google_api_key'] : $this->getContext($context, 'google_api_key')), 'html', null, true);
        echo '";
    </script>
    ';
        // line 9
        $this->displayBlock('fos_user_content', $context, $blocks);
        echo '
    ';
        // line 10
        if ($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'project'), 'method')) {
            // line 11
            echo '        ';
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller('WWSCThalamusBundle:Project:header', array('project' => $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'project'), 'method'))));
            echo '
    ';
        } else {
            // line 13
            echo '        ';
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller('WWSCThalamusBundle:Account:header'));
            echo '
    ';
        }
        // line 15
        echo '    <div class="container"> 
        ';
        // line 16
        $this->displayBlock('content', $context, $blocks);
        // line 18
        echo '        ';
        $this->env->loadTemplate('WWSCThalamusBundle:Content:footer.html.twig')->display($context);
        echo '    
    </div>
';
    }

    // line 16
    public function block_content($context, array $blocks = array())
    {
        // line 17
        echo '        ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (96 => 17,  93 => 16,  85 => 18,  83 => 16,  80 => 15,  74 => 13,  68 => 11,  66 => 10,  62 => 9,  57 => 7,  53 => 6,  49 => 5,  46 => 4,  43 => 3,  38 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Content\not_permission.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('::base.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return '::base.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo '    <div class="row">
        <div class="dialog-error">
            <div>
                <h3>Thank you for visiting the Thalamus website. Access to this area is restricted.</h3>
                <p>The page you are trying to access is restricted based on specific criteria, such as role of your company.</p>
                <p>If you believe your access to this page has been denied in error, please contact support@thalamus.io. 
                    To assist us in responding to your issue, please reference the page 
                    you were attempting to view (simply copy the URL from your browser and paste it into the email) and indicate your qualification for access to the area.</p>
            </div>
        </div>
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (39 => 3,  36 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\add.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - Upload a file
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '<div class="row">
    <div class="panel panel-default col-md-9">
        <div class="panel-heading">
            Upload a file
        </div>
        <div class="panel-body">
            <div class="row ">
                <div class="col-md-12">
                    <form id="fileupload" action="';
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '" method="POST" enctype="multipart/form-data">
                        <!-- Redirect browsers with JavaScript disabled to the origin page -->
                        <div class="files col-md-12"></div>
                        <div class="col-md-12">
                            <div class="row fileupload-buttonbar">
                                <span class="fileupload-process"></span>
                               <div class="col-lg-12 fileupload-progress fade">
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                    </div>
                                    <div class="progress-extended">&nbsp;</div>
                                </div>
                                <div class="col-lg-7">
                                    <h4>Choose a file to upload</h4>
                                    <span class="btn btn-sm btn-primary fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Add files...</span>
                                        <input  type="file" name="files" multiple />
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    ';
        // line 35
        $this->env->loadTemplate('WWSCThalamusBundle:SubscribeEmail:block-notify-people.html.twig')->display(array_merge($context, array('aSubsCompanies' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'subspeople', array()))));
        // line 36
        echo '                                   <button class="btn btn-sm btn-primary start" type="submit">Upload the file</button>
                                   <span> or </span> <a class="btn-cancel" href="';
        // line 37
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_list', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '"> Cancel </a> 
                                 </div>
                            </div>
                        </div>                            
                    </form>
                </div>    
            </div>
        </div>
    </div>
</div>    
';
        // line 47
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadTemplate.html.twig')->display($context);
    }

    // line 49
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 50
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload-ui.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
';
    }

    // line 53
    public function block_javascripts($context, array $blocks = array())
    {
        // line 54
        echo '    ';
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadScript.html.twig')->display($context);
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (125 => 54,  122 => 53,  116 => 51,  111 => 50,  108 => 49,  104 => 47,  91 => 37,  88 => 36,  86 => 35,  62 => 14,  52 => 6,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\attachment-form.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="attachment-files">
    <p class="links-attachment">Attach files to this comment
        <span class="fileinput-button">select from your computer
                    <input  type="file"  name="files" multiple />
        </span> | <a class="fileinput-button-gd" href="#">upload from Google Drive</a>
    </p>
    ';
        // line 7
        if (array_key_exists('aFiles', $context)) {
            // line 8
            echo '        ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context['aFiles']) ? $context['aFiles'] : $this->getContext($context, 'aFiles')));
            foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
                echo '    
                <div class="template-upload computer-files col-md-12 ">
                      ';
                // line 10
                if (('GOOGLE_DRIVE' == $this->getAttribute($context['oFile'], 'formatFile', array()))) {
                    // line 11
                    echo '                        <img src="/bundles/wwscthalamus/images/gd-icon-min.png">
                      ';
                } else {
                    // line 13
                    echo '                          <img src="/bundles/wwscthalamus/images/attachment_icon.png">
                      ';
                }
                // line 15
                echo '                      <span> ';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                echo ' </span>
                       <a class="btn-delete-file" href=';
                // line 16
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_delete', array('project' => (isset($context['project']) ? $context['project'] : $this->getContext($context, 'project')), 'id' => $this->getAttribute($context['oFile'], 'id', array()))), 'html', null, true);
                echo '><img class="cancel" src="';
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/remove_icon.png'), 'html', null, true);
                echo '"></a>
               </div>
        ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            echo '   ';
        }
        echo ' 
    <div class="files attachment-preview"></div>
    <div class="col-md-12">
        <div class="row fileupload-buttonbar">
            <span class="fileupload-process"></span>
            <div class="col-lg-12 fileupload-progress fade">
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <div class="progress-extended">&nbsp;</div>
            </div>
            <div class="col-lg-7">
               <button style ="display:none" class="btn btn-sm btn-primary start" type="submit">Upload the file</button>
             </div>
        </div>
    </div>                            
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (63 => 19,  52 => 16,  47 => 15,  43 => 13,  39 => 11,  37 => 10,  29 => 8,  27 => 7,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\attachments-list.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if ($this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : null), 'type', array(), 'any', true, true)) {
            // line 2
            echo '   ';
            $context['entityName'] = 'Comment';
        } else {
            // line 4
            echo '    ';
            $context['entityName'] = 'Message';
        }
        // line 5
        echo '    
<div class="attachments-list">
        ';
        // line 7
        if ($this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : $this->getContext($context, 'aAttachments')), 'files', array(0 => 'IMG'), 'method')) {
            // line 8
            echo '            <div class="attachment-img col-md-12">
                ';
            // line 9
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : $this->getContext($context, 'aAttachments')), 'files', array(0 => 'IMG'), 'method'));
            foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
                // line 10
                echo '                    <a href=" ';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                echo ' "  class="fancy"><img src="';
                echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter($this->getAttribute($context['oFile'], 'fileIcon', array()), 'my_thumb', array('thumbnail' => array('size' => array(0 => 100, 1 => 100)))), 'html', null, true);
                echo '"></a>
                ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 12
            echo '            </div>
            ';
            // line 13
            if ((twig_length_filter($this->env, $this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : $this->getContext($context, 'aAttachments')), 'files', array(0 => 'IMG'), 'method')) > 1)) {
                // line 14
                echo '                <a target="_blank" href="';
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_view_all_images', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'type' => (isset($context['entityName']) ? $context['entityName'] : $this->getContext($context, 'entityName')), 'id' => $this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : $this->getContext($context, 'aAttachments')), 'id', array()))), 'html', null, true);
                echo '">
                    View all of these images at once
                </a>
            ';
            }
            // line 18
            echo '        ';
        }
        // line 19
        echo '        <div class="attachment-files col-md-12">
        ';
        // line 20
        if ($this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : $this->getContext($context, 'aAttachments')), 'files', array(0 => 'FILE'), 'method')) {
            // line 21
            echo '            ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : $this->getContext($context, 'aAttachments')), 'files', array(0 => 'FILE'), 'method'));
            foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
                // line 22
                echo '                <div><a  href="';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                echo '"><img  src="';
                echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter($this->getAttribute($context['oFile'], 'fileIcon', array()), 'my_thumb', array('thumbnail' => array('size' => array(0 => 32, 1 => 32)))), 'html', null, true);
                echo '"> ';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                echo ' <small>( ';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                echo ' Bytes )</small></a></div>
            ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 24
            echo '        ';
        }
        // line 25
        echo '        ';
        if ($this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : $this->getContext($context, 'aAttachments')), 'files', array(0 => 'GOOGLE_DRIVE'), 'method')) {
            // line 26
            echo '            ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['aAttachments']) ? $context['aAttachments'] : $this->getContext($context, 'aAttachments')), 'files', array(0 => 'GOOGLE_DRIVE'), 'method'));
            foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
                // line 27
                echo '                <div><a  target="_blank" href=" ';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                echo ' "><img  src="';
                echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter($this->getAttribute($context['oFile'], 'fileIcon', array()), 'my_thumb', array('thumbnail' => array('size' => array(0 => 32, 1 => 32)))), 'html', null, true);
                echo '"> ';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                echo '</a></div>
            ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 29
            echo '        ';
        }
        // line 30
        echo '    </div>
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (121 => 30,  118 => 29,  105 => 27,  100 => 26,  97 => 25,  94 => 24,  79 => 22,  74 => 21,  72 => 20,  69 => 19,  66 => 18,  58 => 14,  56 => 13,  53 => 12,  42 => 10,  38 => 9,  35 => 8,  33 => 7,  29 => 5,  25 => 4,  21 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<form class="edit-info-file col-md-11 info-panel" action="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_edit', array('project' => $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'id', array()))), 'html', null, true);
        echo "\" method=\"Post\">
    <div class=\"col-md-12\">
        <div class=\"col-md-2\">
            <span class=\"preview\"><img height = \"64px\" src='";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'fileIcon', array()), 'html', null, true);
        echo "'></span>
        </div>
        <div class=\"col-md-9\">
            <div class=\"col-md-12 form-group\">
                <div class=\"alert-error\"></div>
                ";
        // line 9
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'widget');
        echo '
            </div>
            <div class="col-md-12 form-group">
                <div class="col-md-3 without-padding">
                    <span> Category</span>
                </div>
                <div class="col-md-6 ">
                    ';
        // line 16
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'category', array()), 'widget');
        echo '
                </div>
            </div>
            <div class="col-md-12 form-group">
                <div class="col-md-3 without-padding">
                    <span>Optional description:</span>
                </div>
                <div class="col-md-6">
                   ';
        // line 24
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
        echo '
                </div>
            </div>
            <div class="col-md-12 form-group">
                <div class="col-md-3 without-padding">
                    <span>  Make file private</span>
                </div>
                <div class="col-md-9">
                    ';
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'private', array()), 'widget');
        echo ' 
                </div>
             </div>
            ';
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
            <div class="form-group col-xs-12 btn-action">
                <button class="btn btn-sm btn-primary btn-save" type="submit">Save changes</button>
                <span> or </span> <a class="btn-cancel" href="/account/all_people"> Cancel </a> 
            </div>
        </div>
    </div>
</form>       ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (72 => 35,  66 => 32,  55 => 24,  44 => 16,  34 => 9,  26 => 4,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\empty-files.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - Files
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '    <div class="row blank-slate">
        <div class="modal-dialog">
            <div class="col-md-4">
                <img src="';
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/blankslate-icon-files.png'), 'html', null, true);
        echo '">
            </div>
            <div class="col-md-8">
                <h1>Upload the first file to share with the team.</h1>
                <p>Upload and share files, documents, images, movies, screenshots, presentations, designs, or any other type of file. Basic version tracking is also available.</p>
                <div class="btn-add-new-task">
                    <a href="';
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '" class="btn btn-default btn-md">
                        <i class="glyphicon glyphicon-plus"></i> Upload the first file
                    </a>
                </div>
            </div>
        </div>
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (64 => 15,  55 => 9,  50 => 6,  47 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\jQUploadAttachmentScript.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <script src="';
        // line 3
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload-process.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload-image.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload-ui.js'), 'html', null, true);
        echo "\"></script>
    <script type=\"text/javascript\">
    \$('.attachment-files').fileupload({
        url: \"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('oneup_uploader')->endpoint('files'), 'html', null, true);
        echo "\",
        dataType: 'json',
        downloadTemplateId: null,
        type: 'POST'
        }).bind('fileuploadadd', function(e, data) {
            var fileType = data.files[0].name.split('.').pop().toLowerCase(), allowdTypes = '";
        // line 14
        echo twig_escape_filter($this->env, (isset($context['allowed_file_types']) ? $context['allowed_file_types'] : $this->getContext($context, 'allowed_file_types')), 'html', null, true);
        echo "';
            if (allowdTypes.indexOf(fileType) < 0) {
                alert('Type of file <\"'+data.files[0].name+'\"> is not allowed');
                return false;
            }
            var fileSize = data.files[0].size;
            if (fileSize > 100000000) {
                alert('Size of file <\"'+data.files[0].name+'\"> exceeded the limit of 100MB');
                return false;
            }
    });
    </script>    

";
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (49 => 14,  41 => 9,  35 => 6,  31 => 5,  27 => 4,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\jQUploadScript.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/vendor/jquery.ui.widget.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 2
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.iframe-transport.js'), 'html', null, true);
        echo '"></script>
    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <script src="';
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload-process.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload-image.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload-validate.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/js/jquery.fileupload-ui.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/category.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/file.js'), 'html', null, true);
        echo "\"></script>
    <script type=\"text/javascript\">
    \$(function() {
        'use strict';
        var fileCount = 0;
        \$('#fileupload').fileupload({
            url: \"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('oneup_uploader')->endpoint('files'), 'html', null, true);
        echo "\",
            dataType: 'json',
            type: 'POST'
        });
        
        \$('#fileupload').bind('fileuploadadd', function(e, data) {
            var fileType = data.files[0].name.split('.').pop().toLowerCase(), allowdTypes =  '";
        // line 23
        echo twig_escape_filter($this->env, (isset($context['allowed_file_types']) ? $context['allowed_file_types'] : $this->getContext($context, 'allowed_file_types')), 'html', null, true);
        echo "';
            if (allowdTypes.indexOf(fileType) < 0) {
                alert('Type of file <\"'+data.files[0].name+'\"> is not allowed');
                return false;
            }
            var fileSize = data.files[0].size;
            if (fileSize > 100000000) {
                alert('Size of file <\"'+data.files[0].name+'\"> exceeded the limit of 100MB');
                return false;
            }
        });
        \$('#fileupload').bind('fileuploaddone', function(e, data) {
                fileCount++;
                 \$('#fileupload').append('<input type=\"hidden\" name=aFiles[] value='+data.jqXHR.responseJSON.files[0].id+'>');
                if (fileCount === data.getNumberOfFiles()) {
                    \$('#fileupload').submit();
                }
         });

        \$('#fileupload').bind('fileuploadsubmit', function (e, data) {
           var inputs = data.context.find(':input');
           if (inputs.filter(function () {
                   return !this.value && \$(this).prop('required');
               }).first().focus().length) {
               data.context.find('button').prop('disabled', false);
               return false;
           }
           data.formData = inputs.serializeArray();
           data.formData.push({'name':'project', 'value' : ";
        // line 51
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'id', array()), 'html', null, true);
        echo "})
        });

        \$('#fileupload').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                        /\\/[^\\/]*\$/,
                        '/cors/result.html?%s'
                        )
        );
        \$(\"body\").delegate(\"#fileupload\", \"submit\", function () {
            \$('#fileupload').addClass('fileupload-processing');
            \$.ajax({
                url: \$('#fileupload').fileupload('option', 'url'),
                dataType: 'json',
                asyn:false,
                context: \$('#fileupload')[0]
            }).always(function() {
                \$(this).removeClass('fileupload-processing');
            }).done(function(result) {
                \$(this).fileupload('option', 'done').call(this, \$.Event('done'), {result: result});
            });
        });
    });
    </script>

";
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (103 => 51,  72 => 23,  63 => 17,  54 => 11,  50 => 10,  46 => 9,  42 => 8,  38 => 7,  34 => 6,  30 => 5,  24 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\jQUploadTemplate.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 20
        echo ' 
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="template-upload fade info-panel preview-upload col-md-12 ">
        <div class="col-md-2">
            <span class="preview"></span>
        </div>
        <div class="col-md-9">
            <div class="col-md-12">
                <h4>{%=file.name%}</h4>
                <strong class="error text-danger"></strong>
            </div>
            <div class="col-md-12">
                <div class="col-md-5 without-padding">
                    <div class="form-group col-md-12 without-padding">
                        <div class="col-md-3 without-padding">
                            <span>Category: </span>
                        </div>
                        <div class="col-md-9">
                        ';
        echo '
                            <select name="category-file" data-type="FILE" class="select-category">
                                <option>No category</option>
                                ';
        // line 23
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aCategoryFile']) ? $context['aCategoryFile'] : $this->getContext($context, 'aCategoryFile')));
        foreach ($context['_seq'] as $context['_key'] => $context['oCategory']) {
            // line 24
            echo '                                    <option value="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '">';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'name', array()), 'html', null, true);
            echo '</option>
                                ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCategory'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo '                                <option value="add!">— add a new category —</option>
                           </select>
                         ';
        // line 87
        echo "      
                        </div>
                    </div>    
                </div>
            </div>
            <div class=\"col-md-12\">
                <div class=\"col-md-5 without-padding\">
                    <span>Optional description:</span>
                    <div class=\"form-group\">
                        <input name=\"description\" class=\"form-control\">
                    </div>
                </div>
            </div>
            <div class=\"col-md-12\">
               <input type=\"checkbox\" name=\"private\"> <span>  Make file private</span>
            </div>
        </div>
        <div class=\"col-md-1\">
            {% if (!i) { %}
                    <img class=\"cancel\" src=\"/bundles/wwscthalamus/images/remove_icon.png\">
            {% } %}
            {% if (!i && !o.options.autoUpload) { %}
                <button class=\"btn btn-primary start\" style=\"display:none\">
                    <i class=\"glyphicon glyphicon-upload\"></i>
                    <span>Start</span>
                </button>
            {% } %}
        </div>
    </div>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id=\"template-download\" type=\"text/x-tmpl\">
{% for (var i=0, file; file=o.files[i]; i++) { %}    
      <div class=\"template-download fade info-panel preview-upload col-md-12 \">
        <div class=\"col-md-2\">
             <span class=\"preview\">
                {% if (file.thumbnailUrl) { %}
                    <a href=\"{%=file.url%}\" title=\"{%=file.name%}\" download=\"{%=file.name%}\" data-gallery><img width=\"64px\" src=\"{%=file.thumbnailUrl%}\"></a>
                {% } %}
            </span>
        </div>
        <div class=\"col-md-9\">
            <div class=\"col-md-12\">
                <p class=\"name\">
                    {% if (file.url) { %}
                        <a href=\"{%=file.url%}\" title=\"{%=file.name%}\" download=\"{%=file.name%}\" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                    {% } else { %}
                        <span>{%=file.name%}</span>
                    {% } %}
                </p>
                {% if (file.error) { %}
                    <div><span class=\"label label-danger\">Error</span> {%=file.error%}</div>
                {% } %}
            </div>
        </div>  
    </div>
{% } %}
</script>
";
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (63 => 87,  59 => 26,  48 => 24,  44 => 23,  19 => 20);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\jQUploadTemplateAttachment.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 20
        echo ' 
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="template-upload computer-files fade preview-upload col-md-12 ">
           <img src="/bundles/wwscthalamus/images/attachment_icon.png">
           <span> {%=file.name%} </span>
           <strong class="error text-danger"> </strong>
            {% if (!i) { %}
                <img class="cancel" src="/bundles/wwscthalamus/images/remove_icon.png">
            {% } %}
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" style="display:none">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
    </div>
{% } %}
</script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function getDebugInfo()
    {
        return array (19 => 20);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\list.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - Files
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading">
                Files for this project   
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="list-files">
                        ';
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aFiles']) ? $context['aFiles'] : $this->getContext($context, 'aFiles')));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
            // line 15
            echo '                            ';
            if (((($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || ('Comment' != $this->getAttribute($context['oFile'], 'type', array()))) || ('TaskItem' != $this->getAttribute($this->getAttribute($context['oFile'], 'parentInfo', array()), 'type', array()))) || (($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($context['oFile'], 'parentInfo', array()), 'parentInfo', array()), 'task', array()), 'visibleClient', array()) && $this->env->getExtension('security')->isGranted('ROLE_CLIENT')) || ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($context['oFile'], 'parentInfo', array()), 'parentInfo', array()), 'task', array()), 'visibleFreelancer', array()) && $this->env->getExtension('security')->isGranted('ROLE_FREELANCER'))))) {
                // line 20
                echo '                            ';
                if (((1 != $this->getAttribute($context['oFile'], 'private', array())) || ((1 == $this->getAttribute($context['oFile'], 'private', array())) && ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute($context['oFile'], 'userCreated', array()), 'company', array()), 'id', array()))))) {
                    // line 21
                    echo '                                <div class="file-item col-md-12">
                                    <div class="show-file">
                                        ';
                    // line 23
                    $this->env->loadTemplate('WWSCThalamusBundle:File:show.html.twig')->display(array_merge($context, array('oFile' => $context['oFile'])));
                    // line 24
                    echo '                                    </div>
                                </div>
                            ';
                }
                // line 27
                echo '                            ';
            }
            echo '  
                                ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo ' 
                                </div><!--/span-->
                            </div>
                        </div>  
                    </div>                          
                    <div class="col-md-3 sidebar sidebar-filter">
                        <div class="col">
                            <div class="btn-add-new-files">
                                <a href="';
        // line 36
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '" class="btn btn-default btn-md">
                                    <i class="glyphicon glyphicon-plus"></i> Upload a file
                                </a>
                            </div>
                            <div class="title-panel">Sort by</div>    
                            <div class="info-panel">
                                <ul>
                                    <li><input ';
        // line 43
        if ((('' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'order'), 'method')) || ('created' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'order'), 'method')))) {
            echo ' checked';
        }
        echo "  onclick=\"window.location.href = '?order=created&cat=";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'), 'html', null, true);
        echo '&user_uploaded=';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'user_uploaded'), 'method'), 'html', null, true);
        echo "'\" type=\"radio\"> Date and time</label></li>
                                    <li><input ";
        // line 44
        if (('name' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'order'), 'method'))) {
            echo ' checked ';
        }
        echo "  onclick=\"window.location.href = '?order=name&cat=";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'), 'html', null, true);
        echo '&user_uploaded=';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'user_uploaded'), 'method'), 'html', null, true);
        echo "'\" type=\"radio\"> A-Z</label></li>
                                    <li><input ";
        // line 45
        if (('file_size' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'order'), 'method'))) {
            echo ' checked ';
        }
        echo "  onclick=\"window.location.href = '?order=file_size&cat=";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'), 'html', null, true);
        echo '&user_uploaded=';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'user_uploaded'), 'method'), 'html', null, true);
        echo "'\" type=\"radio\"> File size</label></li>
                                </ul> 
                            </div>
                            <div class=\"title-panel\">Categories <a class=\"edit-cat-block\" data-cat-block=\"category-list\" href=\"#\">Edit</a></div>    
                            <div class=\"info-panel\">
                                <ul id=\"category-list\"  data-type=\"FILE\">
                                    <li><a ";
        // line 51
        if (('' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' href="?order=';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'order'), 'method'), 'html', null, true);
        echo '&user_uploaded=';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'user_uploaded'), 'method'), 'html', null, true);
        echo '">All files</a></li>
                                        ';
        // line 52
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aCategory']) ? $context['aCategory'] : $this->getContext($context, 'aCategory')));
        foreach ($context['_seq'] as $context['_key'] => $context['oCategory']) {
            // line 53
            echo '                                        <li>
                                            <a ';
            // line 54
            if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method') == $this->getAttribute($context['oCategory'], 'id', array()))) {
                echo ' class="active" ';
            }
            echo ' data-cat-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '" href="?order=';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'order'), 'method'), 'html', null, true);
            echo '&cat=';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '&user_uploaded=';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'user_uploaded'), 'method'), 'html', null, true);
            echo '">
                                                ';
            // line 55
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'name', array()), 'html', null, true);
            echo '
                                            </a>
                                            <span class="actions-panel">
                                                <a class="btn-rename-category" data-name="';
            // line 58
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'name', array()), 'html', null, true);
            echo '" data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '">Rename</a> 
                                                <a class="btn-delete-category" data-id="';
            // line 59
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '"><img src="/bundles/wwscthalamus/images/remove_icon.png"></a>
                                            </span>
                                        </li>
                                    ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCategory'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        echo '                                    <li class="btn-add-new-categoty"><a href="#">Add new category</a></li>
                                </ul>    
                            </div>
                            <div class="title-panel">Uploaded by</div>    
                            <div class="info-panel">
                                <ul>
                                    <li><a ';
        // line 69
        if (('' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'user_uploaded'), 'method'))) {
            echo ' class="active" ';
        }
        echo '  href="?order=';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'order'), 'method'), 'html', null, true);
        echo '&cat=';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'), 'html', null, true);
        echo '">Anyone</a></li>
                                        ';
        // line 70
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aUsersUpload']) ? $context['aUsersUpload'] : $this->getContext($context, 'aUsersUpload')));
        foreach ($context['_seq'] as $context['_key'] => $context['oUserUpload']) {
            // line 71
            echo '                                        <li><a ';
            if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'user_uploaded'), 'method') == $this->getAttribute($this->getAttribute($context['oUserUpload'], 'userCreated', array()), 'id', array()))) {
                echo ' class="active" ';
            }
            echo '  href="?order=';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'order'), 'method'), 'html', null, true);
            echo '&cat=';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'), 'html', null, true);
            echo '&user_uploaded=';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context['oUserUpload'], 'userCreated', array()), 'id', array()), 'html', null, true);
            echo '">';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context['oUserUpload'], 'userCreated', array()), 'firstName', array()), 'html', null, true);
            echo ' ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context['oUserUpload'], 'userCreated', array()), 'lastName', array()), 'html', null, true);
            echo '</a></li>
                                        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oUserUpload'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 73
        echo '                                </ul>   
                            </div>
                        </div>
                    </div><!--/span-->
                </div>
                ';
    }

    // line 79
    public function block_javascripts($context, array $blocks = array())
    {
        // line 80
        echo '                        <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/category.js'), 'html', null, true);
        echo '"></script>
                        <script src="';
        // line 81
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/file.js'), 'html', null, true);
        echo '"></script>
                    ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (280 => 81,  275 => 80,  272 => 79,  263 => 73,  242 => 71,  238 => 70,  228 => 69,  220 => 63,  210 => 59,  204 => 58,  198 => 55,  184 => 54,  181 => 53,  177 => 52,  167 => 51,  152 => 45,  142 => 44,  132 => 43,  122 => 36,  112 => 28,  95 => 27,  90 => 24,  88 => 23,  84 => 21,  81 => 20,  78 => 15,  61 => 14,  48 => 5,  41 => 3,  38 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\show.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="actions-panel">
    <a class="btn-delete-file" href=';
        // line 2
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_delete', array('project' => $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'id', array()))), 'html', null, true);
        echo '><img src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/remove_icon.png'), 'html', null, true);
        echo '"></a>
    <a class="btn-edit-file" href=';
        // line 3
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_edit', array('project' => $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'id', array()))), 'html', null, true);
        echo '>Edit</a>
</div>
<div class="file-icon col-md-1">
    ';
        // line 6
        if (('IMG' == $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'formatFile', array()))) {
            // line 7
            echo '            <a href=" ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'fileSrc', array()), 'html', null, true);
            echo ' "  class="fancy"><img src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'fileIcon', array()), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 52)))), 'html', null, true);
            echo '"></a>
    ';
        } else {
            // line 9
            echo '        <a href="';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'fileSrc', array()), 'html', null, true);
            echo '">
            <img src="';
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'fileIcon', array()), 'html', null, true);
            echo '">
        </a>
    ';
        }
        // line 12
        echo ' 
</div>
<div class="file-info col-md-11">
    <div class="title">
        <a href="#">
            ';
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'name', array()), 'html', null, true);
        echo '
        </a>
        ';
        // line 19
        if ($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'private', array())) {
            echo ' 
            <span class="private"> private </span>
        ';
        }
        // line 22
        echo '    </div>
    ';
        // line 23
        if ($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array())) {
            echo ' 
        <div class="file-parent-info">
          ';
            // line 25
            if (('Message' == $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'type', array()))) {
                echo ' 
                <a href="';
                // line 26
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'id', array()))), 'html', null, true);
                echo '">';
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'title', array()), 'html', null, true);
                echo '</a>
          ';
            } elseif (('Comment' == $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'type', array()))) {
                // line 28
                echo '                ';
                if (('Message' == $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'type', array()))) {
                    // line 29
                    echo '                    <a href="';
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'parentInfo', array()), 'id', array()))), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'parentInfo', array()), 'description', array()), 'html', null, true);
                    echo '</a>
                ';
                } else {
                    // line 31
                    echo '                    <a href="';
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'parentInfo', array()), 'task', array()), 'id', array()), 'id' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'parentInfo', array()), 'id', array()))), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'parentInfo', array()), 'description', array()), 'html', null, true);
                    echo '</a>
                ';
                }
                // line 33
                echo '          ';
            }
            // line 34
            echo '          <span class="dash">—</span>
            ';
            // line 35
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'parentInfo', array()), 'description', array()), 'html', null, true);
            echo '
        </div>
    ';
        }
        // line 38
        echo '    ';
        if ($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'description', array())) {
            echo ' 
        <div class="description">
            ';
            // line 40
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'description', array()), 'html', null, true);
            echo '
        </div>
    ';
        }
        // line 43
        echo '    <div class="author">
             by ';
        // line 44
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo ' 
              ';
        // line 45
        if ($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'category', array())) {
            echo ' 
                    in <a href="#">';
            // line 46
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'category', array()), 'name', array()), 'html', null, true);
            echo '</a>
              ';
        }
        // line 48
        echo '            on ';
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'created', array()), 'd M'), 'html', null, true);
        echo ', ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oFile']) ? $context['oFile'] : $this->getContext($context, 'oFile')), 'fileSize', array()), 'html', null, true);
        echo ' KB
    </div>
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (153 => 48,  148 => 46,  144 => 45,  138 => 44,  135 => 43,  129 => 40,  123 => 38,  117 => 35,  114 => 34,  111 => 33,  103 => 31,  95 => 29,  92 => 28,  85 => 26,  81 => 25,  76 => 23,  73 => 22,  67 => 19,  62 => 17,  55 => 12,  49 => 10,  44 => 9,  36 => 7,  34 => 6,  28 => 3,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\File\view-all-images.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('::base.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return '::base.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aImages']) ? $context['aImages'] : $this->getContext($context, 'aImages')));
        foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
            // line 4
            echo '        <div class="comment_image_wrapper">
            <div class="comment_image">
                <img src="';
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileIcon', array()), 'html', null, true);
            echo '">
            </div>
            <div class="comment_image_name">
                ';
            // line 9
            echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
            echo '
            </div>
        </div>
    ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (54 => 9,  48 => 6,  44 => 4,  39 => 3,  36 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\layout.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('::base.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return '::base.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        $this->displayBlock('fos_user_content', $context, $blocks);
        echo '
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (39 => 3,  36 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Mail\add_user_to_account.txt.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<h2>';
        echo twig_escape_filter($this->env, (isset($context['company_name']) ? $context['company_name'] : $this->getContext($context, 'company_name')), 'html', null, true);
        echo '</h2>
<h3>Hi ';
        // line 2
        echo twig_escape_filter($this->env, (isset($context['first_name']) ? $context['first_name'] : $this->getContext($context, 'first_name')), 'html', null, true);
        echo '.</h3>
<p>
    ';
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'lastName', array()), 'html', null, true);
        echo ' has invited you to join Thalamus for ';
        echo twig_escape_filter($this->env, (isset($context['company_name']) ? $context['company_name'] : $this->getContext($context, 'company_name')), 'html', null, true);
        echo ' at our online collaboration tool.
</p>
<p>
    Accept invitation : <a href="';
        // line 7
        echo twig_escape_filter($this->env, (isset($context['urlAcceptInvitation']) ? $context['urlAcceptInvitation'] : $this->getContext($context, 'urlAcceptInvitation')), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, (isset($context['urlAcceptInvitation']) ? $context['urlAcceptInvitation'] : $this->getContext($context, 'urlAcceptInvitation')), 'html', null, true);
        echo '</a>
    <br>
    Reject invitation : <a href="';
        // line 9
        echo twig_escape_filter($this->env, (isset($context['urlRejectInvitation']) ? $context['urlRejectInvitation'] : $this->getContext($context, 'urlRejectInvitation')), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, (isset($context['urlRejectInvitation']) ? $context['urlRejectInvitation'] : $this->getContext($context, 'urlRejectInvitation')), 'html', null, true);
        echo '</a>
<p>
<hr>
<p>    
    Have questions? Contact ';
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'lastName', array()), 'html', null, true);
        echo ' at ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'email', array()), 'html', null, true);
        echo '
</p>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (55 => 13,  46 => 9,  39 => 7,  29 => 4,  24 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Mail\create_user.txt.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<h2>';
        echo twig_escape_filter($this->env, (isset($context['company_name']) ? $context['company_name'] : $this->getContext($context, 'company_name')), 'html', null, true);
        echo "</h2>
<p> You're invited to join Thalamus, our project management and collaboration system. </p>
<h3>Hi ";
        // line 3
        echo twig_escape_filter($this->env, (isset($context['first_name']) ? $context['first_name'] : $this->getContext($context, 'first_name')), 'html', null, true);
        echo '.</h3>
<p>
    ';
        // line 5
        echo twig_escape_filter($this->env, (isset($context['profile_description']) ? $context['profile_description'] : $this->getContext($context, 'profile_description')), 'html', null, true);
        echo '
</p>
<p>
    ';
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'lastName', array()), 'html', null, true);
        echo ' just set up an account for you. All you need to do is choose a username and password. It only takes a few seconds.<br>
    Click this link to get started:<br>
    <a href="';
        // line 10
        echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
        echo '</a>
<p>
<hr>
<p>    
    Have questions? Contact ';
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'lastName', array()), 'html', null, true);
        echo ' at ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['created_user']) ? $context['created_user'] : $this->getContext($context, 'created_user')), 'email', array()), 'html', null, true);
        echo '
</p>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (52 => 14,  43 => 10,  36 => 8,  30 => 5,  25 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Mail\registr_email.txt.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<h2>Welcome to Thalamus</h2>
<p>
    Hi ';
        // line 3
        echo twig_escape_filter($this->env, (isset($context['first_name']) ? $context['first_name'] : $this->getContext($context, 'first_name')), 'html', null, true);
        echo '.
</p>
<p>
    Important account information from thalamus.io:<br>
    <br>
    <b>Sign in to your account:</b><br>
    <a href="';
        // line 9
        echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
        echo '</a>
    <br>Username: <b>';
        // line 10
        echo twig_escape_filter($this->env, (isset($context['username']) ? $context['username'] : $this->getContext($context, 'username')), 'html', null, true);
        echo '</b>
<p>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (38 => 10,  32 => 9,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Mail\subscribe_change_message.txt.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<html>
<head>
  <style type="text/css">
    ol, ul { padding: 0; }
    li { margin-left: 30px; line-height: 1.425em; padding: 0; }
    ul li { list-style-type: square; }
  </style>
</head>
<body bgcolor="#ffffff" color="#333333" link="#0099cc" alink="#0099cc" vlink="#0099cc" style="background-color: #ffffff; text-align: left;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td style="padding: 10px 10px 10px 20px; text-align: left;">
      <p style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #999; padding-bottom: 0;">
        Reply ABOVE THIS LINE to add a comment to this message
      </p>
    </td>
  </tr>
  <tr>
    <td style="padding: 10px 20px 5px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; background-color: #ffffff; text-align: left; border-bottom: 1px solid #dddddd;" colspan="2">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Project:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; font-weight: normal; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top"><a href="';
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_overview', array('project' => $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'project', array()), 'slug', array()))), 'html', null, true);
        echo '">
                ';
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'project', array()), 'name', array()), 'html', null, true);
        echo '
            </a></td>
        </tr>
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Company:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; color: #000000; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top">';
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'project', array()), 'responsibleCompany', array()), 'name', array()), 'html', null, true);
        echo '</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td style="padding-top: 0; padding-bottom: 20px; text-align: left;">
        <table cellpadding="0" cellspacing="0" border="0" align="left">
          <tr>
            <td style="padding: 0 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; background-color: #ffffff; text-align: left;">
              <div style="padding: 10px 0 20px 0;">
                <table cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="57" valign="top">
                        ';
        // line 43
        if ($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'avatar', array())) {
            // line 44
            echo '                            <img class="avatar"  style="border: 1px solid #cccccc; padding: 1px;"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(('/uploads/user/'.$this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'avatar', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                        ';
        } else {
            // line 46
            echo '                            <img class="avatar"  style="border: 1px solid #cccccc; padding: 1px;"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter('/bundles/wwscthalamus/images/user_icon.png', 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                        ';
        }
        // line 48
        echo '                    </td>
                    <td style="padding-left: 15px; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" valign="top">
                      <h1 style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; margin: 0 0 15px 0; font-weight: normal; line-height: 1.3em;">
                          ';
        // line 51
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo '  ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo ' edited an existing message:
                        <span style="font-weight: bold;"><a href="';
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'id', array()))), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'title', array()), 'html', null, true);
        echo '</a></span>
                      </h1>
                      <div style="line-height: 1.3em;">
                        <div>';
        // line 55
        echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'description', array()));
        echo '</div>

                      </div>
                      <div style="padding-top: 10px;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            ';
        // line 60
        if ($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'files', array())) {
            // line 61
            echo '                                ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'files', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
                // line 62
                echo '                                        ';
                if (('GOOGLE_DRIVE' == $this->getAttribute($context['oFile'], 'formatFile', array()))) {
                    // line 63
                    echo '                                            <tr>
                                              <td width="32">
                                                <a href="';
                    // line 65
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                    echo '"><img alt="';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '" border="0" class="file_icon" height="32" src="';
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileIcon', array())), 'html', null, true);
                    echo '" width="32" /></a>
                                              </td>
                                              <td style="font-size: 13px; padding: 3px 0 0 5px; color: #777777; line-height: 1.4em;">
                                                <a href="';
                    // line 68
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '</a><br />
                                                  <span style="font-size: 10px;">';
                    // line 69
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                    echo '</span>
                                              </td>
                                            </tr>  
                                        ';
                } else {
                    // line 73
                    echo '                                            <tr>
                                              <td width="32">
                                                <a href="';
                    // line 75
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
                    echo '"><img alt="';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '" border="0" class="file_icon" height="32" src="';
                    echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())), 'html', null, true);
                    echo '/bundles/wwscthalamus/images/icon_file.png" width="32" /></a>
                                              </td>
                                              <td style="font-size: 13px; padding: 3px 0 0 5px; color: #777777; line-height: 1.4em;">
                                                <a href="';
                    // line 78
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '</a><br />
                                                  <span style="font-size: 10px;">';
                    // line 79
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                    echo '</span>
                                              </td>
                                            </tr>                                          
                                        ';
                }
                // line 82
                echo '                   
                                ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 84
            echo '                            ';
        }
        // line 85
        echo '                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 10px 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 12px; background-color: #ffffff; text-align: left; border-top: 1px solid #dddddd;">
        <p style="margin: 0; color: #444444">This message was sent to 
            ';
        // line 99
        $context['i_user'] = 1;
        // line 100
        echo '            ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers')));
        foreach ($context['_seq'] as $context['_key'] => $context['nameUser']) {
            // line 101
            echo '                ';
            if ((twig_length_filter($this->env, (isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers'))) == (isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')))) {
                // line 102
                echo '                    ';
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' .
                ';
            } else {
                // line 103
                echo ' 
                    ';
                // line 104
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' ,
                ';
            }
            // line 105
            echo '    
            ';
            // line 106
            $context['i_user'] = ((isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')) + 1);
            // line 107
            echo '            ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['nameUser'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 108
        echo '        </p>
      </td>
    </tr>
</table>
</body>
</html>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (238 => 108,  232 => 107,  230 => 106,  227 => 105,  222 => 104,  219 => 103,  213 => 102,  210 => 101,  205 => 100,  203 => 99,  187 => 85,  184 => 84,  177 => 82,  170 => 79,  164 => 78,  154 => 75,  150 => 73,  143 => 69,  137 => 68,  127 => 65,  123 => 63,  120 => 62,  115 => 61,  113 => 60,  105 => 55,  97 => 52,  91 => 51,  86 => 48,  80 => 46,  74 => 44,  72 => 43,  55 => 29,  47 => 24,  43 => 23,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Mail\subscribe_comment_to_message.txt.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<html>
<head>
  <style type="text/css">
    ol, ul { padding: 0; }
    li { margin-left: 30px; line-height: 1.425em; padding: 0; }
    ul li { list-style-type: square; }
  </style>
</head>
<body bgcolor="#ffffff" color="#333333" link="#0099cc" alink="#0099cc" vlink="#0099cc" style="background-color: #ffffff; text-align: left;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td style="padding: 10px 10px 10px 20px; text-align: left;">
      <p style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #999; padding-bottom: 0;">
        Reply ABOVE THIS LINE to add a comment to this message
      </p>
    </td>
  </tr>
  <tr>
    <td style="padding: 10px 20px 5px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; background-color: #ffffff; text-align: left; border-bottom: 1px solid #dddddd;" colspan="2">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Project:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; font-weight: normal; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top"><a href="';
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_overview', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'project', array()), 'slug', array()))), 'html', null, true);
        echo '">
                ';
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'project', array()), 'name', array()), 'html', null, true);
        echo '
            </a></td>
        </tr>
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Company:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; color: #000000; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top">';
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'project', array()), 'responsibleCompany', array()), 'name', array()), 'html', null, true);
        echo '</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td style="padding-top: 0; padding-bottom: 20px; text-align: left;">
        <table cellpadding="0" cellspacing="0" border="0" align="left">
          <tr>
            <td style="padding: 0 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; background-color: #ffffff; text-align: left;">
              <div style="padding: 10px 0 20px 0;">
                <table cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="57" valign="top">
                        ';
        // line 43
        if ($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'avatar', array())) {
            // line 44
            echo '                            <img class="avatar"  style="border: 1px solid #cccccc; padding: 1px;"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(('/uploads/user/'.$this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'avatar', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                        ';
        } else {
            // line 46
            echo '                            <img class="avatar"  style="border: 1px solid #cccccc; padding: 1px;"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter('/bundles/wwscthalamus/images/user_icon.png', 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                        ';
        }
        // line 48
        echo '                    </td>
                    <td style="padding-left: 15px; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" valign="top">
                      <h1 style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; margin: 0 0 15px 0; font-weight: normal; line-height: 1.3em;">
                          ';
        // line 51
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo '  ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo ' commented on the message:<br />
                        <span style="font-weight: bold;"><a href="';
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'project', array()), 'slug', array()), 'id' => $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'id', array()))), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'title', array()), 'html', null, true);
        echo '</a></span>
                      </h1>
                      <div style="line-height: 1.3em;">
                        <div>';
        // line 55
        echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'description', array()));
        echo '</div>

                      </div>
                      <div style="padding-top: 10px;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            ';
        // line 60
        if ($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'files', array())) {
            // line 61
            echo '                                ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'files', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
                // line 62
                echo '                                        ';
                if (('GOOGLE_DRIVE' == $this->getAttribute($context['oFile'], 'formatFile', array()))) {
                    // line 63
                    echo '                                            <tr>
                                              <td width="32">
                                                <a href="';
                    // line 65
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                    echo '">
                                                    <img alt="';
                    // line 66
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '" border="0" class="file_icon" height="32" src="';
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileIcon', array())), 'html', null, true);
                    echo '" width="32" />
                                                </a>
                                              </td>
                                              <td style="font-size: 13px; padding: 3px 0 0 5px; color: #777777; line-height: 1.4em;">
                                                <a href="';
                    // line 70
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '</a><br />
                                                  <span style="font-size: 10px;">';
                    // line 71
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                    echo '</span>
                                              </td>
                                            </tr>  
                                        ';
                } else {
                    // line 75
                    echo '                                            <tr>
                                              <td width="32">
                                                <a href="';
                    // line 77
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
                    echo '">
                                                    <img alt="';
                    // line 78
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '" border="0" class="file_icon" height="32" src="';
                    echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())), 'html', null, true);
                    echo '/bundles/wwscthalamus/images/icon_file.png" width="32" />
                                                </a>
                                              </td>
                                              <td style="font-size: 13px; padding: 3px 0 0 5px; color: #777777; line-height: 1.4em;">
                                                <a href="';
                    // line 82
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '</a><br />
                                                  <span style="font-size: 10px;">';
                    // line 83
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                    echo '</span>
                                              </td>
                                            </tr>                                          
                                        ';
                }
                // line 86
                echo '                   
                                ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 88
            echo '                            ';
        }
        // line 89
        echo '                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 10px 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 12px; background-color: #ffffff; text-align: left; border-top: 1px solid #dddddd;">
        <p style="margin: 0; color: #444444">This comment was sent to 
            ';
        // line 103
        $context['i_user'] = 1;
        // line 104
        echo '            ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers')));
        foreach ($context['_seq'] as $context['_key'] => $context['nameUser']) {
            // line 105
            echo '                ';
            if ((twig_length_filter($this->env, (isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers'))) == (isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')))) {
                // line 106
                echo '                    ';
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' .
                ';
            } else {
                // line 107
                echo ' 
                    ';
                // line 108
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' ,
                ';
            }
            // line 109
            echo '    
            ';
            // line 110
            $context['i_user'] = ((isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')) + 1);
            // line 111
            echo '            ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['nameUser'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 112
        echo '        </p>
      </td>
    </tr>
</table>
</body>
</html>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (244 => 112,  238 => 111,  236 => 110,  233 => 109,  228 => 108,  225 => 107,  219 => 106,  216 => 105,  211 => 104,  209 => 103,  193 => 89,  190 => 88,  183 => 86,  176 => 83,  170 => 82,  161 => 78,  157 => 77,  153 => 75,  146 => 71,  140 => 70,  131 => 66,  127 => 65,  123 => 63,  120 => 62,  115 => 61,  113 => 60,  105 => 55,  97 => 52,  91 => 51,  86 => 48,  80 => 46,  74 => 44,  72 => 43,  55 => 29,  47 => 24,  43 => 23,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Mail\subscribe_comment_to_task.txt.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<html>
<head>
  <style type="text/css">
    ol, ul { padding: 0; }
    li { margin-left: 30px; line-height: 1.425em; padding: 0; }
    ul li { list-style-type: square; }
  </style>
</head>
<body bgcolor="#ffffff" color="#333333" link="#0099cc" alink="#0099cc" vlink="#0099cc" style="background-color: #ffffff; text-align: left;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td style="padding: 10px 10px 10px 20px; text-align: left;">
      <p style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #999; padding-bottom: 0;">
        Reply ABOVE THIS LINE to add a comment to this message
      </p>
    </td>
  </tr>
  <tr>
    <td style="padding: 10px 20px 5px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; background-color: #ffffff; text-align: left; border-bottom: 1px solid #dddddd;" colspan="2">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Project:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; font-weight: normal; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top"><a href="';
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_overview', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'task', array()), 'project', array()), 'slug', array()))), 'html', null, true);
        echo '">
                ';
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'task', array()), 'project', array()), 'name', array()), 'html', null, true);
        echo '
            </a></td>
        </tr>
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Company:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; color: #000000; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top">';
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'task', array()), 'project', array()), 'responsibleCompany', array()), 'name', array()), 'html', null, true);
        echo '</td>
        </tr>
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="75" valign="top">To-Do List:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; color: #000000; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top"><a href="';
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_task_show', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'task', array()), 'project', array()), 'slug', array()), 'id' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'task', array()), 'id', array()))), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'task', array()), 'name', array()), 'html', null, true);
        echo '</a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td style="padding-top: 0; padding-bottom: 20px; text-align: left;">
        <table cellpadding="0" cellspacing="0" border="0" align="left">
          <tr>
            <td style="padding: 0 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; background-color: #ffffff; text-align: left;">
              <div style="padding: 10px 0 20px 0;">
                <table cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="57" valign="top">
                        ';
        // line 47
        if ($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'avatar', array())) {
            // line 48
            echo '                            <img class="avatar"  style="border: 1px solid #cccccc; padding: 1px;"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(('/uploads/user/'.$this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'avatar', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                        ';
        } else {
            // line 50
            echo '                            <img class="avatar"  style="border: 1px solid #cccccc; padding: 1px;"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter('/bundles/wwscthalamus/images/user_icon.png', 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                        ';
        }
        // line 52
        echo '                    </td>
                    <td style="padding-left: 15px; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" valign="top">
                      <h1 style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; margin: 0 0 15px 0; font-weight: normal; line-height: 1.3em;">
                          ';
        // line 55
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo '  ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo ' commented on the item task:<br />
                        <span style="font-weight: bold;"><a href="';
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_task_item_comments', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'task', array()), 'id', array()), 'id' => $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'id', array()))), 'html', null, true);
        echo '">';
        echo ($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'fastTrack', array())) ? ('[FAST-TRACK]') : ('');
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'parentInfo', array()), 'description', array()), 'html', null, true);
        echo '</a></span>
                      </h1>
                      <div style="line-height: 1.3em;">
                        <div>';
        // line 59
        echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'description', array()));
        echo '</div>

                      </div>
                      <div style="padding-top: 10px;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            ';
        // line 64
        if ($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'files', array())) {
            // line 65
            echo '                                ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'files', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
                // line 66
                echo '                                        ';
                if (('GOOGLE_DRIVE' == $this->getAttribute($context['oFile'], 'formatFile', array()))) {
                    // line 67
                    echo '                                            <tr>
                                              <td width="32">
                                                <a href="';
                    // line 69
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                    echo '">
                                                    <img alt="';
                    // line 70
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '" border="0" class="file_icon" height="32" src="';
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileIcon', array())), 'html', null, true);
                    echo '" width="32" />
                                                </a>
                                              </td>
                                              <td style="font-size: 13px; padding: 3px 0 0 5px; color: #777777; line-height: 1.4em;">
                                                <a href="';
                    // line 74
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '</a><br />
                                                  <span style="font-size: 10px;">';
                    // line 75
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                    echo '</span>
                                              </td>
                                            </tr>  
                                        ';
                } else {
                    // line 79
                    echo '                                            <tr>
                                              <td width="32">
                                                <a href="';
                    // line 81
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
                    echo '">
                                                    <img alt="';
                    // line 82
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '" border="0" class="file_icon" height="32" src="';
                    echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())), 'html', null, true);
                    echo '/bundles/wwscthalamus/images/icon_file.png" width="32" />
                                                </a>
                                              </td>
                                              <td style="font-size: 13px; padding: 3px 0 0 5px; color: #777777; line-height: 1.4em;">
                                                <a href="';
                    // line 86
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '</a><br />
                                                  <span style="font-size: 10px;">';
                    // line 87
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                    echo '</span>
                                              </td>
                                            </tr>                                          
                                        ';
                }
                // line 90
                echo '                   
                                ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 92
            echo '                            ';
        }
        // line 93
        echo '                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 10px 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 12px; background-color: #ffffff; text-align: left; border-top: 1px solid #dddddd;">
        <p style="margin: 0; color: #444444">This comment was sent to 
            ';
        // line 107
        $context['i_user'] = 1;
        // line 108
        echo '            ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers')));
        foreach ($context['_seq'] as $context['_key'] => $context['nameUser']) {
            // line 109
            echo '                ';
            if ((twig_length_filter($this->env, (isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers'))) == (isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')))) {
                // line 110
                echo '                    ';
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' .
                ';
            } else {
                // line 111
                echo ' 
                    ';
                // line 112
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' ,
                ';
            }
            // line 113
            echo '    
            ';
            // line 114
            $context['i_user'] = ((isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')) + 1);
            // line 115
            echo '            ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['nameUser'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 116
        echo '        </p>
      </td>
    </tr>
</table>
</body>
</html>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (255 => 116,  249 => 115,  247 => 114,  244 => 113,  239 => 112,  236 => 111,  230 => 110,  227 => 109,  222 => 108,  220 => 107,  204 => 93,  201 => 92,  194 => 90,  187 => 87,  181 => 86,  172 => 82,  168 => 81,  164 => 79,  157 => 75,  151 => 74,  142 => 70,  138 => 69,  134 => 67,  131 => 66,  126 => 65,  124 => 64,  116 => 59,  106 => 56,  100 => 55,  95 => 52,  89 => 50,  83 => 48,  81 => 47,  62 => 33,  55 => 29,  47 => 24,  43 => 23,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Mail\subscribe_files.txt.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<html>
<head></head>
<body bgcolor="#ffffff" link="#0099cc" alink="#0099cc" vlink="#0099cc" style="background-color: #ffffff; text-align: left;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td style="padding: 10px 20px 5px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: #ffffff; text-align: left; border-bottom: 1px solid #dddddd;">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Project:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; font-weight: normal; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top"><a href="';
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_overview', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">
                ';
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo '
            </a></td>
        </tr>
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Company:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; color: #000000; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top">';
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'responsibleCompany', array()), 'name', array()), 'html', null, true);
        echo '</td>
        </tr>
      </table>
    </td>
  </tr>     
  <tr>
    <td style="padding-top: 0; padding-bottom: 20px; text-align: left;">
        <table width="640" cellpadding="0" cellspacing="0" border="0" align="left">
          <tr>
            <td style="background-color: #ffffff; text-align: left; padding: 0;">

              <h1 style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; margin: 20px 20px 5px 20px; color: #000000;">
                ';
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
        echo ' uploaded these new files:
              </h1>
                ';
        // line 30
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aElements']) ? $context['aElements'] : $this->getContext($context, 'aElements')));
        foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
            echo '       
                    <div style="padding: 10px;">
                      <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                          <td valign="top" width="70">
                               <a href="';
            // line 35
            echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
            echo '"><img alt="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
            echo '" border="0" class="file_icon" height="32" src="';
            echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileIcon', array())), 'html', null, true);
            echo '" width="32" /></a>
                          </td>
                          <td style="text-align: left; font-family: Helvetica, Arial, sans-serif; padding-left: 5px;">
                            <h2 style="margin: 5px 0 2px 0; font-size: 18px; font-weight: bold; color: #000000;">
                              <a href="';
            // line 39
            echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
            echo '" style="color: #000000; text-decoration: none;">';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
            echo '</a>
                            </h2>
                            <p style="margin: 5px 0; font-size: 14px;">
                            <b><a href="';
            // line 42
            echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
            echo '">Download this file</a></b> 
                                <span style="color: #999999; font-weight: normal; font-size: 12px;">';
            // line 43
            echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
            echo '</span>
                            </p>
                          </td>
                        </tr>
                      </table>
                    </div>
                ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 50
        echo '              <p style="font-family: Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; margin: 20px 20px 5px 20px;">
                <a href="';
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_file_list', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">View all files for this project</a>
              </p>
            </td>
          </tr>
        </table>

    </td>
  </tr>
  <tr>
    <table cellpadding="0" cellspacing="0" border="0" align="left" width="100%">
        <tr>
          <td style="padding: 10px 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 12px; background-color: #ffffff; text-align: left; border-top: 1px solid #dddddd;">
            <p style="margin: 0; color: #444444">This message was sent to 
                ';
        // line 64
        $context['i_user'] = 1;
        // line 65
        echo '                ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers')));
        foreach ($context['_seq'] as $context['_key'] => $context['nameUser']) {
            // line 66
            echo '                    ';
            if ((twig_length_filter($this->env, (isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers'))) == (isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')))) {
                // line 67
                echo '                        ';
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' .
                    ';
            } else {
                // line 68
                echo ' 
                        ';
                // line 69
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' ,
                    ';
            }
            // line 70
            echo '    
                ';
            // line 71
            $context['i_user'] = ((isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')) + 1);
            // line 72
            echo '                ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['nameUser'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 73
        echo '            </p>
          </td>
        </tr>
    </table>
  </tr>
</table>
</body>
</html>


';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (164 => 73,  158 => 72,  156 => 71,  153 => 70,  148 => 69,  145 => 68,  139 => 67,  136 => 66,  131 => 65,  129 => 64,  113 => 51,  110 => 50,  97 => 43,  93 => 42,  85 => 39,  74 => 35,  64 => 30,  57 => 28,  42 => 16,  34 => 11,  30 => 10,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Mail\subscribe_message.txt.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<html>
<head>
  <style type="text/css">
    ol, ul { padding: 0; }
    li { margin-left: 30px; line-height: 1.425em; padding: 0; }
    ul li { list-style-type: square; }
  </style>
</head>
<body bgcolor="#ffffff" color="#333333" link="#0099cc" alink="#0099cc" vlink="#0099cc" style="background-color: #ffffff; text-align: left;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td style="padding: 10px 10px 10px 20px; text-align: left;">
      <p style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #999; padding-bottom: 0;">
        Reply ABOVE THIS LINE to add a comment to this message
      </p>
    </td>
  </tr>
  <tr>
    <td style="padding: 10px 20px 5px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; background-color: #ffffff; text-align: left; border-bottom: 1px solid #dddddd;" colspan="2">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Project:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; font-weight: normal; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top"><a href="';
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_overview', array('project' => $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'project', array()), 'slug', array()))), 'html', null, true);
        echo '">
                ';
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'project', array()), 'name', array()), 'html', null, true);
        echo '
            </a></td>
        </tr>
        <tr>
          <td style="padding: 0 0 5px 0; font-weight: normal; color: #999999; text-align: left; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" width="50" valign="top">Company:</td>
          <td style="padding: 0 0 5px 10px; font-size: 14px; color: #000000; text-align: left; font-family: Helvetica, Arial, sans-serif;" valign="top">';
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'project', array()), 'responsibleCompany', array()), 'name', array()), 'html', null, true);
        echo '</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td style="padding-top: 0; padding-bottom: 20px; text-align: left;">
        <table cellpadding="0" cellspacing="0" border="0" align="left">
          <tr>
            <td style="padding: 0 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; background-color: #ffffff; text-align: left;">
              <div style="padding: 10px 0 20px 0;">
                <table cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td width="57" valign="top">
                        ';
        // line 43
        if ($this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'avatar', array())) {
            // line 44
            echo '                            <img class="avatar"  style="border: 1px solid #cccccc; padding: 1px;"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(('/uploads/user/'.$this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'avatar', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                        ';
        } else {
            // line 46
            echo '                            <img class="avatar"  style="border: 1px solid #cccccc; padding: 1px;"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter('/bundles/wwscthalamus/images/user_icon.png', 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                        ';
        }
        // line 48
        echo '                    </td>
                    <td style="padding-left: 15px; font-size: 14px; font-family: Helvetica, Arial, sans-serif;" valign="top">
                      <h1 style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000; margin: 0 0 15px 0; font-weight: normal; line-height: 1.3em;">
                          ';
        // line 51
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo '  ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo ' posted a new message:<br />
                        <span style="font-weight: bold;"><a href="';
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'id', array()))), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'title', array()), 'html', null, true);
        echo '</a></span>
                      </h1>
                      <div style="line-height: 1.3em;">
                        <div>';
        // line 55
        echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'description', array()));
        echo '</div>

                      </div>
                      <div style="padding-top: 10px;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            ';
        // line 60
        if ($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'files', array())) {
            // line 61
            echo '                                ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oElement']) ? $context['oElement'] : $this->getContext($context, 'oElement')), 'files', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oFile']) {
                // line 62
                echo '                                        ';
                if (('GOOGLE_DRIVE' == $this->getAttribute($context['oFile'], 'formatFile', array()))) {
                    // line 63
                    echo '                                            <tr>
                                              <td width="32">
                                                <a href="';
                    // line 65
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                    echo '"><img alt="';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '" border="0" class="file_icon" height="32" src="';
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileIcon', array())), 'html', null, true);
                    echo '" width="32" /></a>
                                              </td>
                                              <td style="font-size: 13px; padding: 3px 0 0 5px; color: #777777; line-height: 1.4em;">
                                                <a href="';
                    // line 68
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSrc', array()), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '</a><br />
                                                  <span style="font-size: 10px;">';
                    // line 69
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                    echo '</span>
                                              </td>
                                            </tr>  
                                        ';
                } else {
                    // line 73
                    echo '                                            <tr>
                                              <td width="32">
                                                <a href="';
                    // line 75
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
                    echo '"><img alt="';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '" border="0" class="file_icon" height="32" src="';
                    echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())), 'html', null, true);
                    echo '/bundles/wwscthalamus/images/icon_file.png" width="32" /></a>
                                              </td>
                                              <td style="font-size: 13px; padding: 3px 0 0 5px; color: #777777; line-height: 1.4em;">
                                                <a href="';
                    // line 78
                    echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'scheme', array()).'://').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'httpHost', array())).$this->getAttribute($context['oFile'], 'fileSrc', array())), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'name', array()), 'html', null, true);
                    echo '</a><br />
                                                  <span style="font-size: 10px;">';
                    // line 79
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oFile'], 'fileSize', array()), 'html', null, true);
                    echo '</span>
                                              </td>
                                            </tr>                                          
                                        ';
                }
                // line 82
                echo '                   
                                ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oFile'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 84
            echo '                            ';
        }
        // line 85
        echo '                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="padding: 10px 20px 10px 20px; font-family: Helvetica, Arial, sans-serif; font-size: 12px; background-color: #ffffff; text-align: left; border-top: 1px solid #dddddd;">
        <p style="margin: 0; color: #444444">This message was sent to 
            ';
        // line 99
        $context['i_user'] = 1;
        // line 100
        echo '            ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers')));
        foreach ($context['_seq'] as $context['_key'] => $context['nameUser']) {
            // line 101
            echo '                ';
            if ((twig_length_filter($this->env, (isset($context['aUsers']) ? $context['aUsers'] : $this->getContext($context, 'aUsers'))) == (isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')))) {
                // line 102
                echo '                    ';
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' .
                ';
            } else {
                // line 103
                echo ' 
                    ';
                // line 104
                echo twig_escape_filter($this->env, $context['nameUser'], 'html', null, true);
                echo ' ,
                ';
            }
            // line 105
            echo '    
            ';
            // line 106
            $context['i_user'] = ((isset($context['i_user']) ? $context['i_user'] : $this->getContext($context, 'i_user')) + 1);
            // line 107
            echo '            ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['nameUser'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 108
        echo '        </p>
      </td>
    </tr>
</table>
</body>
</html>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (238 => 108,  232 => 107,  230 => 106,  227 => 105,  222 => 104,  219 => 103,  213 => 102,  210 => 101,  205 => 100,  203 => 99,  187 => 85,  184 => 84,  177 => 82,  170 => 79,  164 => 78,  154 => 75,  150 => 73,  143 => 69,  137 => 68,  127 => 65,  123 => 63,  120 => 62,  115 => 61,  113 => 60,  105 => 55,  97 => 52,  91 => 51,  86 => 48,  80 => 46,  74 => 44,  72 => 43,  55 => 29,  47 => 24,  43 => 23,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Message\add.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, (isset($context['nameProject']) ? $context['nameProject'] : $this->getContext($context, 'nameProject')), 'html', null, true);
        echo ' - Post a new message
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
<div class="row">
    <div class="panel panel-default col-md-9">
        <div class="panel-heading">
            Post a new message
        </div>
        <div class="panel-body">
            <div class="row">
                ';
        // line 13
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 14
        echo '                ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 15
            echo '                    <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                ';
        }
        // line 17
        echo '                <div class="panel-forms form-edit-project">
                    <form class="form-add-message col-md-12" action="';
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_add', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo '"  method="Post">
                        <div class="col-md-12 form-group">
                            <div class="title">Title:</div>
                            <div class="col-md-12 form-group">
                                ';
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'title', array()), 'widget');
        echo '
                            </div>    
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="col-md-1 without-padding">Category:  </div>
                            <div class="col-md-3">
                                 ';
        // line 28
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'category', array()), 'widget');
        echo '
                            </div>
                        </div>            
                        <div class="col-md-12 form-group">
                            ';
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
        echo '  
                        </div>
                        <div class="col-md-12 form-group">
                                ';
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'private', array()), 'widget');
        echo '  
                                Private: (Visible only to your company)
                        </div>    
                        ';
        // line 38
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                         <div class="col-md-12  without-padding">    
                            ';
        // line 40
        $this->env->loadTemplate('WWSCThalamusBundle:File:attachment-form.html.twig')->display($context);
        echo '  
                        </div>
                        ';
        // line 42
        $this->env->loadTemplate('WWSCThalamusBundle:SubscribeEmail:block-subscribed-people.html.twig')->display(array_merge($context, array('aSubsCompanies' => (isset($context['aSubsCompanies']) ? $context['aSubsCompanies'] : $this->getContext($context, 'aSubsCompanies')), 'activeSubscribed' => null, 'type' => 'Message', 'oParent' => null)));
        echo ' 
                        <div class="col-md-12 btn-action without-padding">
                            <button class="btn btn-sm btn-primary btn-save" type="submit">Post this message</button>
                            <span>or</span> <a class="btn-cancel" href="';
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo "\"> Cancel </a> 
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>
    <div class=\"col-md-3 sidebar sidebar-filter\">
        <div class='box_message_guid'><img src=\"";
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/icon_mail.png'), 'html', null, true);
        echo '"> <a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages_guid', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo '">Post messages via email</a> </div>       
   </div>           
</div>
';
        // line 56
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadTemplateAttachment.html.twig')->display($context);
        echo '            
';
    }

    // line 58
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 59
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 60
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 61
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload-ui.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
';
    }

    // line 63
    public function block_javascripts($context, array $blocks = array())
    {
        // line 64
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 65
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 67
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/category.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 68
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/attachment.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 69
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/message.js'), 'html', null, true);
        echo '"></script>
    ';
        // line 70
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadAttachmentScript.html.twig')->display($context);
        // line 71
        echo '    <script src="https://apis.google.com/js/client.js?onload=handleGoogleClientLoad"></script>
    <script src="';
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/jquery.autogrow-textarea.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (202 => 72,  199 => 71,  197 => 70,  193 => 69,  189 => 68,  185 => 67,  181 => 66,  177 => 65,  172 => 64,  169 => 63,  163 => 61,  159 => 60,  154 => 59,  151 => 58,  145 => 56,  137 => 53,  126 => 45,  120 => 42,  115 => 40,  110 => 38,  104 => 35,  98 => 32,  91 => 28,  82 => 22,  75 => 18,  72 => 17,  66 => 15,  63 => 14,  61 => 13,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Message\comments.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'name', array()), 'html', null, true);
        echo ' - Comments
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading col-xs-12">
                <div class="col-xs-6">
                   <a href="';
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()))), 'html', null, true);
        echo '">« All Messages</a>
                </div>
                <div class="page_header_links col-xs-6">
                    <a  href="';
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_add', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()))), 'html', null, true);
        echo '">New message</a>|
                    <a  href="';
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_edit', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))), 'html', null, true);
        echo '">Edit this message</a>|
                    <a  href="';
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_delete', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))), 'html', null, true);
        echo '">Delete</a>
                </div>  
            </div>
            <div class="panel-body">
                <div class="row">
                     ';
        // line 20
        $this->env->loadTemplate('WWSCThalamusBundle:Message:message-info.html.twig')->display(array_merge($context, array('oMessage' => (isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'activeSubscribed' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'activeSubscribed', array()))));
        // line 21
        echo '                     ';
        $this->env->loadTemplate('WWSCThalamusBundle:Comment:list.html.twig')->display(array_merge($context, array('slugProject' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'aComment' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array()), 'type' => 'Message', 'parent' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))));
        // line 22
        echo '                </div>
            </div>
        </div>            
        <div class="col-md-3 sidebar">
            <div class="col">
                <div class="comments_notification-sidebar">
                    ';
        // line 28
        $this->env->loadTemplate('WWSCThalamusBundle:SubscribeEmail:comments_notification-sidebar.html.twig')->display(array_merge($context, array('slugProject' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'oParent' => (isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'type' => 'Message')));
        // line 29
        echo '                </div>
                <div class="title-panel">Who’s talking about this message?</div>
                <div class="info-panel info-about-created">
                    <ul>
                        <li><strong>';
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo '</strong></li>
                        <li>';
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'profile', array()), 'office', array()), 'html', null, true);
        echo '</li>
                        <li>';
        // line 35
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'email', array()), 'html', null, true);
        echo '</li>
                    </ul>
                </div>  
            </div>
        </div><!--/span-->        
    </div>
 ';
        // line 41
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadTemplateAttachment.html.twig')->display($context);
        echo '            
';
    }

    // line 43
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 44
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload-ui.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
';
    }

    // line 48
    public function block_javascripts($context, array $blocks = array())
    {
        // line 49
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/attachment.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/comment.js'), 'html', null, true);
        echo '"></script>
    ';
        // line 54
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadAttachmentScript.html.twig')->display($context);
        // line 55
        echo '    <script src="https://apis.google.com/js/client.js?onload=handleGoogleClientLoad"></script>
    <script src="';
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/jquery.autogrow-textarea.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (173 => 56,  170 => 55,  168 => 54,  164 => 53,  160 => 52,  156 => 51,  152 => 50,  147 => 49,  144 => 48,  138 => 46,  134 => 45,  129 => 44,  126 => 43,  120 => 41,  111 => 35,  107 => 34,  101 => 33,  95 => 29,  93 => 28,  85 => 22,  82 => 21,  80 => 20,  72 => 15,  68 => 14,  64 => 13,  58 => 10,  52 => 6,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Message\edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'name', array()), 'html', null, true);
        echo ' - Edit message
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
<div class="row">
    <div class="panel panel-default col-md-9">
        <div class="panel-heading col-xs-12">
            <div class="col-xs-6">    
                Edit this message
            </div>
            <div class="page_header_links col-xs-6">
                        <a  href="';
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_delete', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))), 'html', null, true);
        echo '">Delete</a>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                ';
        // line 18
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 19
        echo '                ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 20
            echo '                    <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                ';
        }
        // line 22
        echo '                <div class="panel-forms form-edit-project">
                    <form class="form-add-message" action="';
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_edit', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'id' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))), 'html', null, true);
        echo '"  method="Post">
                        <div class="col-md-12 form-group">
                            <div class="title">Title:</div>
                            ';
        // line 26
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'title', array()), 'widget');
        echo '
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="col-md-1 without-padding">Category:  </div>
                            <div class="col-md-3">
                                 ';
        // line 31
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'category', array()), 'widget');
        echo '
                            </div>
                        </div>            
                        <div class="col-md-12 form-group">
                            ';
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
        echo '  
                        </div>
                        <div class="col-md-12 form-group">
                                ';
        // line 38
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'private', array()), 'widget');
        echo '  
                                Private: (Visible only to your company)
                        </div>    
                        ';
        // line 41
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                         <div class="col-md-12  without-padding">    
                            ';
        // line 43
        $this->env->loadTemplate('WWSCThalamusBundle:File:attachment-form.html.twig')->display(array_merge($context, array('aFiles' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'files', array()), 'project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))));
        echo '  
                        </div>
                        ';
        // line 45
        $this->env->loadTemplate('WWSCThalamusBundle:SubscribeEmail:block-subscribed-people.html.twig')->display(array_merge($context, array('aSubsCompanies' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'subspeople', array()), 'activeSubscribed' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'activeSubscribed', array()), 'type' => 'Message', 'oParent' => (isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')))));
        echo " 
                        <div class=\"col-md-12  without-padding\">
                            <strong>Notify the people checked off above that you've edited this message?<strong>
                            <p>Anyone checked off above will receive an email with the full content of the message.<br>
                            They will also be notified every time a comment is added.</p>
                        </div>
                        <div class=\"col-md-12  without-padding\">
                            <input name=\"notify_about_changes\" type=\"checkbox\" value=\"1\"> Yes, notify the subscribers above of these changes via email.
                        </div>
                        <div class=\"col-md-12 btn-action without-padding\">
                            <button class=\"btn btn-sm btn-primary btn-save\" type=\"submit\">Post this message</button>
                            <span>or</span> <a class=\"btn-cancel\" href=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo "\"> Cancel </a> 
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>
    <div class=\"col-md-3 sidebar sidebar-filter\">
        <div class='box_message_guid'><img src=\"";
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/icon_mail.png'), 'html', null, true);
        echo '"> <a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages_guid', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo '">Post messages via email</a> </div>       
   </div>                          
</div>
';
        // line 67
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadTemplateAttachment.html.twig')->display($context);
        echo '            
';
    }

    // line 69
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 70
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 71
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload-ui.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
';
    }

    // line 74
    public function block_javascripts($context, array $blocks = array())
    {
        // line 75
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 76
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 77
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 78
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/category.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 79
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/attachment.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 80
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/message.js'), 'html', null, true);
        echo '"></script>
    ';
        // line 81
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadAttachmentScript.html.twig')->display($context);
        // line 82
        echo '    <script src="https://apis.google.com/js/client.js?onload=handleGoogleClientLoad"></script>
    <script src="';
        // line 83
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/jquery.autogrow-textarea.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (216 => 83,  213 => 82,  211 => 81,  207 => 80,  203 => 79,  199 => 78,  195 => 77,  191 => 76,  186 => 75,  183 => 74,  177 => 72,  173 => 71,  168 => 70,  165 => 69,  159 => 67,  151 => 64,  140 => 56,  126 => 45,  121 => 43,  116 => 41,  110 => 38,  104 => 35,  97 => 31,  89 => 26,  83 => 23,  80 => 22,  74 => 20,  71 => 19,  69 => 18,  61 => 13,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Message\empty-messages.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, (isset($context['nameProject']) ? $context['nameProject'] : $this->getContext($context, 'nameProject')), 'html', null, true);
        echo ' - All Messages 
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '    <div class="row blank-slate">
        <div class="modal-dialog">
            <div class="col-md-4">
                <img src="';
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/blankslate-icon-messages.png'), 'html', null, true);
        echo "\">
            </div>
            <div class=\"col-md-8\">
                <h1>Ready to post the first message to this project?</h1>
                <p>Messages are used to discuss ideas, ask questions, or post announcements about a project. Messages are like emails except they don't clutter your inbox.</p>
                <div class=\"btn-add-new-task\">
                    <a href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_add', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo '" class="btn btn-default btn-md">
                        <i class="glyphicon glyphicon-plus"></i> Create new Message
                    </a>
                </div>
            </div>
        </div>
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (64 => 15,  55 => 9,  50 => 6,  47 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Message\expanded-view.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, (isset($context['nameProject']) ? $context['nameProject'] : $this->getContext($context, 'nameProject')), 'html', null, true);
        echo ' - All Messages 
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading">
              All Messages  
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="list-messages">
                        ';
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aMessages']) ? $context['aMessages'] : $this->getContext($context, 'aMessages')));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oMessage']) {
            // line 15
            echo '                            <div data-id="message-';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oMessage'], 'id', array()), 'html', null, true);
            echo '" class="message-item info-panel col-md-11">
                                ';
            // line 16
            $this->env->loadTemplate('WWSCThalamusBundle:Message:message-item.html.twig')->display(array_merge($context, array('oMessage' => $context['oMessage'])));
            // line 17
            echo '                            </div>
                        ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo ' 
                    </div><!--/span-->
                </div>
            </div>  
        </div>                          
        <div class="col-md-3 sidebar sidebar-filter">
            <div class="col">
                <div class="btn-add-new-message">
                    <a href="';
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_add', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo "\" class=\"btn btn-default btn-md\">
                        <i class=\"glyphicon glyphicon-plus\"></i> Post a new message
                    </a>
                </div>
                <div class='box_message_guid'><img src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/icon_mail.png'), 'html', null, true);
        echo '"> <a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages_guid', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
        echo '">Post messages via email</a> </div>       
                <div class="title-panel">Categories <a class="edit-cat-block" data-cat-block="category-list" href="#">Edit</a></div>    
                <div class="info-panel">
                    <ul id="category-list" data-type="MESSAGE">
                        <li><a ';
        // line 34
        if (('' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' href="">All Message</a></li>
                        ';
        // line 35
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aCategory']) ? $context['aCategory'] : $this->getContext($context, 'aCategory')));
        foreach ($context['_seq'] as $context['_key'] => $context['oCategory']) {
            // line 36
            echo '                            <li>
                                <a ';
            // line 37
            if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'cat'), 'method') == $this->getAttribute($context['oCategory'], 'id', array()))) {
                echo ' class="active" ';
            }
            echo ' data-cat-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '" href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'cat' => $this->getAttribute($context['oCategory'], 'id', array()))), 'html', null, true);
            echo '">
                                    ';
            // line 38
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'name', array()), 'html', null, true);
            echo '
                                </a>
                                <span class="actions-panel">
                                     <a class="btn-rename-category" data-name="';
            // line 41
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'name', array()), 'html', null, true);
            echo '" data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '">Rename</a> 
                                     <a class="btn-delete-category" data-id="';
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCategory'], 'id', array()), 'html', null, true);
            echo '"><img src="/bundles/wwscthalamus/images/remove_icon.png"></a>
                                </span>
                            </li>
                        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCategory'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        echo '                        <li class="btn-add-new-categoty"><a href="#">Add new category</a></li>
                    </ul>    
                </div>
            </div>
        </div><!--/span-->
    </div>
';
    }

    // line 53
    public function block_javascripts($context, array $blocks = array())
    {
        // line 54
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/category.js'), 'html', null, true);
        echo '"></script>
 ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (184 => 54,  181 => 53,  171 => 46,  161 => 42,  155 => 41,  149 => 38,  139 => 37,  136 => 36,  132 => 35,  126 => 34,  117 => 30,  110 => 26,  100 => 18,  85 => 17,  83 => 16,  78 => 15,  61 => 14,  48 => 5,  41 => 3,  38 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Message\guid-messages.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo '    <div class="row blank-slate">
        <div class="modal-dialog message-guid">
            <div class="col-xs-12">
                <p><strong>Send an email to <a href="mailto:pm_';
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'replyUID', array()), 'html', null, true);
        echo '@thalamus.io">pm_';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'replyUID', array()), 'html', null, true);
        echo '@thalamus.io</a> and it will be posted as a message to the ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' project.</strong>
                <p>
                    <ul>
                        <li>Put this address in the ‘To:’, ‘CC:’, or ‘BCC:’ field of the email.</li> 
                        <li>The email subject will become the message title.</li>
                        <li>Everyone on the project will be notified via email.</li>
                    </ul>    
                </p>
                <p><strong>Note: The email address above is unique to you and this project.</strong>
                    This is how the system knows who wrote the message. Do not share the email address above with anyone else in your account (each person will see their own unique email address).
                </p>
                <div class="btn-add-new-task">
                    <a href="';
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '" class="remove"></i> <h4>Go back to Messages</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (63 => 18,  44 => 6,  39 => 3,  36 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Message\message-info.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class='col-md-12'>
<div class='col-md-11 message-blok'>
    <div class=\"message-info\">
        <div class=\"col-md-11 without-padding\">
            <div class=\"title\">
                ";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'title', array()), 'html', null, true);
        echo '
            </div>
            <ul class="more">
                <li>
                    <span>From: </span> ';
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo '  ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo '
                </li>
                <li>
                    <span>Date: </span> ';
        // line 13
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'updated', array()), 'D, d M Y  H:i a'), 'html', null, true);
        echo '
                </li>
                ';
        // line 15
        if ($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'category', array())) {
            // line 16
            echo '                    <li>
                        <span>Category: </span> <a href="';
            // line 17
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'cat' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'category', array()), 'id', array()))), 'html', null, true);
            echo '">';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'category', array()), 'name', array()), 'html', null, true);
            echo '</a>
                    </li>
                ';
        }
        // line 20
        echo '            </ul>
        </div>    
        <div class="avatar-user col-md-1">
            ';
        // line 23
        if ($this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'avatar', array())) {
            // line 24
            echo '                ';
            $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'avatar', array()));
            // line 25
            echo '            ';
        } else {
            // line 26
            echo '                ';
            $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
            // line 27
            echo '            ';
        }
        // line 28
        echo '            <img src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 48, 1 => 48)))), 'html', null, true);
        echo '">
        </div>
    </div>
    <div class="description col-md-12 without-padding">
            ';
        // line 32
        echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'description', array()));
        echo '
            ';
        // line 33
        if ($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'files', array())) {
            // line 34
            echo '                ';
            $this->env->loadTemplate('WWSCThalamusBundle:File:attachments-list.html.twig')->display(array_merge($context, array('aAttachments' => (isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'slugProject' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()))));
            // line 35
            echo '            ';
        }
        echo '      
    </div>
</div>
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (95 => 35,  92 => 34,  90 => 33,  86 => 32,  78 => 28,  75 => 27,  72 => 26,  69 => 25,  66 => 24,  64 => 23,  59 => 20,  51 => 17,  48 => 16,  46 => 15,  41 => 13,  33 => 10,  26 => 6,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Message\message-item.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="avatar-user col-md-1">
    ';
        // line 2
        if ($this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'avatar', array())) {
            // line 3
            echo '        ';
            $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'avatar', array()));
            // line 4
            echo '    ';
        } else {
            // line 5
            echo '        ';
            $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
            // line 6
            echo '    ';
        }
        // line 7
        echo '    <img src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 48, 1 => 48)))), 'html', null, true);
        echo '">
</div>
<div class="message-info col-md-11">
    <div class="user-posted">
        <strong> ';
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo '  ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo ' </strong> posted this message on ';
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'updated', array()), 'D, d M H:i a'), 'html', null, true);
        echo '
    </div>
    <div class="title">
        <a href="';
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))), 'html', null, true);
        echo '">
            ';
        // line 15
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'title', array()), 'html', null, true);
        echo '
        </a>
    </div>
    <div class="description">
        ';
        // line 19
        echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'description', array()));
        echo '
        ';
        // line 20
        if ($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'files', array())) {
            // line 21
            echo '            ';
            $this->env->loadTemplate('WWSCThalamusBundle:File:attachments-list.html.twig')->display(array_merge($context, array('aAttachments' => (isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'slugProject' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()))));
            // line 22
            echo '        ';
        }
        echo '      
    </div>
    <div class="action">
        <a href="';
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))), 'html', null, true);
        echo '">Go to message </a> | 
        ';
        // line 26
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array())) > 0)) {
            // line 27
            echo '            <a href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))), 'html', null, true);
            echo '">
                ';
            // line 28
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array())), 'html', null, true);
            echo ' comments
            </a> 
            <span class="user-posted">(last by ';
            // line 30
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array()), (twig_length_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array())) - 1), array(), 'array'), 'userCreated', array()), 'firstName', array()), 'html', null, true);
            echo ' ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array()), (twig_length_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array())) - 1), array(), 'array'), 'userCreated', array()), 'lastName', array()), 'html', null, true);
            echo ' on ';
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array()), (twig_length_filter($this->env, $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'comments', array())) - 1), array(), 'array'), 'created', array()), 'D, d M H:i a'), 'html', null, true);
            echo ')</span>
        ';
        } else {
            // line 32
            echo '            <a href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_comments', array('project' => $this->getAttribute($this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oMessage']) ? $context['oMessage'] : $this->getContext($context, 'oMessage')), 'id', array()))), 'html', null, true);
            echo '">Add a comment</a>
        ';
        }
        // line 33
        echo ' 
    </div>
</div>
        ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (112 => 33,  106 => 32,  97 => 30,  92 => 28,  87 => 27,  85 => 26,  81 => 25,  74 => 22,  71 => 21,  69 => 20,  65 => 19,  58 => 15,  54 => 14,  44 => 11,  36 => 7,  33 => 6,  30 => 5,  27 => 4,  24 => 3,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Pagination\sliding.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if (((isset($context['pageCount']) ? $context['pageCount'] : $this->getContext($context, 'pageCount')) > 1)) {
            // line 2
            echo '    <nav class="text-center">
        <ul class="pagination">
            ';
            // line 4
            if ((array_key_exists('first', $context) && ((isset($context['current']) ? $context['current'] : $this->getContext($context, 'current')) != (isset($context['first']) ? $context['first'] : $this->getContext($context, 'first'))))) {
                // line 5
                echo '                <li>
                    <a href="';
                // line 6
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath((isset($context['route']) ? $context['route'] : $this->getContext($context, 'route')), twig_array_merge((isset($context['query']) ? $context['query'] : $this->getContext($context, 'query')), array((isset($context['pageParameterName']) ? $context['pageParameterName'] : $this->getContext($context, 'pageParameterName')) => (isset($context['first']) ? $context['first'] : $this->getContext($context, 'first'))))), 'html', null, true);
                echo '" aria-label="Previous">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>
            ';
            }
            // line 11
            echo '            ';
            if (array_key_exists('previous', $context)) {
                // line 12
                echo '                <li>
                    <a href="';
                // line 13
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath((isset($context['route']) ? $context['route'] : $this->getContext($context, 'route')), twig_array_merge((isset($context['query']) ? $context['query'] : $this->getContext($context, 'query')), array((isset($context['pageParameterName']) ? $context['pageParameterName'] : $this->getContext($context, 'pageParameterName')) => (isset($context['previous']) ? $context['previous'] : $this->getContext($context, 'previous'))))), 'html', null, true);
                echo '" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            ';
            }
            // line 18
            echo '            ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context['pagesInRange']) ? $context['pagesInRange'] : $this->getContext($context, 'pagesInRange')));
            foreach ($context['_seq'] as $context['_key'] => $context['page']) {
                // line 19
                echo '                <li ';
                if (($context['page'] == (isset($context['current']) ? $context['current'] : $this->getContext($context, 'current')))) {
                    echo 'class="active"';
                }
                echo '>
                    <a ';
                // line 20
                if (($context['page'] != (isset($context['current']) ? $context['current'] : $this->getContext($context, 'current')))) {
                    echo 'href="';
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath((isset($context['route']) ? $context['route'] : $this->getContext($context, 'route')), twig_array_merge((isset($context['query']) ? $context['query'] : $this->getContext($context, 'query')), array((isset($context['pageParameterName']) ? $context['pageParameterName'] : $this->getContext($context, 'pageParameterName')) => $context['page']))), 'html', null, true);
                    echo '"';
                }
                echo '>';
                echo twig_escape_filter($this->env, $context['page'], 'html', null, true);
                echo '</a>
                </li>
            ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 23
            echo '            ';
            if (array_key_exists('next', $context)) {
                // line 24
                echo '                <li>
                    <a href="';
                // line 25
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath((isset($context['route']) ? $context['route'] : $this->getContext($context, 'route')), twig_array_merge((isset($context['query']) ? $context['query'] : $this->getContext($context, 'query')), array((isset($context['pageParameterName']) ? $context['pageParameterName'] : $this->getContext($context, 'pageParameterName')) => (isset($context['next']) ? $context['next'] : $this->getContext($context, 'next'))))), 'html', null, true);
                echo ' aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            ';
            }
            // line 30
            echo '            ';
            if ((array_key_exists('last', $context) && ((isset($context['current']) ? $context['current'] : $this->getContext($context, 'current')) != (isset($context['last']) ? $context['last'] : $this->getContext($context, 'last'))))) {
                // line 31
                echo '                <li>
                    <a href="';
                // line 32
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath((isset($context['route']) ? $context['route'] : $this->getContext($context, 'route')), twig_array_merge((isset($context['query']) ? $context['query'] : $this->getContext($context, 'query')), array((isset($context['pageParameterName']) ? $context['pageParameterName'] : $this->getContext($context, 'pageParameterName')) => (isset($context['last']) ? $context['last'] : $this->getContext($context, 'last'))))), 'html', null, true);
                echo ' aria-label="Next">
                        <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            ';
            }
            // line 37
            echo '        </ul>
    </nav>
';
        }
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (107 => 37,  99 => 32,  96 => 31,  93 => 30,  85 => 25,  82 => 24,  79 => 23,  64 => 20,  57 => 19,  52 => 18,  44 => 13,  41 => 12,  38 => 11,  30 => 6,  27 => 5,  25 => 4,  21 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Project\add-project-people.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - Add people, remove people, and change permissions
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-xs-12">
            <div class="panel-heading col-xs-12">
                <div class="col-xs-12">
                    <a href="';
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_project_people', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '" class="go_back">← Go back&nbsp;</a> |
                    Add people, remove people, and change permissions
                </div> 
            </div>
            <div class="panel-body">
                <div class="row add-people-to-project">
                    ';
        // line 16
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 17
        echo "                    <div class=\"list-company col-md-12\">
                        <div class=\"col-xs-12\">
                            <div class=\"btn-add-project-company\">
                                <a href=\"#\" class=\"btn btn-default btn-md\">
                                    <i class=\"glyphicon glyphicon-plus\"></i> Add another company to this project
                                </a>
                            </div>
                            <div class=\"info-panel forms-company-to-project without-padding col-md-12\">
                                <h4>Which company do you want to add to the project?</h4>
                                <p>After you add a company you'll be able to specify which people from this company can access the project.</p>
                                ";
        // line 27
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'companiesNotInProject', array())) > 0)) {
            // line 28
            echo '                                <form class="form-select-company-to-project" method="POST" action="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_add_project_people', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo "\">
                                    <div class=\"col-md-4 without-padding\">
                                        <p> Choose a company (or create a <a class='link-add-new-company'href=\"#\">new company</a>) </p>
                                        <p>";
            // line 31
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'company', array()), 'widget');
            echo '</p>
                                    </div>
                                    <div class="col-md-12 without-padding">
                                    <p>';
            // line 34
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'access_to_all_people', array()), 'widget');
            echo '
                                    <span>Give everyone from this company access to this project now.</span></p>
                                    </div>
                                    ';
            // line 37
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
            echo '
                                    <div class="col-md-12  without-padding btn-action">
                                        <button class="btn btn-sm btn-primary btn-save" type="submit">Add company to project</button>
                                        or <a class="btn-cancel" href="#"> Cancel </a> 
                                    </div>
                                </form>
                                ';
        }
        // line 44
        echo '                                 <form class="form-add-new-company-project ';
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'companiesNotInProject', array())) > 0)) {
            echo ' hide ';
        }
        echo '" method="POST" action="';
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_add_company');
        echo "\">
                                    <div class=\"col-md-12 without-padding \">
                                        <div class=\"col-md-12 without-padding\">                                            
                                            <label>
                                                Enter a new company name(or <a class='link-select-company' href=\"#\">select an existing company</a>)
                                            </label>
                                        </div>
                                        <div class=\"col-md-3 without-padding\">
                                            <input type=\"hidden\" name=\"project\" value=\"";
        // line 52
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'id', array()), 'html', null, true);
        echo '">
                                            <p>';
        // line 53
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fCompany']) ? $context['fCompany'] : $this->getContext($context, 'fCompany')), 'name', array()), 'widget');
        echo '</p>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 without-padding">
                                        <div class="col-md-3 without-padding">
                                            <label>Select the role of company</label>
                                            <div>
                                                ';
        // line 60
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fCompany']) ? $context['fCompany'] : $this->getContext($context, 'fCompany')), 'roles', array()), 'widget');
        echo '
                                            </div>
                                        </div>
                                    </div>    
                                    ';
        // line 64
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fCompany']) ? $context['fCompany'] : $this->getContext($context, 'fCompany')), '_token', array()), 'widget');
        echo '
                                    <div class="col-md-12  without-padding btn-action">
                                        <button class="btn btn-sm btn-primary btn-save" type="submit">Create and add company</button>
                                        or <a class="btn-cancel" href="#"> Cancel </a> 
                                    </div>
                                </form>    
                            </div>    
                        </div>
                        ';
        // line 72
        $context['activeSubscribedpeople'] = $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'users', array());
        // line 73
        echo '                        ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'companies', array()));
        foreach ($context['_seq'] as $context['_key'] => $context['oCompany']) {
            // line 74
            echo '                            <div class="company col-xs-12">
                                <div class="title-panel col-xs-12">
                                        ';
            // line 76
            if (($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array()))) {
                echo ' 
                                            Your company:
                                        ';
            }
            // line 79
            echo '                                            ';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'name', array()), 'html', null, true);
            echo ' <small>( ';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'roleName', array()), 'html', null, true);
            echo ' )</small>
                                        ';
            // line 80
            if ((1 != $this->getAttribute($context['oCompany'], 'primaryCompany', array()))) {
                // line 81
                echo '                                            <div class=" btn-right">
                                                <small>
                                                    <a class="remove" href="';
                // line 83
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_remove_company_project', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'id' => $this->getAttribute($context['oCompany'], 'id', array()))), 'html', null, true);
                echo '">Remove</a> 
                                                     company from this project ';
                // line 84
                echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'name', array()), 'html', null, true);
                echo '
                                                </small>
                                            </div>
                                       ';
            }
            // line 88
            echo "                                </div>
                                <div class=\"col-md-12\">
                                    <small>Give access to: 
                                        <a onclick=\"return confirm('Are you sure you want to give everyone from ";
            // line 91
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'name', array()), 'html', null, true);
            echo " access to this project?')\" href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_change_status_all_users_project', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'company' => $this->getAttribute($context['oCompany'], 'id', array()), 'action' => 'add')), 'html', null, true);
            echo "\">Everyone</a> | 
                                        <a onclick=\"return confirm('Are you sure you want remove everyone in ";
            // line 92
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'name', array()), 'html', null, true);
            echo " from this project?')\"  href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_change_status_all_users_project', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'company' => $this->getAttribute($context['oCompany'], 'id', array()), 'action' => 'remove')), 'html', null, true);
            echo '">No one</a>
                                    </small>
                                </div>
                                <div class="col-md-12 users-project">
                                    ';
            // line 96
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oCompany'], 'users', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oUser']) {
                echo '   
                                        <div class="item col-md-12">
                                            ';
                // line 98
                if (((1 == $this->getAttribute($context['oCompany'], 'primaryCompany', array())) && ($this->getAttribute($context['oUser'], 'id', array()) == $this->getAttribute($this->getAttribute($context['oCompany'], 'userCreated', array()), 'id', array())))) {
                    // line 99
                    echo '                                                <input  checked  class="project-people account-owner" disabled type="checkbox"> 
                                               ';
                    // line 100
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oUser'], 'firstName', array()), 'html', null, true);
                    echo ' ';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oUser'], 'lastName', array()), 'html', null, true);
                    echo '
                                                <small> (Account owner) </small>
                                            ';
                } else {
                    // line 103
                    echo '                                                <input ';
                    if (twig_in_filter($context['oUser'], (isset($context['activeSubscribedpeople']) ? $context['activeSubscribedpeople'] : $this->getContext($context, 'activeSubscribedpeople')))) {
                        echo ' checked ';
                    }
                    echo '  data-href="';
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_status_user_project', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'id' => $this->getAttribute($context['oUser'], 'id', array()))), 'html', null, true);
                    echo '" class="project-people"   type="checkbox"> 
                                                ';
                    // line 104
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oUser'], 'firstName', array()), 'html', null, true);
                    echo ' ';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oUser'], 'lastName', array()), 'html', null, true);
                    echo ' 
                                            ';
                }
                // line 106
                echo '                                        </div>
                                    ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oUser'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 108
            echo '                                    <div class="col-md-12">
                                        <small>      
                                             Add a new person to
                                            <a class="remove" href="';
            // line 111
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_add', array('company' => $this->getAttribute($context['oCompany'], 'id', array()), 'project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '">';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'name', array()), 'html', null, true);
            echo '</a> 
                                        </small>
                                    </div>    
                                </div>     
                            </div>    
                        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 116
        echo '                   
                    </div>
                </div><!--/span-->
            </div>  
        </div>
    </div>
';
    }

    // line 123
    public function block_javascripts($context, array $blocks = array())
    {
        // line 124
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/people_permissions.js'), 'html', null, true);
        echo '"></script>
 ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (295 => 124,  292 => 123,  282 => 116,  268 => 111,  263 => 108,  256 => 106,  249 => 104,  240 => 103,  232 => 100,  229 => 99,  227 => 98,  220 => 96,  211 => 92,  205 => 91,  200 => 88,  193 => 84,  189 => 83,  185 => 81,  183 => 80,  176 => 79,  170 => 76,  166 => 74,  161 => 73,  159 => 72,  148 => 64,  141 => 60,  131 => 53,  127 => 52,  111 => 44,  101 => 37,  95 => 34,  89 => 31,  82 => 28,  80 => 27,  68 => 17,  66 => 16,  57 => 10,  48 => 5,  41 => 3,  38 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Project\add.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Create a project
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading">
                Create a project
            </div>
            <div class="panel-body">
                <div class="row">
                    ';
        // line 13
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 14
        echo '                    ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 15
            echo '                        <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                    ';
        }
        // line 17
        echo '                    <div class="panel-forms form-add-project">
                        <form action="';
        // line 18
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_add');
        echo '"  method="Post">
                            <div class="col-xs-12">
                                Name the project <small> ( "Home page redesign" or "Marketing ideas", etc. ) </small>
                                ';
        // line 21
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'widget');
        echo '
                                ';
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                            </div>
                            <div class="col-xs-12 btn-action">
                                <button class="btn btn-sm btn-primary btn-save" type="submit">Create this project</button>
                                or <a class="btn-cancel" href="';
        // line 26
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_dashboard');
        echo '"> Cancel </a> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>                          
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (88 => 26,  81 => 22,  77 => 21,  71 => 18,  68 => 17,  62 => 15,  59 => 14,  57 => 13,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Project\edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Edit project ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'vars', array()), 'value', array()), 'html', null, true);
        echo '
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading">
                Project Settings
            </div>
            <div class="panel-body">
                <div class="row">
                    ';
        // line 13
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 14
        echo '                    ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 15
            echo '                        <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                    ';
        }
        // line 17
        echo '                    <div class="panel-forms form-edit-project">
                        <form action="';
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_edit', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '"  method="Post">
                            <h1>Project name</h1>
                            <p>The project name appears at the top of every page.</p>
                            <div class="col-xs-12 form-group">   
                                ';
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'widget');
        echo "
                            </div>
                            <h1  class=\"col-xs-12 without-padding\">Overview page announcement</h1>
                            <p>
                                Create an announcement that appears at the top of this project's Overview page. 
                                You can use this to describe the project, to make a special announcement, etc.
                            </p>
                            <div class=\"col-xs-12 form-group\">   
                                ";
        // line 30
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
        echo '
                                <div class="col-xs-12 form-group">
                                   ';
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'is_public_description', array()), 'widget');
        echo '<span class="right_label">Is public description</span>
                                </div>
                            </div>
                                
                            <h1  class="col-xs-12 without-padding">Select the primary company for this project</h1>
                            <p>
                                Select the company you want this project to be associated with in the "Your Projects" list on the Dashboard. The company name will also be displayed at the top of each project page and elsewhere where necessary.
                                Finally, the company logo will appear at the top of the All Messages page for this project.
                            </p>
                            <div class="col-xs-12 form-group">
                                <div class="col-md-6">
                                    File under this company: ';
        // line 43
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'responsible_company', array()), 'widget');
        echo '
                                </div>
                            </div>
                                
                            <h1 class="col-xs-12 without-padding">Post tasks via email</h1>    
                            <div class="col-xs-12 form-group">
                                <div class="col-md-12">
                                   <span>Send an email to </span><a href="mailto:pt_';
        // line 50
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'replyUID', array()), 'html', null, true);
        echo '@thalamus.io">pt_';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'replyUID', array()), 'html', null, true);
        echo '@thalamus.io</a> and it will be posted as a task to the task list selected below.
                                </div>
                                <div class="col-md-6 margin-top-1x">
                                   <div>Please select task list: ';
        // line 53
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'post_task_via_email', array()), 'widget');
        echo '</div>
                                  </div>
                            </div>
                            ';
        // line 56
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                            <div class="col-xs-12 btn-action">
                                <button class="btn btn-sm btn-primary btn-save" type="submit">Save changes</button>
                                or <a class="btn-cancel" href="';
        // line 59
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_dashboard');
        echo '"> Cancel </a> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>
        <div class="col-md-3 sidebar">
            ';
        // line 67
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo ' 
            <div class="col">
                <div class="title-panel">Delete this project?</div>
                <div class="info-panel">
                    Deleting a project deletes all the data associated with this project (messages, milestones, to-do lists, files, writeboards, etc).<br> 
                    <a class="btn-delete-project" href="';
            // line 72
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_delete', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '">Yes, I understand — delete this project</a>
                </div>   
            </div>
            ';
        }
        // line 75
        echo '    
        </div><!--/span-->                    
    </div>
';
    }

    // line 80
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 81
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
';
    }

    // line 83
    public function block_javascripts($context, array $blocks = array())
    {
        // line 84
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 85
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 86
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (197 => 86,  193 => 85,  188 => 84,  185 => 83,  178 => 81,  175 => 80,  168 => 75,  161 => 72,  153 => 67,  142 => 59,  136 => 56,  130 => 53,  122 => 50,  112 => 43,  98 => 32,  93 => 30,  82 => 22,  75 => 18,  72 => 17,  66 => 15,  63 => 14,  61 => 13,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Project\empty-project.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo '- Welcome to your new project 
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '    <div class="row blank-slate">
        <div class="modal-dialog">
            <div class="col-md-4">
                <img src="';
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/blankslate-icon-overview.png'), 'html', null, true);
        echo "\">
            </div>
            <div class=\"col-md-8\">
                <h1>Welcome to your new project</h1>
                <p>This Overview screen will show you the latest activity in your project. But before we can show you activity, you'll need to get the project started.</p>
                <ul>
                    <li>→ <a href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">Post the first message</a></li>
                    ';
        // line 16
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo '  
                        <li>→ <a href="';
            // line 17
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '">Create the first to-do list</a></li>
                    ';
        }
        // line 19
        echo '                    <li>→ <a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">Upload the first file</a></li>
                </ul>
            </div>
        </div>
    </div>         
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (77 => 19,  72 => 17,  68 => 16,  64 => 15,  55 => 9,  50 => 6,  47 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Project\header.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '
<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="';
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_overview', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' (';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'responsibleCompany', array()), 'name', array()), 'html', null, true);
        echo ')</a>
        </div>
        <div class="collapse navbar-collapse">
            <div id="settings_signout_and_help">
                <a  href="';
        // line 15
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_dashboard');
        echo '">Back to Projects</a>
                <span class="pipe">|</span>
                <span class="account">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Account: <strong>';
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'account'), 'method'), 'name', array()), 'html', null, true);
        echo ' </strong>
                            <span class="caret"></span>
                        </a>
                        ';
        // line 23
        if ((twig_length_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'companyUser', array())) > 1)) {
            // line 24
            echo '                            <ul class="dropdown-menu">
                                ';
            // line 25
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'companyUser', array()));
            foreach ($context['_seq'] as $context['_key'] => $context['oCompanyUser']) {
                // line 26
                echo '                                    ';
                $context['oCompany'] = $this->getAttribute($context['oCompanyUser'], 'company', array());
                // line 27
                echo '                                    <li  ';
                if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'account'), 'method'), 'slug', array()) == $this->getAttribute($this->getAttribute((isset($context['oCompany']) ? $context['oCompany'] : $this->getContext($context, 'oCompany')), 'account', array()), 'slug', array()))) {
                    echo 'class="active" ';
                }
                echo ' ><a href="';
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_change', array('account' => $this->getAttribute($this->getAttribute((isset($context['oCompany']) ? $context['oCompany'] : $this->getContext($context, 'oCompany')), 'account', array()), 'id', array()))), 'html', null, true);
                echo '">';
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oCompany']) ? $context['oCompany'] : $this->getContext($context, 'oCompany')), 'account', array()), 'name', array()), 'html', null, true);
                echo '</a></li>
                                    ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCompanyUser'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 29
            echo '                            </ul>
                        ';
        }
        // line 31
        echo '                    </div>|
                </span>
                ';
        // line 33
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            // line 34
            echo '                    <a href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_edit', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '"> Project Settings</a>
                    <span class="pipe">|</span>
                ';
        }
        // line 37
        echo '                <a href="';
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_myinfo');
        echo '" title="Review and edit your account information">My info</a>
                <span class="pipe">|</span>
                <a href="';
        // line 39
        echo $this->env->getExtension('routing')->getPath('fos_user_security_logout');
        echo '" title="Sign out and clear the cookie off your machine">Sign out</a>
                ';
        // line 40
        $this->env->loadTemplate('WWSCThalamusBundle:Task:search-task-form.html.twig')->display($context);
        // line 41
        echo '                <a href="#" class="help" target="_blank"><span>HELP</span></a>
            </div>

            <ul class="nav navbar-nav navbar-left">
                <li ';
        // line 45
        if (('overview' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' ><a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_overview', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">Overview</a></li>
                <li ';
        // line 46
        if (('messages' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' ><a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_messages', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">Messages</a></li>
                <li ';
        // line 47
        if (('todos' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' ><a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_todos', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">To-Dos</a></li>
                <li ';
        // line 48
        if (('files' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' ><a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_list', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">Files</a></li>
                ';
        // line 49
        if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || $this->env->getExtension('security')->isGranted('ROLE_FREELANCER'))) {
            echo ' 
                    <li ';
            // line 50
            if (('time' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
                echo ' class="active" ';
            }
            echo ' >
                        <a href="';
            // line 51
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_time_list', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '">Time</a>
                    </li>
                ';
        }
        // line 54
        echo '            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li ';
        // line 56
        if (('people_permissions' == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'active_module'), 'method'))) {
            echo ' class="active" ';
        }
        echo ' ><a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_project_people', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">People &amp; Permissions</a></li>
                <li class="print"><a href="javascript:window.print()"  title="print"><img height=18px src="';
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/print_icon.png'), 'html', null, true);
        echo '"></a></li>
            </ul>
        </div>
    </div>
</div>
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (178 => 57,  170 => 56,  166 => 54,  160 => 51,  154 => 50,  150 => 49,  142 => 48,  134 => 47,  126 => 46,  118 => 45,  112 => 41,  110 => 40,  106 => 39,  100 => 37,  93 => 34,  91 => 33,  87 => 31,  83 => 29,  68 => 27,  65 => 26,  61 => 25,  58 => 24,  56 => 23,  50 => 20,  42 => 15,  31 => 11,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Project\overview.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - Overview 
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading  col-xs-12">
                <div class="col-xs-6">
                    Project overview & activity
                </div>
                <div class="page_header_links col-xs-6">
                    <a href="';
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_message_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">New message</a>|
                    ';
        // line 14
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            // line 15
            echo '                        <a href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '" >New to-do list</a>|
                    ';
        }
        // line 17
        echo '                    <a href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_file_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">New file</a>|
                    <a href="';
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_todos', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '?filter_tasks[filter_responsible]=u_';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), 'html', null, true);
        echo '&filter_tasks[filter_due]=#">my To-DoS</a>
                </div>
            </div>
            <div class="panel-body">
                ';
        // line 22
        if ($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'isPublicDescription', array())) {
            // line 23
            echo '                    <div class="project_description">
                        ';
            // line 24
            echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'description', array()));
            echo '
                    </div>
                ';
        }
        // line 27
        echo '                <div class="row">
                    <div class="col-sm-12 col-md-12 main">
                        <div class="table-responsive">
                        <!-- list log begin -->
                        ';
        // line 31
        $context['lastDate'] = null;
        // line 32
        echo '                        ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aLog']) ? $context['aLog'] : $this->getContext($context, 'aLog')));
        foreach ($context['_seq'] as $context['_key'] => $context['oLog']) {
            // line 33
            echo '                            ';
            if (((null == (isset($context['lastDate']) ? $context['lastDate'] : $this->getContext($context, 'lastDate'))) && (twig_date_converter($this->env, $this->getAttribute($context['oLog'], 'created', array(), 'array')) > twig_date_converter($this->env, 'today')))) {
                // line 34
                echo '                                <div class="overview-today"">Today</div>
                                    
                                    <table class="table table-striped dashboard-log">
                                        <tbody>
                            ';
            } else {
                // line 39
                echo '                                ';
                $context['sLastDate'] = twig_date_format_filter($this->env, twig_date_converter($this->env, (isset($context['lastDate']) ? $context['lastDate'] : $this->getContext($context, 'lastDate'))), 'm/d/Y');
                // line 40
                echo '                                ';
                $context['sCreated'] = twig_date_format_filter($this->env, $this->getAttribute($context['oLog'], 'created', array(), 'array'), 'm/d/Y');
                // line 41
                echo '                                ';
                if (((isset($context['sCreated']) ? $context['sCreated'] : $this->getContext($context, 'sCreated')) != (isset($context['sLastDate']) ? $context['sLastDate'] : $this->getContext($context, 'sLastDate')))) {
                    // line 42
                    echo '                                            </tbody>
                                        </table>
                                    <div class="overview-today"">';
                    // line 44
                    echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context['oLog'], 'created', array(), 'array'), 'l, j F Y'), 'html', null, true);
                    echo '</div>
                                        <table class="table table-striped dashboard-log">
                                            <tbody>
                                ';
                }
                // line 48
                echo '                            ';
            }
            // line 49
            echo '                            ';
            $context['lastDate'] = $this->getAttribute($context['oLog'], 'created', array(), 'array');
            // line 50
            echo '                            <tr>
                                <td class="type col-md-2" ><span class="';
            // line 51
            echo twig_escape_filter($this->env, twig_lower_filter($this->env, $this->getAttribute($context['oLog'], 'object_type', array(), 'array')), 'html', null, true);
            echo '">';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oLog'], 'object_type', array(), 'array'), 'html', null, true);
            echo '</span></td>
                                <td class="item">
                                    ';
            // line 54
            echo '                                    ';
            echo $this->getAttribute($context['oLog'], 'description', array(), 'array');
            echo '
                                    ';
            // line 55
            echo '</td>
                                <td class="action">';
            // line 56
            echo twig_escape_filter($this->env, $this->getAttribute($context['oLog'], 'action', array(), 'array'), 'html', null, true);
            echo '</td>
                                <td class="author">';
            // line 57
            echo twig_escape_filter($this->env, $this->getAttribute($context['oLog'], 'last_name', array(), 'array'), 'html', null, true);
            echo ' ';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oLog'], 'first_name', array(), 'array'), 'html', null, true);
            echo '</td>
                            </tr>
                        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oLog'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 60
        echo '                                </tbody>
                            </table>
                        </div>
                        <!-- list log end -->
                        <!-- pagination log -->
                        ';
        // line 65
        if (((isset($context['countPage']) ? $context['countPage'] : $this->getContext($context, 'countPage')) > 1)) {
            // line 66
            echo '                            ';
            $this->env->loadTemplate('WWSCThalamusBundle:Project:pagination-log.html.twig')->display(array_merge($context, array('url' => $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_overview', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'currentPage' => (isset($context['currentPage']) ? $context['currentPage'] : $this->getContext($context, 'currentPage')), 'countPage' => (isset($context['countPage']) ? $context['countPage'] : $this->getContext($context, 'countPage')))));
            // line 71
            echo '                        ';
        }
        // line 72
        echo '                        <!-- end pagination log -->
                    </div><!--/span-->
                </div>  
            </div>  
        </div>
        <div class="col-md-3 sidebar">
            <div class="col">
                ';
        // line 79
        if ((($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'account', array()), 'primaryCompany', array()), 'id', array()) != $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())) && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'account', array()), 'primaryCompany', array()), 'logo', array()))) {
            // line 80
            echo '                    <div class="info-panel box-company-logo">
                        <img src="';
            // line 81
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(($this->env->getExtension('assets')->getAssetUrl('uploads/company/').$this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'account', array()), 'primaryCompany', array()), 'logo', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 242, 1 => 242), 'mode' => 'inset'))), 'html', null, true);
            echo '">
                    </div>
                 ';
        }
        // line 84
        echo '                ';
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'logo', array())) {
            // line 85
            echo '                    <div class="info-panel box-company-logo">
                        <img src="';
            // line 86
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter(($this->env->getExtension('assets')->getAssetUrl('uploads/company/').$this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'logo', array())), 'my_thumb', array('thumbnail' => array('size' => array(0 => 242, 1 => 242), 'mode' => 'inset'))), 'html', null, true);
            echo '">
                    </div>
                ';
        }
        // line 89
        echo '                <div class="title-panel">Stay up to date on this project</div>
                <div class="info-panel global-feeds">
                    <div>
                        <img  src="';
        // line 92
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/feedIcon.png'), 'html', null, true);
        echo '"><a href="#">Global RSS Feed</a>
                    </div>
                    <div>
                        <img  src="';
        // line 95
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/calendar-icon.png'), 'html', null, true);
        echo '"><a href="#">Global iCalendar</a>
                    </div>
                </div>
                <div class="title-panel">People on this project</div>    
                <div class="info-panel sidebar-people-on-project">
                    ';
        // line 100
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'subspeople', array()));
        foreach ($context['_seq'] as $context['_key'] => $context['oResponsibleCompany']) {
            // line 101
            echo '                        <div class="item-compnay">';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'name', array(), 'array'), 'html', null, true);
            echo '</div>
                            <div class="list-users">
                            ';
            // line 103
            if ($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'any', true, true)) {
                // line 104
                echo '                                ';
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'));
                foreach ($context['_seq'] as $context['key'] => $context['val']) {
                    // line 105
                    echo '                                        <div class="item-user">';
                    echo twig_escape_filter($this->env, $context['val'], 'html', null, true);
                    echo '</div>
                                ';
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 107
                echo '                            ';
            }
            // line 108
            echo '                            </div> 
                    ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oResponsibleCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 110
        echo '                </div> 
            </div>
        </div><!--/span-->               
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (280 => 110,  273 => 108,  270 => 107,  261 => 105,  256 => 104,  254 => 103,  248 => 101,  244 => 100,  236 => 95,  230 => 92,  225 => 89,  219 => 86,  216 => 85,  213 => 84,  207 => 81,  204 => 80,  202 => 79,  193 => 72,  190 => 71,  187 => 66,  185 => 65,  178 => 60,  167 => 57,  163 => 56,  160 => 55,  155 => 54,  148 => 51,  145 => 50,  142 => 49,  139 => 48,  132 => 44,  128 => 42,  125 => 41,  122 => 40,  119 => 39,  112 => 34,  109 => 33,  104 => 32,  102 => 31,  96 => 27,  90 => 24,  87 => 23,  85 => 22,  76 => 18,  71 => 17,  65 => 15,  63 => 14,  59 => 13,  50 => 6,  47 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Project\pagination-log.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<nav class="text-center">
    <ul class="pagination">
        ';
        // line 3
        if ((((isset($context['currentPage']) ? $context['currentPage'] : $this->getContext($context, 'currentPage')) - 1) > 0)) {
            // line 4
            echo '             <li>
                 <a href="';
            // line 5
            echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
            echo '?page=1">
                     <span aria-hidden="true">««</span>
                 </a>
             </li>
             <li>
                 <a href="';
            // line 10
            echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
            echo '?page=';
            echo twig_escape_filter($this->env, ((isset($context['currentPage']) ? $context['currentPage'] : $this->getContext($context, 'currentPage')) - 1), 'html', null, true);
            echo '">
                     <span aria-hidden="true">«</span>
                 </a>
             </li>
         ';
        }
        // line 15
        echo '         ';
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable(range(1, (isset($context['countPage']) ? $context['countPage'] : $this->getContext($context, 'countPage'))));
        foreach ($context['_seq'] as $context['_key'] => $context['page']) {
            // line 16
            echo '             ';
            if (((isset($context['currentPage']) ? $context['currentPage'] : $this->getContext($context, 'currentPage')) == $context['page'])) {
                // line 17
                echo '                  <li class="active">
                      <a>';
                // line 18
                echo twig_escape_filter($this->env, $context['page'], 'html', null, true);
                echo '</a>
                 </li>
                 ';
            } else {
                // line 21
                echo '                 <li>
                     <a href="';
                // line 22
                echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
                echo '?page=';
                echo twig_escape_filter($this->env, $context['page'], 'html', null, true);
                echo '">';
                echo twig_escape_filter($this->env, $context['page'], 'html', null, true);
                echo '</a>
                 </li>    
             ';
            }
            // line 25
            echo '         ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo '         ';
        if (((isset($context['countPage']) ? $context['countPage'] : $this->getContext($context, 'countPage')) >= ((isset($context['currentPage']) ? $context['currentPage'] : $this->getContext($context, 'currentPage')) + 1))) {
            // line 27
            echo '             <li>
                 <a href="';
            // line 28
            echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
            echo '?page=';
            echo twig_escape_filter($this->env, ((isset($context['currentPage']) ? $context['currentPage'] : $this->getContext($context, 'currentPage')) + 1), 'html', null, true);
            echo '">
                     <span aria-hidden="true">»</span>
                 </a>
             </li>
             <li>
                 <a href="';
            // line 33
            echo twig_escape_filter($this->env, (isset($context['url']) ? $context['url'] : $this->getContext($context, 'url')), 'html', null, true);
            echo '?page=';
            echo twig_escape_filter($this->env, (isset($context['countPage']) ? $context['countPage'] : $this->getContext($context, 'countPage')), 'html', null, true);
            echo '">
                     <span aria-hidden="true">»»</span>
                 </a>
             </li>
         ';
        }
        // line 38
        echo '    </ul>
</nav>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (108 => 38,  98 => 33,  88 => 28,  85 => 27,  82 => 26,  76 => 25,  66 => 22,  63 => 21,  57 => 18,  54 => 17,  51 => 16,  46 => 15,  36 => 10,  28 => 5,  25 => 4,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Project\project-people.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo '- People & Permissions  
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-xs-12">
            <div class="panel-heading col-xs-12">
                <div class="col-xs-12">
                    People on this project  
                    ';
        // line 11
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            // line 12
            echo '                        <a href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_add_project_people', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '"> Add people, remove people, change permissions</a>
                    ';
        }
        // line 14
        echo '                </div> 
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 main">
                        <div class="modal fade" id="add-new-company">
                            ';
        // line 20
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller('WWSCThalamusBundle:Company:add'));
        echo '
                        </div>
                    </div>
                    ';
        // line 23
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 24
        echo '                    <div class="list-company col-md-12">
                        ';
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'companies', array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oCompany']) {
            // line 26
            echo '                            ';
            if ((($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || ($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array()))) || (('ROLE_CLIENT' == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'roles', array())) && ('ROLE_CLIENT' == $this->getAttribute($context['oCompany'], 'roles', array()))))) {
                // line 27
                echo '                            <div class="company  col-xs-12">
                                <div class="title-panel col-xs-12">
                                    <div class="col-xs-12">
                                        ';
                // line 30
                if (($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array()))) {
                    echo ' 
                                            Your company:
                                        ';
                }
                // line 33
                echo '                                        ';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'name', array()), 'html', null, true);
                echo ' 
                                        ';
                // line 34
                if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || ($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())))) {
                    // line 35
                    echo '                                            <small>( ';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oCompany'], 'roleName', array()), 'html', null, true);
                    echo ' )</small>
                                        ';
                }
                // line 37
                echo '                                    </div>
                                </div>
                                <div class="item col-md-4">
                                    <div class="avatar">
                                        <img src="';
                // line 41
                echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter($this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/company_icon.png'), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
                echo '">
                                    </div>
                                    <div class="desc">
                                        ';
                // line 44
                $this->env->loadTemplate('WWSCThalamusBundle:Company:block_info_company.html.twig')->display(array_merge($context, array('company' => $context['oCompany'])));
                // line 45
                echo '                                        ';
                if ((($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())) || $this->env->getExtension('security')->isGranted('ROLE_PROVIDER'))) {
                    echo '                    
                                              <a href="';
                    // line 46
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_company_edit', array('id' => $this->getAttribute($context['oCompany'], 'id', array()))), 'html', null, true);
                    echo '">Edit</a> <small> this company</small>
                                        ';
                }
                // line 48
                echo '                                    </div>
                                </div>
                                ';
                // line 50
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'users', array(0 => $this->getAttribute($context['oCompany'], 'id', array())), 'method'));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index' => 1,
                  'first' => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context['_key'] => $context['oUser']) {
                    echo '   
                                    <div class="item col-md-4">
                                        <div class="avatar">
                                            ';
                    // line 53
                    if ($this->getAttribute($context['oUser'], 'avatar', array())) {
                        // line 54
                        echo '                                                ';
                        $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute($context['oUser'], 'avatar', array()));
                        // line 55
                        echo '                                            ';
                    } else {
                        // line 56
                        echo '                                                ';
                        $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
                        // line 57
                        echo '                                            ';
                    }
                    // line 58
                    echo '                                            <img src="';
                    echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
                    echo '">
                                            ';
                    // line 59
                    if ($this->getAttribute($context['oUser'], 'enabled', array())) {
                        // line 60
                        echo '                                                ';
                        if (((isset($context['accountOwnerId']) ? $context['accountOwnerId'] : $this->getContext($context, 'accountOwnerId')) == $this->getAttribute($context['oUser'], 'id', array()))) {
                            // line 61
                            echo '                                                    <div class="badge badge-owner">OWNER</div>
                                                ';
                        }
                        // line 62
                        echo ' 
                                            ';
                    } else {
                        // line 64
                        echo '                                                <div class="badge badge-invited">INVITED</div>      
                                            ';
                    }
                    // line 65
                    echo '   
                                        </div>
                                        <div class="desc">
                                            ';
                    // line 68
                    $this->env->loadTemplate('WWSCThalamusBundle:User:block_info_user.html.twig')->display(array_merge($context, array('user' => $context['oUser'])));
                    // line 69
                    echo '                                            ';
                    if ((($this->getAttribute($context['oCompany'], 'id', array()) == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())) || $this->env->getExtension('security')->isGranted('ROLE_PROVIDER'))) {
                        echo '   
                                                <a href="';
                        // line 70
                        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_edit', array('id' => $this->getAttribute($context['oUser'], 'id', array()))), 'html', null, true);
                        echo '"">Edit</a>
                                            ';
                    }
                    // line 72
                    echo '                                        </div>
                                    </div>
                                ';
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oUser'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 75
                echo '                            </div>
                            ';
            }
            // line 77
            echo '                        ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo '                   
                    </div>            
                </div><!--/span-->
            </div>  
        </div>
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (250 => 77,  246 => 75,  230 => 72,  225 => 70,  220 => 69,  218 => 68,  213 => 65,  209 => 64,  205 => 62,  201 => 61,  198 => 60,  196 => 59,  191 => 58,  188 => 57,  185 => 56,  182 => 55,  179 => 54,  177 => 53,  156 => 50,  152 => 48,  147 => 46,  142 => 45,  140 => 44,  134 => 41,  128 => 37,  122 => 35,  120 => 34,  115 => 33,  109 => 30,  104 => 27,  101 => 26,  84 => 25,  81 => 24,  79 => 23,  73 => 20,  65 => 14,  59 => 12,  57 => 11,  47 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Resetting\checkEmail.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle::layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle::layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        // line 4
        echo '    <div class="signin">
        <div class="alert alert-success" role="alert">
            ';
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans('resetting.check_email', array('%email%' => (isset($context['email']) ? $context['email'] : $this->getContext($context, 'email'))), 'FOSUserBundle'), 'html', null, true);
        echo '
        </div>
    </div>    
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (43 => 6,  39 => 4,  36 => 3,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Resetting\request.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle::layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle::layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        // line 4
        echo '    <div class="modal-content">
        <form action="';
        // line 5
        echo $this->env->getExtension('routing')->getPath('fos_user_resetting_send_email');
        echo '" method="POST" class="fos_user_resetting_request form-signin">
            <h3 aligh=center>Reset  password</h3>
            ';
        // line 7
        if (array_key_exists('invalid_username', $context)) {
            // line 8
            echo '                <p class="error">';
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans('resetting.request.invalid_username', array('%username%' => (isset($context['invalid_username']) ? $context['invalid_username'] : $this->getContext($context, 'invalid_username'))), 'FOSUserBundle'), 'html', null, true);
            echo '</p>
            ';
        }
        // line 10
        echo '            <div class="form-group">
                <input type="text" class="form-control" id="username" placeholder="';
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans('resetting.request.username', array(), 'FOSUserBundle'), 'html', null, true);
        echo '" name="username" required="required" />
            </div>
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block" id="_submit" name="_submit"  type="submit">';
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans('resetting.request.submit', array(), 'FOSUserBundle'), 'html', null, true);
        echo '</button>
            </div>
        </form>
    </div>    
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (64 => 14,  58 => 11,  55 => 10,  49 => 8,  47 => 7,  42 => 5,  39 => 4,  36 => 3,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Resetting\reset.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle::layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle::layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        // line 4
        echo '    <div class="modal-content container">
        <form action="';
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('fos_user_resetting_reset', array('token' => (isset($context['token']) ? $context['token'] : $this->getContext($context, 'token')))), 'html', null, true);
        echo '" ';
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'enctype');
        echo ' method="POST" class="fos_user_resetting_reset">
            <h3 aligh=center>Change password</h3>
            ';
        // line 7
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'plainPassword', array()), 'errors')) {
            // line 8
            echo '                <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'plainPassword', array()), 'errors');
            echo '</div>
            ';
        }
        // line 10
        echo '            <div class="form-group">
                ';
        // line 11
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'plainPassword', array()), 'first', array()), 'widget', array('attr' => array('class' => 'form-control', 'placeholder' => 'Password', 'pattern' => '.{8,20}')));
        echo '
            </div>
            <div class="form-group">
                ';
        // line 14
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'plainPassword', array()), 'second', array()), 'widget', array('attr' => array('class' => 'form-control', 'placeholder' => 'Confirm password', 'pattern' => '.{8,20}')));
        echo '
            </div>
            ';
        // line 16
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block" id="_submit" name="_submit"  type="submit">';
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans('resetting.reset.submit', array(), 'FOSUserBundle'), 'html', null, true);
        echo '</button>
            </div>
        </form>
    </div>    
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (76 => 18,  71 => 16,  66 => 14,  60 => 11,  57 => 10,  51 => 8,  49 => 7,  42 => 5,  39 => 4,  36 => 3,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Security\login.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle::layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle::layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Sign in Thalamus
';
    }

    // line 6
    public function block_fos_user_content($context, array $blocks = array())
    {
        // line 7
        echo '    <div class="signin modal-content container">
        <form class="form-signin" ';
        // line 8
        if ((isset($context['ajaxLogin']) ? $context['ajaxLogin'] : $this->getContext($context, 'ajaxLogin'))) {
            echo ' id="login-form-user" ';
        }
        echo ' action="';
        echo $this->env->getExtension('routing')->getPath('fos_user_security_check');
        echo '" method="post">
            <div class="error"></div>
            ';
        // line 10
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 11
        echo '            <input type="hidden" name="_csrf_token" value="';
        echo twig_escape_filter($this->env, (isset($context['csrf_token']) ? $context['csrf_token'] : $this->getContext($context, 'csrf_token')), 'html', null, true);
        echo '" />
            <h2 class="form-signin-heading">Sign in Thalamus</h2>   
            ';
        // line 13
        if ((isset($context['error']) ? $context['error'] : $this->getContext($context, 'error'))) {
            // line 14
            echo '                <div class="alert alert-error" role="alert">';
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans($this->getAttribute((isset($context['error']) ? $context['error'] : $this->getContext($context, 'error')), 'messageKey', array()), $this->getAttribute((isset($context['error']) ? $context['error'] : $this->getContext($context, 'error')), 'messageData', array()), 'security'), 'html', null, true);
            echo '</div>
            ';
        }
        // line 16
        echo '            <div class="form-group">
                <input type="email" id="username" name="_username"  class="form-control" placeholder="Email"  required="required" />
            </div>
            <div class="form-group" >
                <input type="password" id="password" name="_password" class="form-control" placeholder="Password" required="required" />
            </div>
            <div class="checkbox">
                <input type="checkbox" id="remember_me" name="_remember_me" value="on" />
                <label for="signin_remember_me">';
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans('security.login.remember_me', array(), 'FOSUserBundle'), 'html', null, true);
        echo '</label>
            </div>
            <div class="form-group">  
                <button class="btn btn-lg btn-primary" id="_submit" name="_submit"  type="submit">';
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans('security.login.submit', array(), 'FOSUserBundle'), 'html', null, true);
        echo '</button>
                ';
        // line 28
        if ((isset($context['ajaxLogin']) ? $context['ajaxLogin'] : $this->getContext($context, 'ajaxLogin'))) {
            // line 29
            echo '                    <img src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/social_google_box.png'), 'html', null, true);
            echo '">
                    <a href="';
            // line 30
            echo $this->env->getExtension('routing')->getPath('hwi_oauth_service_redirect', array('service' => 'google'));
            echo '" alt="Sign in with Google">Sign in with Google</a>
                ';
        } else {
            // line 31
            echo '     
                    <span>or</span> <a class="btn-cancel" href="';
            // line 32
            echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_registration_account');
            echo '"> Create new account </a>
                ';
        }
        // line 34
        echo '            </div>
            ';
        // line 35
        if ((false == (isset($context['ajaxLogin']) ? $context['ajaxLogin'] : $this->getContext($context, 'ajaxLogin')))) {
            // line 36
            echo '            <div class="form-group">
                 <img src="';
            // line 37
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/social_google_box.png'), 'html', null, true);
            echo '">
                 <a href="';
            // line 38
            echo $this->env->getExtension('routing')->getPath('hwi_oauth_service_redirect', array('service' => 'google'));
            echo '" alt="Sign in with Google">Sign in with Google</a>
            </div>
            ';
        }
        // line 41
        echo '            <hr>
            <div class="forgot_password">Help: <a href="';
        // line 42
        echo $this->env->getExtension('routing')->getPath('fos_user_resetting_request');
        echo '">I forgot my password</a></div>
        </form>
    </div>    
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (137 => 42,  134 => 41,  128 => 38,  124 => 37,  121 => 36,  119 => 35,  116 => 34,  111 => 32,  108 => 31,  103 => 30,  98 => 29,  96 => 28,  92 => 27,  86 => 24,  76 => 16,  70 => 14,  68 => 13,  62 => 11,  60 => 10,  51 => 8,  48 => 7,  45 => 6,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\SubscribeEmail\block-notify-people.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="subscribe-to-email col-md-12">
    <div class="col-md-12  without-padding">    
        <strong>Notify people via email</strong>
    </div>
    <div class="col-md-12 without-padding">
        ';
        // line 6
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aSubsCompanies']) ? $context['aSubsCompanies'] : $this->getContext($context, 'aSubsCompanies')));
        foreach ($context['_seq'] as $context['_key'] => $context['oSubsCompany']) {
            // line 7
            echo '            <div class="col-md-12  without-padding"> <input type="checkbox" class="input-subscribed-company" data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'id', array(), 'array'), 'html', null, true);
            echo '">  <strong>All of ';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'name', array(), 'array'), 'html', null, true);
            echo '</strong></div>
            ';
            // line 8
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oSubsCompany'], 'people', array(), 'array'));
            foreach ($context['_seq'] as $context['key'] => $context['value']) {
                // line 9
                echo '                <div class="col-md-3  without-padding">
                    <input  name="aSubspeople[';
                // line 10
                echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                echo ']" class="input-people-subscribed"  type="checkbox"  data-company-id=';
                echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'id', array(), 'array'), 'html', null, true);
                echo '  value="';
                echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                echo '">  ';
                echo twig_escape_filter($this->env, $context['value'], 'html', null, true);
                echo '
                </div>
            ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 12
            echo ' 
        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oSubsCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo '    
    </div>
</div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (66 => 13,  59 => 12,  44 => 10,  41 => 9,  37 => 8,  30 => 7,  26 => 6,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\SubscribeEmail\block-subscribed-people.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"subscribe-to-email col-md-12  without-padding\">
    <div class=\"col-md-12  without-padding\">    
        <strong>Subscribe people to receive email notifications</strong>
        <p>The people you select will get an email when you post this comment.<br>
        They'll also be notified by email every time a new comment is added.</p>
    </div>
    <div class=\"col-md-12 without-padding\">

        ";
        // line 9
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aSubsCompanies']) ? $context['aSubsCompanies'] : $this->getContext($context, 'aSubsCompanies')));
        foreach ($context['_seq'] as $context['_key'] => $context['oSubsCompany']) {
            // line 10
            echo '                ';
            if (('Task' == (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')))) {
                // line 11
                echo '                    ';
                if (((('ROLE_PROVIDER' == $this->getAttribute($context['oSubsCompany'], 'role', array(), 'array')) || ((1 == $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'visibleClient', array())) && ('ROLE_CLIENT' == $this->getAttribute($context['oSubsCompany'], 'role', array(), 'array')))) || ((1 == $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'visibleFreelancer', array())) && ('ROLE_FREELANCER' == $this->getAttribute($context['oSubsCompany'], 'role', array(), 'array'))))) {
                    echo '        
                        ';
                    // line 12
                    if ($this->getAttribute($context['oSubsCompany'], 'people', array(), 'any', true, true)) {
                        // line 13
                        echo '                            <div class="col-md-12  without-padding"> <input type="checkbox" class="input-subscribed-company" data-id="';
                        echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'id', array(), 'array'), 'html', null, true);
                        echo '">  <strong>All of ';
                        echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'name', array(), 'array'), 'html', null, true);
                        echo '</strong></div>
                            ';
                        // line 14
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oSubsCompany'], 'people', array(), 'array'));
                        foreach ($context['_seq'] as $context['key'] => $context['value']) {
                            // line 15
                            echo '                                <div class="col-md-3  without-padding">
                                    <input ';
                            // line 16
                            if (twig_in_filter($context['key'], twig_get_array_keys_filter((isset($context['activeSubscribed']) ? $context['activeSubscribed'] : $this->getContext($context, 'activeSubscribed'))))) {
                                echo ' checked ';
                            }
                            echo ' class="input-people-subscribed" name="aSubspeople[';
                            echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                            echo ']" type="checkbox"  data-company-id=';
                            echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'id', array(), 'array'), 'html', null, true);
                            echo '  value="';
                            echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                            echo '">  ';
                            echo twig_escape_filter($this->env, $context['value'], 'html', null, true);
                            echo '
                                </div>
                            ';
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 19
                        echo '                        ';
                    }
                    // line 20
                    echo '                    ';
                }
                // line 21
                echo '               ';
            }
            // line 22
            echo '               ';
            if (('Message' == (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')))) {
                // line 23
                echo '                   ';
                if ((((null === (isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent'))) || ((1 == $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'private', array())) && ($this->getAttribute($context['oSubsCompany'], 'id', array(), 'array') == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'userCreated', array()), 'company', array()), 'id', array())))) || (0 == $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'private', array())))) {
                    echo '        
                        ';
                    // line 24
                    if ($this->getAttribute($context['oSubsCompany'], 'people', array(), 'any', true, true)) {
                        // line 25
                        echo '                            <div class="col-md-12  without-padding"> <input type="checkbox" class="input-subscribed-company" data-id="';
                        echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'id', array(), 'array'), 'html', null, true);
                        echo '">  <strong>All of ';
                        echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'name', array(), 'array'), 'html', null, true);
                        echo '</strong></div>
                            ';
                        // line 26
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oSubsCompany'], 'people', array(), 'array'));
                        foreach ($context['_seq'] as $context['key'] => $context['value']) {
                            // line 27
                            echo '                                <div class="col-md-3  without-padding">
                                    <input ';
                            // line 28
                            if (twig_in_filter($context['key'], twig_get_array_keys_filter((isset($context['activeSubscribed']) ? $context['activeSubscribed'] : $this->getContext($context, 'activeSubscribed'))))) {
                                echo ' checked ';
                            }
                            echo ' class="input-people-subscribed" name="aSubspeople[';
                            echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                            echo ']" type="checkbox"  data-company-id=';
                            echo twig_escape_filter($this->env, $this->getAttribute($context['oSubsCompany'], 'id', array(), 'array'), 'html', null, true);
                            echo '  value="';
                            echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                            echo '">  ';
                            echo twig_escape_filter($this->env, $context['value'], 'html', null, true);
                            echo '
                                </div>
                            ';
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 31
                        echo '                        ';
                    }
                    // line 32
                    echo '                    ';
                }
                // line 33
                echo '               ';
            }
            // line 34
            echo '        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oSubsCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo '    
    </div>
</div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (137 => 34,  134 => 33,  131 => 32,  128 => 31,  109 => 28,  106 => 27,  102 => 26,  95 => 25,  93 => 24,  88 => 23,  85 => 22,  82 => 21,  79 => 20,  76 => 19,  57 => 16,  54 => 15,  50 => 14,  43 => 13,  41 => 12,  36 => 11,  33 => 10,  29 => 9,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\SubscribeEmail\comments_notification-sidebar.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="title-panel">Comment Notification</div>
';
        // line 2
        if ((false == twig_in_filter($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), twig_get_array_keys_filter($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'activeSubscribed', array()))))) {
            // line 3
            echo '    <div class="panel-offer panel-subscribed"><strong>
            <a href="';
            // line 4
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_subscribe_email_add', array('parent' => $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'id', array()), 'project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'type' => (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')))), 'html', null, true);
            echo '">
                Subscribe to this ';
            // line 5
            if (('Message' == (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')))) {
                echo ' message ';
            } else {
                echo ' to-do ';
            }
            // line 6
            echo '            </a>
        </strong> to receive an email when new comments are posted.</div>
';
        }
        // line 9
        echo '<div class="info-panel">
    ';
        // line 10
        if ($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'activeSubscribed', array())) {
            // line 11
            echo '        These people are subscribed to receive email notifications when new comments are posted.
        <div class="subscribed-users-info">
            ';
            // line 13
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'activeSubscribed', array(0 => 'company-info'), 'method'));
            foreach ($context['_seq'] as $context['key'] => $context['oCompanySubscribed']) {
                // line 14
                echo '                <div class="company-subscribed">';
                echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                echo '</div>
                <ul>
                    ';
                // line 16
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($context['oCompanySubscribed']);
                foreach ($context['_seq'] as $context['key'] => $context['val']) {
                    // line 17
                    echo '                        ';
                    if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()) == $context['key'])) {
                        // line 18
                        echo '                            <li>You  
                                <span>
                                    (<a href="';
                        // line 20
                        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_subscribe_email_remove', array('parent' => $this->getAttribute((isset($context['oParent']) ? $context['oParent'] : $this->getContext($context, 'oParent')), 'id', array()), 'project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')), 'type' => (isset($context['type']) ? $context['type'] : $this->getContext($context, 'type')))), 'html', null, true);
                        echo '">Unsubscribe</a>)
                                </span>
                            </li>
                            ';
                    } else {
                        // line 24
                        echo '                            <li>';
                        echo twig_escape_filter($this->env, $context['val'], 'html', null, true);
                        echo '</li>
                            ';
                    }
                    // line 26
                    echo '                        ';
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 27
                echo '                </ul>
            ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['oCompanySubscribed'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 29
            echo '        </div>
    ';
        } else {
            // line 31
            echo "        If you post a comment you'll automatically be subscribed to receive email notifications.
    ";
        }
        // line 32
        echo '   
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (106 => 32,  102 => 31,  98 => 29,  91 => 27,  85 => 26,  79 => 24,  72 => 20,  68 => 18,  65 => 17,  61 => 16,  55 => 14,  51 => 13,  47 => 11,  45 => 10,  42 => 9,  37 => 6,  31 => 5,  27 => 4,  24 => 3,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\add.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, (isset($context['nameProject']) ? $context['nameProject'] : $this->getContext($context, 'nameProject')), 'html', null, true);
        echo ' - New to-do list
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo ' 
';
        // line 6
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo '  
<div class="row">
    <div class="panel panel-default col-md-9">
        <div class="panel-heading">
            New to-do list
        </div>
        <div class="panel-body">
            <div class="row">
                ';
            // line 14
            $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
            // line 15
            echo '                ';
            if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
                // line 16
                echo '                    <div class="alert alert-error error" role="alert">';
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
                echo '</div>
                ';
            }
            // line 18
            echo '                <div class="panel-forms form-edit-project">
                    <form action="';
            // line 19
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_add', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
            echo '"  method="Post">
                        <h4>First give the list a name <small> (e.g. "Things for the meeting")</small></h4>
                        <div class="col-xs-11 form-group">   
                            ';
            // line 22
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'widget');
            echo '
                        </div>
                        <div class="col-xs-11 optional-features">
                            <h1>Optional features</h1>
                            <div class="col-md-12 form-group">
                                ';
            // line 27
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'is_time_tracker', array()), 'widget');
            echo '  
                                Enable time tracking for this list
                            </div>
                            <div class="col-md-12 form-group">
                                ';
            // line 31
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'visible_client', array()), 'widget');
            echo '  
                                Visible to company client
                            </div>
                            <div class="col-md-12 form-group">
                                ';
            // line 35
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'visible_freelancer', array()), 'widget');
            echo '  
                                Visible to company freelancer
                            </div> 
                            <p>List description or notes about this list </p>
                            <div class="col-xs-12 form-group">
                                ';
            // line 40
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
            echo '
                            </div>
                        </div>
                        ';
            // line 43
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
            echo '
                        <div class="col-xs-12 btn-action">
                            <button class="btn btn-sm btn-primary btn-save" type="submit">Create this list</button>
                            <span>or</span> <a class="btn-cancel" href="';
            // line 46
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_todos', array('project' => (isset($context['slugProject']) ? $context['slugProject'] : $this->getContext($context, 'slugProject')))), 'html', null, true);
            echo '"> Cancel </a> 
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>                          
</div>
';
        }
        // line 54
        echo '                            
';
    }

    // line 56
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 57
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
';
    }

    // line 59
    public function block_javascripts($context, array $blocks = array())
    {
        // line 60
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 61
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 62
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (166 => 62,  162 => 61,  157 => 60,  154 => 59,  147 => 57,  144 => 56,  139 => 54,  127 => 46,  121 => 43,  115 => 40,  107 => 35,  100 => 31,  93 => 27,  85 => 22,  79 => 19,  76 => 18,  70 => 16,  67 => 15,  65 => 14,  54 => 6,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="edit-task">
    <div class="panel-forms"> 
        <form action="';
        // line 3
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_edit', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
        echo '"  method="Post">
            <div class="col-xs-10 form-group">
                <div class="col-md-12 form-group">
                    ';
        // line 6
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'name', array()), 'widget');
        echo '
                </div>    
                <div class="col-md-12 form-group">
                    ';
        // line 9
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'is_time_tracker', array()), 'widget');
        echo '  
                    Enable time tracking for this list
                </div>
                <div class="col-md-12 form-group">
                    ';
        // line 13
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'visible_client', array()), 'widget');
        echo '  
                    Visible to company client
                </div>
                <div class="col-md-12 form-group">
                    ';
        // line 17
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'visible_freelancer', array()), 'widget');
        echo '  
                    Visible to company freelancer
                </div> 
                <div class="col-md-12 form-group">
                    <p>List description:</p>
                    ';
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
        echo '
                </div>
                ';
        // line 24
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                <div class="col-md-12 btn-action">
                    <button class="btn btn-sm btn-primary btn-save" type="submit">Save changes</button>
                    <span>or</span> <a class="btn-cancel" href="';
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_todos', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()))), 'html', null, true);
        echo '"> Cancel </a> 
                </div>
            </div>
        </form>
    </div>
</div>            ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (68 => 27,  62 => 24,  57 => 22,  49 => 17,  42 => 13,  35 => 9,  29 => 6,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\empty-todos.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - To-do lists
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '    <div class="row blank-slate">
        <div class="modal-dialog">
            <div class="col-md-4">
                <img src="';
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/blankslate-icon-todos.png'), 'html', null, true);
        echo '">
            </div>
            <div class="col-md-8">
                <h1>Make the first to-do list and get organized.</h1>
                <p>To-dos help you keep track of all the little things that need to get done. You can add them for yourself or assign them to someone else.</p>
                ';
        // line 14
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo '  
                <div class="btn-add-new-task">
                    <a href="';
            // line 16
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '" class="btn btn-default btn-md">
                        <i class="glyphicon glyphicon-plus"></i> Create new to-do list
                    </a>
                </div>
                ';
        }
        // line 20
        echo ' 
            </div>
        </div>
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (76 => 20,  68 => 16,  63 => 14,  55 => 9,  50 => 6,  47 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\filter.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<form id="form-filter-tasks" method="GET" action="#">        
<h4>Show to-dos assigned to </h4>
    ';
        // line 3
        if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'aFilterTask'), 'method') && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'aFilterTask'), 'method'), 'filter_responsible', array(), 'array'))) {
            echo ' 
        ';
            // line 4
            $context['filter_responsible'] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'session', array()), 'get', array(0 => 'aFilterTask'), 'method'), 'filter_responsible', array(), 'array');
            // line 5
            echo '    ';
        } else {
            // line 6
            echo '        ';
            $context['filter_responsible'] = '';
            // line 7
            echo '    ';
        }
        // line 8
        echo '    <div>
    <select id="filter_tasks_filter_responsible" name="filter_tasks[filter_responsible]" class="form-control">
        <option value="">Anyone</option>
        <option ';
        // line 11
        if (((isset($context['filter_responsible']) ? $context['filter_responsible'] : $this->getContext($context, 'filter_responsible')) == ('u_'.$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array())))) {
            echo ' selected ';
        }
        echo ' value="u_';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), 'html', null, true);
        echo '">Me (';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
        echo ')</option>
        <option disabled value="">----------</option>
        ';
        // line 13
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aResponsiblepeople']) ? $context['aResponsiblepeople'] : $this->getContext($context, 'aResponsiblepeople')));
        foreach ($context['_seq'] as $context['_key'] => $context['oResponsibleCompany']) {
            // line 14
            echo '            ';
            if ($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'any', true, true)) {
                // line 15
                echo '                ';
                if (((twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array')) > 1) || ((1 == twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))) && (false == twig_in_filter($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), twig_get_array_keys_filter($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))))))) {
                    // line 16
                    echo '                    <option  ';
                    if ((('c_'.$this->getAttribute($context['oResponsibleCompany'], 'id', array(), 'array')) == (isset($context['filter_responsible']) ? $context['filter_responsible'] : $this->getContext($context, 'filter_responsible')))) {
                        echo ' selected ';
                    }
                    echo ' value="c_';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'id', array(), 'array'), 'html', null, true);
                    echo '">';
                    echo twig_escape_filter($this->env, twig_upper_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'name', array(), 'array')), 'html', null, true);
                    echo '</option>
                    ';
                    // line 17
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'));
                    foreach ($context['_seq'] as $context['key'] => $context['val']) {
                        // line 18
                        echo '                        ';
                        if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()) != $context['key'])) {
                            // line 19
                            echo '                            <option ';
                            if ((('u_'.$context['key']) == (isset($context['filter_responsible']) ? $context['filter_responsible'] : $this->getContext($context, 'filter_responsible')))) {
                                echo ' selected ';
                            }
                            echo '  value=u_';
                            echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                            echo ' >';
                            echo twig_escape_filter($this->env, $context['val'], 'html', null, true);
                            echo '</option>
                        ';
                        }
                        // line 21
                        echo '                    ';
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 22
                    echo '                    <option disabled value="">----------</option>
                ';
                }
                // line 24
                echo '            ';
            }
            // line 25
            echo '        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oResponsibleCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo '      </select>
    </div>    
<h4>Show to-dos that are due</h4>   
';
        // line 29
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fFilterTask']) ? $context['fFilterTask'] : $this->getContext($context, 'fFilterTask')), 'filter_due', array()), 'widget');
        echo '
</form>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (120 => 29,  115 => 26,  109 => 25,  106 => 24,  102 => 22,  96 => 21,  84 => 19,  81 => 18,  77 => 17,  66 => 16,  63 => 15,  60 => 14,  56 => 13,  43 => 11,  38 => 8,  35 => 7,  32 => 6,  29 => 5,  27 => 4,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\list.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - To-do lists
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '<div class="row">
    <div class="panel panel-default col-md-9">
        <div class="panel-heading col-xs-12">
            <div class="col-xs-6">
                To-do lists
            </div>
            
            <div class="page_header_links col-xs-6">
                <a href="';
        // line 14
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_my_todos');
        echo '">my To-DoS</a> 
                ';
        // line 15
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            // line 16
            echo '                    |<a class="remove" href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_todos', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'action' => 'reorder')), 'html', null, true);
            echo '">Reorder lists</a>
                ';
        }
        // line 18
        echo '            </div>
            
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 list-task">
                    ';
        // line 24
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'tasks', array(0 => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter'))), 'method'));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oTask']) {
            // line 25
            echo '                        <div data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'id', array()), 'html', null, true);
            echo '" class="task col-md-12">
                            <div class="show-task">
                                ';
            // line 27
            $this->env->loadTemplate('WWSCThalamusBundle:Task:task-block.html.twig')->display(array_merge($context, array('oTask' => $context['oTask'], 'aFilter' => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter')), 'lCompletedItems' => 3)));
            // line 28
            echo '                            </div>
                        </div>
                    ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oTask'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        echo ' 
                </div><!--/span-->
            </div>
        </div>
    </div>            
    <div class="col-md-3 sidebar sidebar-filter"> 
        <div class="col">
            ';
        // line 37
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo ' 
            <div class="btn-add-new-task">
                <a href="';
            // line 39
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '" class="btn btn-default btn-md">
                    <i class="glyphicon glyphicon-plus"></i> Create new to-do list
                </a>
            </div>
            ';
        }
        // line 43
        echo '         
            ';
        // line 44
        $this->env->loadTemplate('WWSCThalamusBundle:Task:filter.html.twig')->display(array_merge($context, array('slugProject' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'aResponsiblepeople' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'subspeople', array()))));
        // line 45
        echo '            <h4>Current to-do lists</h4>    
            <ul class="filter-task">
              ';
        // line 47
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'tasks', array(0 => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter'))), 'method'));
        foreach ($context['_seq'] as $context['_key'] => $context['oTask']) {
            // line 48
            echo '                      <li data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'id', array()), 'html', null, true);
            echo '" ><a href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_show', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'id' => $this->getAttribute($context['oTask'], 'id', array()))), 'html', null, true);
            echo '">';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'name', array()), 'html', null, true);
            echo '</a></li>
              ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oTask'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 49
        echo ' 
            </ul>
        </div>
    </div><!--/span-->          
</div>
';
    }

    // line 55
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 56
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/css/bootstrap-datepicker.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />    
';
    }

    // line 59
    public function block_javascripts($context, array $blocks = array())
    {
        // line 60
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 61
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 62
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 63
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/todos.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/bootstrap-datepicker.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (214 => 64,  210 => 63,  206 => 62,  202 => 61,  197 => 60,  194 => 59,  188 => 57,  183 => 56,  180 => 55,  171 => 49,  158 => 48,  154 => 47,  150 => 45,  148 => 44,  145 => 43,  137 => 39,  132 => 37,  123 => 30,  107 => 28,  105 => 27,  99 => 25,  82 => 24,  74 => 18,  68 => 16,  66 => 15,  62 => 14,  52 => 6,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\my-todos.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    my To-DoS
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '<div class="row">
    <div class="panel panel-default col-md-12">
        <div class="panel-heading col-xs-12">
            <div class="col-xs-12">
                my To-DoS
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
               ';
        // line 15
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'getProjects', array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oProject']) {
            // line 16
            echo '                  ';
            if ((twig_length_filter($this->env, $this->getAttribute($context['oProject'], 'tasks', array(0 => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter'))), 'method')) > 0)) {
                // line 17
                echo '                   <div class="col-md-12 project-title-todos">
                        <h3>
                            <a href="';
                // line 19
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_todos', array('project' => $this->getAttribute($context['oProject'], 'slug', array()))), 'html', null, true);
                echo '?filter_tasks[filter_responsible]=';
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), 'html', null, true);
                echo '&filter_tasks[filter_due]=#"> 
                                ';
                // line 20
                echo twig_escape_filter($this->env, $this->getAttribute($context['oProject'], 'name', array()), 'html', null, true);
                echo '
                            </a>
                        </h3>
                    </div>
                    <div class="col-md-12 list-task">
                        ';
                // line 25
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oProject'], 'tasks', array(0 => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter'))), 'method'));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index' => 1,
                  'first' => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context['_key'] => $context['oTask']) {
                    // line 26
                    echo '                            <div data-id="';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'id', array()), 'html', null, true);
                    echo '" class="task col-md-12">
                                <div class="show-task">
                                    ';
                    // line 28
                    $this->env->loadTemplate('WWSCThalamusBundle:Task:task-block.html.twig')->display(array_merge($context, array('oTask' => $context['oTask'], 'aFilter' => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter')), 'lCompletedItems' => 3)));
                    // line 29
                    echo '                                </div>
                            </div>
                        ';
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oTask'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 31
                echo ' 
                    </div><!--/span-->
                    ';
            }
            // line 34
            echo '                ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oProject'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo '     
            </div>
        </div>
    </div>                  
</div>
';
    }

    // line 40
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 41
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 42
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/css/bootstrap-datepicker.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />    
';
    }

    // line 44
    public function block_javascripts($context, array $blocks = array())
    {
        // line 45
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/todos.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/bootstrap-datepicker.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (201 => 49,  197 => 48,  193 => 47,  189 => 46,  184 => 45,  181 => 44,  175 => 42,  170 => 41,  167 => 40,  145 => 34,  140 => 31,  124 => 29,  122 => 28,  116 => 26,  99 => 25,  91 => 20,  85 => 19,  81 => 17,  78 => 16,  61 => 15,  50 => 6,  47 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\reorder-list.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - Reorder lists
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo ' 
<div class="row">
    <div class="panel panel-default col-md-9">
        <div class="panel-heading col-xs-12">
            <div class="col-xs-6">
                To-do lists
            </div>
            <div class="page_header_links col-xs-6">
                <a class="remove" href="';
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_todos', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '">Done reordering list</a>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div data-sort-url="';
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_change_sort_elements', array('type' => 'Task', 'field' => 'project', 'value' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'id', array()))), 'html', null, true);
        echo '" class="col-md-12 list-task sort-elements">
                    ';
        // line 19
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'tasks', array()));
        foreach ($context['_seq'] as $context['_key'] => $context['oTask']) {
            // line 20
            echo '                        <div data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'id', array()), 'html', null, true);
            echo '" class="task col-md-12">
                            <img class="btn-sort" src="';
            // line 21
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/sort_icon.png'), 'html', null, true);
            echo '">
                            <a class="title" href="';
            // line 22
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_show', array('project' => $this->getAttribute($this->getAttribute($context['oTask'], 'project', array()), 'slug', array()), 'id' => $this->getAttribute($context['oTask'], 'id', array()))), 'html', null, true);
            echo '">
                                ';
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'name', array()), 'html', null, true);
            echo '
                            </a>
                        </div>         
                    ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oTask'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        echo ' 
                </div><!--/span-->
            </div>
        </div>
    </div>            
    <div class="col-md-3 sidebar sidebar-filter">
        <div class="col">
           ';
        // line 33
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo '  
           <div class="btn-add-new-task">
                <a href="';
            // line 35
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_add', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '" class="btn btn-default btn-md">
                    <i class="glyphicon glyphicon-plus"></i> Create new to-do list
                </a>
            </div>
            ';
        }
        // line 39
        echo ' 
            <h4>Current to-do lists</h4>    
            <ul class="filter-task">
              ';
        // line 42
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'tasks', array()));
        foreach ($context['_seq'] as $context['_key'] => $context['oTask']) {
            // line 43
            echo '                  <li data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'id', array()), 'html', null, true);
            echo '" ><a href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_show', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'id' => $this->getAttribute($context['oTask'], 'id', array()))), 'html', null, true);
            echo '">';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'name', array()), 'html', null, true);
            echo '</a></li>
              ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oTask'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo ' 
            </ul>
        </div>
    </div><!--/span-->          
</div>
';
    }

    // line 50
    public function block_javascripts($context, array $blocks = array())
    {
        // line 51
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/todos.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (155 => 51,  152 => 50,  143 => 44,  130 => 43,  126 => 42,  121 => 39,  113 => 35,  108 => 33,  99 => 26,  89 => 23,  85 => 22,  81 => 21,  76 => 20,  72 => 19,  68 => 18,  60 => 13,  48 => 5,  41 => 3,  38 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\search-task-form.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<form method="POST" class="search-task-form" action="';
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_search_task_by_id');
        echo '">
    <input  type="text"  size="6" class="search-task-id" name="search-task-id"  placeholder="Task id">
</form>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\show.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'name', array()), 'html', null, true);
        echo ' - To-do list
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo ' 
<div class="row">
    <div class="panel panel-default col-md-9">
        <div class="panel-heading col-xs-12">
            <div class="col-xs-6">
                <a href="';
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_todos', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()))), 'html', null, true);
        echo '">See all to-do lists</a>
            </div>
            <div class="page_header_links col-xs-6">
                <a href="';
        // line 13
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_my_todos');
        echo '">my To-DoS</a>
                ';
        // line 14
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            // line 15
            echo '                    |<a class="remove" href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_delete', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
            echo '">Delete this list</a>
                ';
        }
        // line 17
        echo '            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 list-task">
                        <div class="task col-md-12">
                            <div class="show-task">
                                ';
        // line 24
        $this->env->loadTemplate('WWSCThalamusBundle:Task:task-block.html.twig')->display(array_merge($context, array('oTask' => (isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'aFilter' => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter')), 'lCompletedItems' => false)));
        // line 25
        echo '                            </div>
                        </div>         
                </div><!--/span-->
            </div>
        </div>
    </div>            
    <div class="col-md-3 sidebar sidebar-filter">
        <div class="col">
            ';
        // line 33
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo ' 
            <div class="btn-add-new-task">
                <a href="';
            // line 35
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_add', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()))), 'html', null, true);
            echo '" class="btn btn-default btn-md">
                    <i class="glyphicon glyphicon-plus"></i> Create new to-do list
                </a>
            </div>
            ';
        }
        // line 39
        echo '         
            ';
        // line 40
        $this->env->loadTemplate('WWSCThalamusBundle:Task:filter.html.twig')->display(array_merge($context, array('aTask' => (isset($context['aTasks']) ? $context['aTasks'] : $this->getContext($context, 'aTasks')), 'slugProject' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'aResponsiblepeople' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'subspeople', array()))));
        // line 41
        echo '            <h4>Current to-do lists</h4>    
            <ul class="filter-task">
              ';
        // line 43
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aTasks']) ? $context['aTasks'] : $this->getContext($context, 'aTasks')));
        foreach ($context['_seq'] as $context['_key'] => $context['oTask']) {
            // line 44
            echo '                     <li data-id="';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'id', array()), 'html', null, true);
            echo '" ><a href="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_show', array('project' => $this->getAttribute($this->getAttribute($context['oTask'], 'project', array()), 'slug', array()), 'id' => $this->getAttribute($context['oTask'], 'id', array()))), 'html', null, true);
            echo '">';
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTask'], 'name', array()), 'html', null, true);
            echo '</a></li>
              ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oTask'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 45
        echo ' 
            </ul>
        </div>
    </div><!--/span-->          
</div>
';
    }

    // line 51
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 52
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/css/bootstrap-datepicker.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />    
';
    }

    // line 55
    public function block_javascripts($context, array $blocks = array())
    {
        // line 56
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 58
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 59
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/todos.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 60
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/bootstrap-datepicker.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (179 => 60,  175 => 59,  171 => 58,  167 => 57,  162 => 56,  159 => 55,  153 => 53,  148 => 52,  145 => 51,  136 => 45,  123 => 44,  119 => 43,  115 => 41,  113 => 40,  110 => 39,  102 => 35,  97 => 33,  87 => 25,  85 => 24,  76 => 17,  70 => 15,  68 => 14,  64 => 13,  58 => 10,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\task-block.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="task-box">
    ';
        // line 2
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo ' 
    <div class="actions-panel">
        <a class="btn-delete-task" href=';
            // line 4
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_delete', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
            echo '><img src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/remove_icon.png'), 'html', null, true);
            echo '"></a>
        <a class="btn-edit-task" href=';
            // line 5
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_edit', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
            echo '>Edit</a>
    </div>
    ';
        }
        // line 8
        echo '    <div class="task-info">
        ';
        // line 9
        $this->env->loadTemplate('WWSCThalamusBundle:Task:task-info.html.twig')->display(array_merge($context, array('oTask' => (isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')))));
        // line 10
        echo '    </div>
</div>
<div data-sort-url=';
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_change_sort_elements', array('type' => 'TaskItem', 'field' => 'task', 'value' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
        echo ' class="list-task-items open-task-items sort-elements">
    ';
        // line 13
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'items', array(0 => false, 1 => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter'))), 'method'));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oItem']) {
            // line 14
            echo '        ';
            $this->env->loadTemplate('WWSCThalamusBundle:TaskItem:open-item-show.html.twig')->display(array_merge($context, array('oItem' => $context['oItem'])));
            // line 15
            echo '    ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oItem'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo '</div>
<div class="col-md-12">
    ';
        // line 18
        if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || $this->env->getExtension('security')->isGranted('ROLE_CLIENT'))) {
            echo '  
    <div class="task-item-add col-md-12">
        <div class="col-md-12 btn-add-new-item"> 
            <a href=';
            // line 21
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_add', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'task' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
            echo '> Add an item </a>
        </div>
    </div>
    ';
        }
        // line 24
        echo '    
</div>    
<div class="list-task-items close-task-items">
    ';
        // line 27
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'items', array(0 => true, 1 => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter')), 2 => (isset($context['lCompletedItems']) ? $context['lCompletedItems'] : $this->getContext($context, 'lCompletedItems'))), 'method'));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index' => 1,
          'first' => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['oItem']) {
            // line 28
            echo '        ';
            $this->env->loadTemplate('WWSCThalamusBundle:TaskItem:close-item-show.html.twig')->display(array_merge($context, array('oItem' => $context['oItem'])));
            // line 29
            echo '    ';
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oItem'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        echo '    ';
        if (( !twig_test_empty((isset($context['lCompletedItems']) ? $context['lCompletedItems'] : $this->getContext($context, 'lCompletedItems'))) && (twig_length_filter($this->env, $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'items', array(0 => true, 1 => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter'))), 'method')) > 3))) {
            echo ' 
        <a class="view_all_completed_items" href="';
            // line 31
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_show', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
            echo '">View all ';
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'items', array(0 => true, 1 => (isset($context['aFilter']) ? $context['aFilter'] : $this->getContext($context, 'aFilter'))), 'method')), 'html', null, true);
            echo ' completed items</a> 
    ';
        }
        // line 32
        echo ' 
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (154 => 32,  147 => 31,  142 => 30,  128 => 29,  125 => 28,  108 => 27,  103 => 24,  96 => 21,  90 => 18,  86 => 16,  72 => 15,  69 => 14,  52 => 13,  48 => 12,  44 => 10,  42 => 9,  39 => 8,  33 => 5,  27 => 4,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\Task\task-info.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="title">
    <a class="name" href="';
        // line 2
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_show', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
        echo '">';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'name', array()), 'html', null, true);
        echo '</a>
    ';
        // line 3
        if (((0 == $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'visibleClient', array())) && (0 == $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'visibleFreelancer', array())))) {
            echo ' 
        <span class="private"> private </span>
    ';
        }
        // line 6
        echo '</div>
';
        // line 7
        if ($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'description', array())) {
            echo ' 
    <div class="description">
        ';
            // line 9
            echo $this->env->getExtension('markdown')->markdown($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'description', array()));
            echo '
    </div>
';
        }
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (42 => 9,  37 => 7,  34 => 6,  28 => 3,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\add.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="task-item-form from-group col-md-12">
    <div class="col-md-10">
        <div class="alert-error"></div>
        <form accept-charset="UTF-8" action="';
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_add', array('project' => $this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'slug', array()), 'task' => $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'id', array()))), 'html', null, true);
        echo '" class="todo_item" method="post">
            <div class="col-md-12">
                Enter a to-do item
                ';
        // line 7
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
        echo "
            </div>
            <div class=\"col-md-12 without-padding\">
                <div class=\"col-md-6\">
                    Who's responsible?
                    <select id=\"wwsc_thalamusbundle_task_item_responsible\" name=\"wwsc_thalamusbundle_task_item[responsible]\" class=\"form-control\">
                        <option value=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), 'html', null, true);
        echo '">Me (';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
        echo ')</option>
                        <option disabled value="">----------</option>
                        ';
        // line 15
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'project', array()), 'subspeople', array()));
        foreach ($context['_seq'] as $context['_key'] => $context['oResponsibleCompany']) {
            // line 16
            echo '                            ';
            if (((('ROLE_PROVIDER' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array')) || ((1 == $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'visibleClient', array())) && ('ROLE_CLIENT' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array')))) || ((1 == $this->getAttribute((isset($context['oTask']) ? $context['oTask'] : $this->getContext($context, 'oTask')), 'visibleFreelancer', array())) && ('ROLE_FREELANCER' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array'))))) {
                // line 17
                echo '                                ';
                if ($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'any', true, true)) {
                    // line 18
                    echo '                                    ';
                    if (((twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array')) > 1) || ((1 == twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))) && (false == twig_in_filter($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), twig_get_array_keys_filter($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))))))) {
                        // line 19
                        echo '                                        <option disabled value="">';
                        echo twig_escape_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'name', array(), 'array'), 'html', null, true);
                        echo '</option>
                                        ';
                        // line 20
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'));
                        foreach ($context['_seq'] as $context['key'] => $context['val']) {
                            // line 21
                            echo '                                            ';
                            if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()) != $context['key'])) {
                                // line 22
                                echo '                                                <option  value=';
                                echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                                echo ' >';
                                echo twig_escape_filter($this->env, $context['val'], 'html', null, true);
                                echo '</option>
                                            ';
                            }
                            // line 24
                            echo '                                        ';
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 25
                        echo '                                        <option disabled value="">----------</option>
                                    ';
                    }
                    // line 27
                    echo '                                ';
                }
                // line 28
                echo '                            ';
            }
            echo '    
                        ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oResponsibleCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        echo '                    </select>
                </div>
                <div class="col-md-6">
                    Related
                    ';
        // line 34
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'related', array()), 'widget');
        echo '
                </div>
                <div class="col-md-6">
                    Status
                    ';
        // line 38
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'state', array()), 'widget');
        echo '
                </div>
                <div class="col-md-6">
                    When is it due?
                    ';
        // line 42
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'due_date_form', array()), 'widget');
        echo '
                </div>
                <div class="col-md-12 input-fast-track">
                    ';
        // line 45
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'fast_track', array()), 'widget');
        echo " <span>Fast-track</span>
                </div>
                <div class=\"col-md-12 form-group\">
                    <button class=\"btn btn-sm btn-primary btn-save\" type=\"submit\">Add this item</button>
                    <span>or</span>  <a class=\"btn-cancel\" href=\"#\"> I'm done adding items </a>
                </div>
            </div>
            ";
        // line 52
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
        </form>
    </div>
</div>

';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (139 => 52,  129 => 45,  123 => 42,  116 => 38,  109 => 34,  103 => 30,  94 => 28,  91 => 27,  87 => 25,  81 => 24,  73 => 22,  70 => 21,  66 => 20,  61 => 19,  58 => 18,  55 => 17,  52 => 16,  48 => 15,  39 => 13,  30 => 7,  24 => 4,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\close-item-show.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="task-item col-md-12">
    <div class="show-task-item">
        ';
        // line 3
        if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || $this->env->getExtension('security')->isGranted('ROLE_CLIENT'))) {
            echo ' 
        <div class="actions-panel">
            <a class="btn-delete-task-item" href=';
            // line 5
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_delete', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
            echo '><img src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/remove_icon.png'), 'html', null, true);
            echo '"></a>
        </div>
        ';
        }
        // line 7
        echo ' 
        <div class="task-item-info">
            ';
        // line 9
        $this->env->loadTemplate('WWSCThalamusBundle:TaskItem:task-item-close-info.html.twig')->display(array_merge($context, array('oItem' => (isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')))));
        // line 10
        echo '        </div>
    </div>
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (42 => 10,  40 => 9,  36 => 7,  28 => 5,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\comment-title-close-item.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<span class="close-item comments-title">
    <span>
        ';
        // line 3
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            // line 4
            echo '            <input type="checkbox" checked class="task-item-status"
                   data-url="';
            // line 5
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_change_status', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'status' => 0)), 'html', null, true);
            echo '"
                   name="task_item_status[';
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'html', null, true);
            echo ']">
        ';
        } else {
            // line 8
            echo '            <input type="checkbox" checked disabled>
        ';
        }
        // line 10
        echo '    </span>
    <span class="updated"> ';
        // line 11
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'updated', array()), 'd M'), 'html', null, true);
        echo '  </span> 
    <span class="responsible"> ';
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'responsible', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'responsible', array()), 'lastName', array()), 'html', null, true);
        echo ' :</span> 
    <span class="description ';
        // line 13
        echo ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'fastTrack', array())) ? ('fast-track') : ('');
        echo ' ">';
        echo ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'fastTrack', array())) ? ('[FAST-TRACK]') : ('');
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'description', array()), 'html', null, true);
        echo '</span>
    ';
        // line 14
        if (((1 == $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'isTimeTracker', array())) && $this->env->getExtension('security')->isGranted('ROLE_PROVIDER'))) {
            // line 15
            echo '         <span data-url = ';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_comments_reported_hours', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
            echo '   id="sumReportedHours" >( reported:  ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'sumHoursTimeTracker', array()), 'html', null, true);
            echo '  hr)</span>
    ';
        }
        // line 17
        echo '</span>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (72 => 17,  64 => 15,  62 => 14,  54 => 13,  48 => 12,  44 => 11,  41 => 10,  37 => 8,  32 => 6,  28 => 5,  25 => 4,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\comment-title-open-item.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<span class="comments-title">
    <span>
        ';
        // line 3
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            // line 4
            echo '            <input type="checkbox"
                   class="task-item-status"
                   data-url="';
            // line 6
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_change_status', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'status' => 1)), 'html', null, true);
            echo '"
                   name="task_item_status[';
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'html', null, true);
            echo ']">
        ';
        } else {
            // line 9
            echo '            <input type="checkbox" disabled>
        ';
        }
        // line 11
        echo '    </span>
    <span class="responsible"> ';
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'responsible', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'responsible', array()), 'lastName', array()), 'html', null, true);
        echo ' : </span>
    <span class="description ';
        // line 13
        echo ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'fastTrack', array())) ? ('fast-track') : ('');
        echo ' ">';
        echo ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'fastTrack', array())) ? ('[FAST-TRACK]') : ('');
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'description', array()), 'html', null, true);
        echo ' </span>
    ';
        // line 14
        if ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'dueDate', array())) {
            echo ' ';
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'dueDate', array()), 'd M Y'), 'html', null, true);
            echo '
        <span class="due"> Due  ';
            // line 15
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'dueDate', array()), 'd M Y'), 'html', null, true);
            echo '</span>
    ';
        }
        // line 16
        echo ' 
    ';
        // line 17
        if (((1 == $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'isTimeTracker', array())) && $this->env->getExtension('security')->isGranted('ROLE_PROVIDER'))) {
            // line 18
            echo '        <span data-url =';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_comments_reported_hours', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
            echo '   id="sumReportedHours">( reported:  <span>';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'sumHoursTimeTracker', array()), 'html', null, true);
            echo '</span>  hr)</span>
    ';
        }
        // line 20
        echo '</span>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (83 => 20,  75 => 18,  73 => 17,  70 => 16,  65 => 15,  59 => 14,  51 => 13,  45 => 12,  42 => 11,  38 => 9,  33 => 7,  29 => 6,  25 => 4,  23 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\comments.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'name', array()), 'html', null, true);
        echo ' - Comments
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo '    <div class="row">
        <div class="panel panel-default col-md-9 task-item-comments-wrapper">
            <div class="panel-heading col-xs-12">
                <div class="col-xs-12">
                   Comments on this to-do (TID: ';
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'html', null, true);
        echo ') from      
                   <span class="link_task_list">  <a href="';
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_show', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'id' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()))), 'html', null, true);
        echo '"> ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'name', array()), 'html', null, true);
        echo '</a></span>
                </div>
                <div class="col-xs-12">
                    ';
        // line 14
        if ((1 == $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'status', array()))) {
            // line 15
            echo '                        <div class="info-panel comment-title-item close-item">
                            ';
            // line 16
            $this->env->loadTemplate('WWSCThalamusBundle:TaskItem:comment-title-close-item.html.twig')->display(array_merge($context, array('oItem' => (isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')))));
            // line 17
            echo '                        </div>
                    ';
        } else {
            // line 19
            echo '                        <div class="info-panel comment-title-item">
                            ';
            // line 20
            $this->env->loadTemplate('WWSCThalamusBundle:TaskItem:comment-title-open-item.html.twig')->display(array_merge($context, array('oItem' => (isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')))));
            // line 21
            echo '                        </div>
                    ';
        }
        // line 23
        echo '                </div>    
            </div>
            <div class="panel-body">
                <div class="row">
                     ';
        // line 27
        $this->env->loadTemplate('WWSCThalamusBundle:Comment:list.html.twig')->display(array_merge($context, array('slugProject' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'aComment' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'comments', array()), 'type' => 'TaskItem', 'parent' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))));
        // line 28
        echo '                </div>
            </div>
        </div>            
        <div class="col-md-3 sidebar">
            <div class="col">
                <div class="comments_notification-sidebar">
                    ';
        // line 34
        $this->env->loadTemplate('WWSCThalamusBundle:SubscribeEmail:comments_notification-sidebar.html.twig')->display(array_merge($context, array('slugProject' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'oParent' => (isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'type' => 'TaskItem')));
        // line 35
        echo '                </div>
                <div class="title-panel">Who’s talking about this to-do?</div>
                <div class="info-panel info-about-created">
                    <ul>
                        <li><strong>';
        // line 39
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'userCreated', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'userCreated', array()), 'lastName', array()), 'html', null, true);
        echo '</strong></li>
                        <li>';
        // line 40
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'userCreated', array()), 'profile', array()), 'office', array()), 'html', null, true);
        echo '</li>
                        <li>';
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'userCreated', array()), 'email', array()), 'html', null, true);
        echo '</li>
                    </ul>
                </div>  
            </div>
        </div><!--/span-->          
    </div>
 ';
        // line 47
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadTemplateAttachment.html.twig')->display($context);
        echo '            
';
    }

    // line 49
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 50
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/css/bootstrap-markdown.min.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/jQUpload/css/jquery.fileupload-ui.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />
    <link href="';
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/css/bootstrap-datepicker.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />   
';
    }

    // line 55
    public function block_javascripts($context, array $blocks = array())
    {
        // line 56
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/to-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 58
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/markdown/js/bootstrap-markdown.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 59
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/attachment.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 60
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/comment.js'), 'html', null, true);
        echo '"></script>
    ';
        // line 61
        $this->env->loadTemplate('WWSCThalamusBundle:File:jQUploadAttachmentScript.html.twig')->display($context);
        // line 62
        echo '    <script src="https://apis.google.com/js/client.js?onload=handleGoogleClientLoad"></script>
    <script src="';
        // line 63
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/bootstrap-datepicker.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 64
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/jquery.autogrow-textarea.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (194 => 64,  190 => 63,  187 => 62,  185 => 61,  181 => 60,  177 => 59,  173 => 58,  169 => 57,  164 => 56,  161 => 55,  155 => 53,  151 => 52,  147 => 51,  142 => 50,  139 => 49,  133 => 47,  124 => 41,  120 => 40,  114 => 39,  108 => 35,  106 => 34,  98 => 28,  96 => 27,  90 => 23,  86 => 21,  84 => 20,  81 => 19,  77 => 17,  75 => 16,  72 => 15,  70 => 14,  62 => 11,  58 => 10,  52 => 6,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="task-item-form from-group col-md-12">
    <div class="col-md-8">
        <div class="alert-error"></div>
        <form accept-charset="UTF-8" action="';
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_edit', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
        echo '" class="todo_item" method="post">
            <div class="col-md-12">
                ';
        // line 6
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'description', array()), 'widget');
        echo "
            </div>
            <div class=\"col-md-12 without-padding\">
                <div class=\"col-md-6\">
                    Who's responsible?
                    <select required id=\"wwsc_thalamusbundle_task_responsible\" name=\"wwsc_thalamusbundle_task_item[responsible]\" class=\"form-control\">
                            <option ";
        // line 12
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'responsible', array()), 'vars', array()), 'value', array()) == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()))) {
            echo ' selected ';
        }
        echo ' value="';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), 'html', null, true);
        echo '">Me (';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
        echo ')</option>
                            <option disabled value="">----------</option>
                            ';
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'subspeople', array()));
        foreach ($context['_seq'] as $context['_key'] => $context['oResponsibleCompany']) {
            // line 15
            echo '                                ';
            if (((('ROLE_PROVIDER' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array')) || ((1 == $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'visibleClient', array())) && ('ROLE_CLIENT' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array')))) || ((1 == $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'visibleFreelancer', array())) && ('ROLE_FREELANCER' == $this->getAttribute($context['oResponsibleCompany'], 'role', array(), 'array'))))) {
                // line 16
                echo '                                    ';
                if ($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'any', true, true)) {
                    // line 17
                    echo '                                        ';
                    if (((twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array')) > 1) || ((1 == twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))) && (false == twig_in_filter($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), twig_get_array_keys_filter($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))))))) {
                        // line 18
                        echo '                                        <option disabled value="">';
                        echo twig_escape_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'name', array(), 'array'), 'html', null, true);
                        echo '</option>
                                        ';
                        // line 19
                        $context['_parent'] = (array) $context;
                        $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'));
                        foreach ($context['_seq'] as $context['key'] => $context['val']) {
                            // line 20
                            echo '                                            ';
                            if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()) != $context['key'])) {
                                // line 21
                                echo '                                                <option ';
                                if (($context['key'] == $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'responsible', array()), 'vars', array()), 'value', array()))) {
                                    echo ' selected ';
                                }
                                echo '  value=';
                                echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                                echo ' >';
                                echo twig_escape_filter($this->env, $context['val'], 'html', null, true);
                                echo '</option>
                                            ';
                            }
                            // line 23
                            echo '                                        ';
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 24
                        echo '                                        <option disabled value="">----------</option>
                                        ';
                    }
                    // line 26
                    echo '                                    ';
                }
                // line 27
                echo '                                ';
            }
            echo '    
                            ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oResponsibleCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 29
        echo '                    </select>
                </div>
                <div class="col-md-6">
                    Related
                    ';
        // line 33
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'related', array()), 'widget');
        echo '
                </div>
                <div class="col-md-6">
                    Status
                    ';
        // line 37
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'state', array()), 'widget');
        echo '
                </div>
                <div class="col-md-6">
                    When is it due?
                    ';
        // line 41
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'due_date_form', array()), 'widget');
        echo '
                </div>
                <div class="col-md-12 input-fast-track">
                    ';
        // line 44
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'fast_track', array()), 'widget');
        echo ' <span>Fast-track</span>
                </div>
            </div>
            ';
        // line 47
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo "
            <div class=\"col-md-12\">
                <button class=\"btn btn-sm btn-primary btn-save\" type=\"submit\">Update this item</button>
                <span>or</span>  <a class=\"btn-cancel\" href=\"#\"> I'm done adding items </a>
            </div>
        </form>
    </div>
</div>

";
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (142 => 47,  136 => 44,  130 => 41,  123 => 37,  116 => 33,  110 => 29,  101 => 27,  98 => 26,  94 => 24,  88 => 23,  76 => 21,  73 => 20,  69 => 19,  64 => 18,  61 => 17,  58 => 16,  55 => 15,  51 => 14,  38 => 12,  29 => 6,  24 => 4,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\open-item-show.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div data-id=';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'html', null, true);
        echo ' class="task-item">
    <div class="show-task-item">
        ';
        // line 3
        if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || $this->env->getExtension('security')->isGranted('ROLE_CLIENT'))) {
            echo ' 
        <div class="actions-panel">
            <a class="btn-delete-task-item" href=';
            // line 5
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_delete', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
            echo '><img src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/remove_icon.png'), 'html', null, true);
            echo '"></a>
            <a class="btn-edit-task-item" href=';
            // line 6
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_edit', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
            echo '>Edit</a>
            <a class="btn-sort" href="#"><img src="';
            // line 7
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/sort_icon.png'), 'html', null, true);
            echo '"></a>
        </div>
        ';
        }
        // line 9
        echo ' 
        <div class="task-item-info">
            ';
        // line 11
        $this->env->loadTemplate('WWSCThalamusBundle:TaskItem:task-item-info.html.twig')->display(array_merge($context, array('oItem' => (isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')))));
        // line 12
        echo '        </div>
    </div>
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (52 => 12,  50 => 11,  46 => 9,  40 => 7,  36 => 6,  30 => 5,  25 => 3,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\task-item-close-info.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="item-status">
';
        // line 2
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            echo '    
    <input type="checkbox" checked class="task-item-status" data-url=';
            // line 3
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_change_status', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'status' => 0)), 'html', null, true);
            echo ' name="task_item_status[';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'html', null, true);
            echo ']">  
';
        } else {
            // line 5
            echo '    <input type="checkbox" checked disabled>
';
        }
        // line 7
        echo '</div>
<div class="description">
    <span class="due">';
        // line 9
        echo ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'fastTrack', array())) ? ('[FAST-TRACK]') : ('');
        echo '  ';
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'updated', array()), 'd M'), 'html', null, true);
        echo ' </span>
    <span class="task-item-more-info"> ';
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'description', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'responsible', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'responsible', array()), 'lastName', array()), 'html', null, true);
        echo '  ';
        if ($this->getAttribute((isset($context['taskItemStates']) ? $context['taskItemStates'] : null), $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'state', array()), array(), 'array', true, true)) {
            echo ' -  ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['taskItemStates']) ? $context['taskItemStates'] : $this->getContext($context, 'taskItemStates')), $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'state', array()), array(), 'array'), 'html', null, true);
            echo ' ';
        }
        echo '</span>
    <a class="icon-comment ';
        // line 11
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'comments', array())) <= 0)) {
            echo 'icon-comment-hidden ';
        }
        echo '" href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_comments', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
        echo '">
        ';
        // line 12
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'comments', array())) > 0)) {
            // line 13
            echo '            <img title="Comments" src="';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'iconComments', array()), 'html', null, true);
            echo '"> 
            ';
            // line 14
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'comments', array())), 'html', null, true);
            echo '
        ';
        } else {
            // line 16
            echo '            <img title="Comments" src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/icon-comment-empty.png'), 'html', null, true);
            echo '"> 
        ';
        }
        // line 18
        echo '    </a>
    ';
        // line 19
        if ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'getDaysAfterLastFeedback', array())) {
            // line 20
            echo '        <span class="last-update-task">(Last update was ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'getDaysAfterLastFeedback', array()), 'html', null, true);
            echo ' ago.)</span>
    ';
        }
        // line 22
        echo '</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (98 => 22,  92 => 20,  90 => 19,  87 => 18,  81 => 16,  76 => 14,  71 => 13,  69 => 12,  61 => 11,  47 => 10,  41 => 9,  37 => 7,  33 => 5,  26 => 3,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TaskItem\task-item-info.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="item-status">
';
        // line 2
        if ($this->env->getExtension('security')->isGranted('ROLE_PROVIDER')) {
            // line 3
            echo '    <input type="checkbox" class="task-item-status"  data-url=';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_change_status', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'status' => 1)), 'html', null, true);
            echo ' name="task_item_status[';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()), 'html', null, true);
            echo ']">
';
        } else {
            // line 5
            echo '    <input type="checkbox" disabled>
';
        }
        // line 7
        echo '</div>
<div class="description">
    <a class="';
        // line 9
        echo ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'fastTrack', array())) ? ('fast-track') : ('');
        echo '" href=';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_comments', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
        echo '>';
        echo ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'fastTrack', array())) ? ('[FAST-TRACK]') : ('');
        echo '  ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'description', array()), 'html', null, true);
        echo '</a>
        <span class="task-item-more-info"> ';
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'responsible', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'responsible', array()), 'lastName', array()), 'html', null, true);
        echo ' ';
        if ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'dueDate', array())) {
            echo ' ';
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'dueDate', array()), 'd M Y'), 'html', null, true);
            echo ' ';
        }
        echo ' ';
        if ($this->getAttribute((isset($context['taskItemStates']) ? $context['taskItemStates'] : null), $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'state', array()), array(), 'array', true, true)) {
            echo ' - ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['taskItemStates']) ? $context['taskItemStates'] : $this->getContext($context, 'taskItemStates')), $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'state', array()), array(), 'array'), 'html', null, true);
            echo ' ';
        }
        echo '</span>
    <a class="icon-comment ';
        // line 11
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'comments', array())) <= 0)) {
            echo 'icon-comment-hidden ';
        }
        echo '" href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_task_item_comments', array('project' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'project', array()), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'task', array()), 'id', array()), 'id' => $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'id', array()))), 'html', null, true);
        echo '">
        ';
        // line 12
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'comments', array())) > 0)) {
            // line 13
            echo '            <img title="Comments" src="';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'iconComments', array()), 'html', null, true);
            echo '"> 
            ';
            // line 14
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'comments', array())), 'html', null, true);
            echo '
        ';
        } else {
            // line 16
            echo '            <img title="Comments" src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/icon-comment-empty.png'), 'html', null, true);
            echo '"> 
        ';
        }
        // line 18
        echo '    </a>
    ';
        // line 19
        if ($this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'getDaysAfterLastFeedback', array())) {
            // line 20
            echo '        <span class="last-update-task">(Last update was ';
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oItem']) ? $context['oItem'] : $this->getContext($context, 'oItem')), 'getDaysAfterLastFeedback', array()), 'html', null, true);
            echo ' ago.)</span>
    ';
        }
        // line 22
        echo '</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (105 => 22,  99 => 20,  97 => 19,  94 => 18,  88 => 16,  83 => 14,  78 => 13,  76 => 12,  68 => 11,  50 => 10,  40 => 9,  36 => 7,  32 => 5,  24 => 3,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\TimeTracker\list.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'name', array()), 'html', null, true);
        echo ' - Time
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
<div class="row">
    <div class="panel panel-default col-md-12">
        <div class="panel-heading  col-xs-12">
            <div class="col-xs-6">
                Time tracking
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="table-responsive time-traker-list">
                        ';
        // line 17
        if (($this->env->getExtension('security')->isGranted('ROLE_PROVIDER') || $this->env->getExtension('security')->isGranted('ROLE_FREELANCER'))) {
            echo ' 
                            ';
            // line 18
            $context['country_companies'] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'country', array());
            // line 19
            echo '                        <div class="btn-export-to-csv">Export report to csv: 
                            <a  href="';
            // line 20
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_time_export_to_csv', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
            echo '">
                                <img src="';
            // line 21
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/icon_csv.png'), 'html', null, true);
            echo '">
                            </a>
                        </div>
                        ';
        }
        // line 24
        echo '    
                        <form id="filters-time-traker" method="GET" action="';
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_project_time_list', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()))), 'html', null, true);
        echo '"> 
                        <div>
                            <span> Hide empty entries: </span> 
                                ';
        // line 28
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'query', array()), 'get', array(0 => 'filter_time'), 'method')) {
            echo ' 
                                        ';
            // line 29
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fFilter']) ? $context['fFilter'] : $this->getContext($context, 'fFilter')), 'filter_hide_empty', array()), 'widget');
            echo '
                                ';
        } else {
            // line 31
            echo '                                        ';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fFilter']) ? $context['fFilter'] : $this->getContext($context, 'fFilter')), 'filter_hide_empty', array()), 'widget', array('attr' => array('checked' => 'checked')));
            echo '
                                ';
        }
        // line 33
        echo '                        </div>    
                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Hours</th>
                                    <th>Task-List</th>
                                    <th>Task-Title</th>
                                    <th>Company</th>
                                    <th>Person</th>
                                    <th>Task-ID</th>
                                    <th>Task-Url</th>
                                    <th>Description</th>
                                    <th>Related</th>
                                    <th>Fast-track</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div style="white-space: nowrap">From';
        // line 53
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fFilter']) ? $context['fFilter'] : $this->getContext($context, 'fFilter')), 'filter_date_from', array()), 'widget');
        echo ' To';
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fFilter']) ? $context['fFilter'] : $this->getContext($context, 'fFilter')), 'filter_date_to', array()), 'widget');
        echo '</div></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        ';
        // line 59
        if (($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'query', array()), 'get', array(0 => 'filter_time'), 'method') && $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'query', array()), 'get', array(0 => 'filter_time'), 'method'), 'filter_person', array(), 'array'))) {
            echo ' 
                                            ';
            // line 60
            $context['filter_responsible'] = $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'query', array()), 'get', array(0 => 'filter_time'), 'method'), 'filter_person', array(), 'array');
            // line 61
            echo '                                        ';
        } else {
            // line 62
            echo '                                            ';
            $context['filter_responsible'] = '';
            // line 63
            echo '                                        ';
        }
        // line 64
        echo '                                        <select id="filter_time_filter_person" name="filter_time[filter_person]" class="form-control">
                                            <option value="">Anyone</option>
                                            <option ';
        // line 66
        if (((isset($context['filter_responsible']) ? $context['filter_responsible'] : $this->getContext($context, 'filter_responsible')) == $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()))) {
            echo ' selected ';
        }
        echo ' value="';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), 'html', null, true);
        echo '">Me (';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'lastName', array()), 'html', null, true);
        echo ')</option>
                                            <option disabled value="">----------</option>
                                                    ';
        // line 68
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'subspeople', array(0 => (($this->env->getExtension('security')->isGranted('ROLE_FREELANCER')) ? ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'company', array()), 'id', array())) : (false))), 'method'));
        foreach ($context['_seq'] as $context['_key'] => $context['oResponsibleCompany']) {
            // line 69
            echo '                                                         ';
            if ($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'any', true, true)) {
                // line 70
                echo '                                                            ';
                if (((twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array')) > 1) || ((1 == twig_length_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))) && (false == twig_in_filter($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()), twig_get_array_keys_filter($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'))))))) {
                    // line 71
                    echo '                                                        <option disabled value="">';
                    echo twig_escape_filter($this->env, $this->getAttribute($context['oResponsibleCompany'], 'name', array(), 'array'), 'html', null, true);
                    echo '</option>
                                                        ';
                    // line 72
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute($context['oResponsibleCompany'], 'people', array(), 'array'));
                    foreach ($context['_seq'] as $context['key'] => $context['val']) {
                        // line 73
                        echo '                                                            ';
                        if (($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'id', array()) != $context['key'])) {
                            // line 74
                            echo '                                                                <option ';
                            if (($context['key'] == (isset($context['filter_responsible']) ? $context['filter_responsible'] : $this->getContext($context, 'filter_responsible')))) {
                                echo ' selected ';
                            }
                            echo '  value=';
                            echo twig_escape_filter($this->env, $context['key'], 'html', null, true);
                            echo ' >';
                            echo twig_escape_filter($this->env, $context['val'], 'html', null, true);
                            echo '</option>
                                                            ';
                        }
                        // line 76
                        echo '                                                        ';
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['key'], $context['val'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 77
                    echo '                                                             <option disabled value="">----------</option>
                                                            ';
                }
                // line 79
                echo '                                                        ';
            }
            echo ' 
                                                    ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oResponsibleCompany'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 80
        echo '   
                                        </select>
                                    </td>
                                    <td>';
        // line 83
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fFilter']) ? $context['fFilter'] : $this->getContext($context, 'fFilter')), 'filter_task', array()), 'widget');
        echo '</form></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        ';
        // line 88
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['fFilter']) ? $context['fFilter'] : $this->getContext($context, 'fFilter')), 'fast_track', array()), 'widget');
        echo '
                                    </td>
                                    <td></td>
                                </tr>
                                ';
        // line 92
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context['aTimeTracker']) ? $context['aTimeTracker'] : $this->getContext($context, 'aTimeTracker')));
        foreach ($context['_seq'] as $context['_key'] => $context['oTimeTracker']) {
            // line 93
            echo '                                <tr>
                                    <td>';
            // line 94
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context['oTimeTracker'], 'date', array()), 'd M Y'), 'html', null, true);
            echo '</td>
                                    <td>';
            // line 95
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTimeTracker'], 'time', array(0 => (isset($context['country_companies']) ? $context['country_companies'] : $this->getContext($context, 'country_companies'))), 'method'), 'html', null, true);
            echo '</td>
                                    <td>';
            // line 96
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'task', array()), 'name', array()), 'html', null, true);
            echo '</td>
                                    <td ';
            // line 97
            echo ($this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'fastTrack', array())) ? ('class="fast-track"') : ('');
            echo '" >';
            echo ($this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'fastTrack', array())) ? ('[FAST-TRACK]') : ('');
            echo ' ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'description', array()), 'html', null, true);
            echo '</td>
                                    <td>';
            // line 98
            if (($this->getAttribute($context['oTimeTracker'], 'person', array(), 'any', true, true) && $this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'person', array(), 'any', false, true), 'company', array(), 'any', false, true), 'name', array(), 'any', true, true))) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'person', array()), 'company', array()), 'name', array()), 'html', null, true);
            }
            echo '</td>
                                    <td>';
            // line 99
            if ($this->getAttribute($context['oTimeTracker'], 'person', array(), 'any', true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context['oTimeTracker'], 'person', array()), 'firstName', array()), 'html', null, true);
            }
            echo '</td>
                                    <td>';
            // line 100
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'id', array()), 'html', null, true);
            echo '</td>
                                    ';
            // line 101
            $context['uTask'] = $this->env->getExtension('routing')->getUrl('wwsc_thalamus_project_task_item_comments', array('project' => $this->getAttribute((isset($context['oProject']) ? $context['oProject'] : $this->getContext($context, 'oProject')), 'slug', array()), 'task' => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'task', array()), 'id', array()), 'id' => $this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'id', array())));
            // line 102
            echo '                                    <td>
                                        <a href="';
            // line 103
            echo twig_escape_filter($this->env, (isset($context['uTask']) ? $context['uTask'] : $this->getContext($context, 'uTask')), 'html', null, true);
            echo '#c_';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'id', array()), 'html', null, true);
            echo '" target="_blank">
                                            <img alt="';
            // line 104
            echo twig_escape_filter($this->env, (isset($context['uTask']) ? $context['uTask'] : $this->getContext($context, 'uTask')), 'html', null, true);
            echo '#c_';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'id', array()), 'html', null, true);
            echo '" title="';
            echo twig_escape_filter($this->env, (isset($context['uTask']) ? $context['uTask'] : $this->getContext($context, 'uTask')), 'html', null, true);
            echo '#c_';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'id', array()), 'html', null, true);
            echo '"  src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/icon_url.png'), 'html', null, true);
            echo '">
                                        </a>
                                    </td>
                                    <td>';
            // line 107
            echo twig_escape_filter($this->env, $this->getAttribute($context['oTimeTracker'], 'description', array()), 'html', null, true);
            echo '</td>
                                    <td>';
            // line 108
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'related', array()), 'html', null, true);
            echo '</td>
                                    <td>';
            // line 109
            echo ($this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'fastTrack', array())) ? ('Yes') : ('No');
            echo '</td>
                                    <td>';
            // line 110
            if ($this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'state', array())) {
                // line 111
                echo '                                            ';
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context['aStates']) ? $context['aStates'] : $this->getContext($context, 'aStates')), $this->getAttribute($this->getAttribute($this->getAttribute($context['oTimeTracker'], 'comment', array()), 'parentInfo', array()), 'state', array()), array(), 'array'), 'html', null, true);
                echo '
                                         ';
            }
            // line 113
            echo '                                    </td>
                                </tr>     
                                ';
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oTimeTracker'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 115
        echo ' 

                            ';
        // line 117
        if ( !twig_test_empty((isset($context['aReportProjectGropedByCompanys']) ? $context['aReportProjectGropedByCompanys'] : $this->getContext($context, 'aReportProjectGropedByCompanys')))) {
            // line 118
            echo '                                ';
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context['aReportProjectGropedByCompanys']) ? $context['aReportProjectGropedByCompanys'] : $this->getContext($context, 'aReportProjectGropedByCompanys')));
            foreach ($context['_seq'] as $context['_key'] => $context['oReportProjectGropedByCompany']) {
                // line 119
                echo '                                <tr>
                                    <td></td>
                                    <td>
                                        <strong>
                                            ';
                // line 123
                echo twig_escape_filter($this->env, ((('DE' == (isset($context['country_companies']) ? $context['country_companies'] : $this->getContext($context, 'country_companies')))) ? (twig_number_format_filter($this->env, $this->getAttribute($context['oReportProjectGropedByCompany'], 'total', array(), 'array'), 2, ',', '')) : (twig_round($this->getAttribute($context['oReportProjectGropedByCompany'], 'total', array(), 'array'), 2, 'floor'))), 'html', null, true);
                echo '
                                        </strong>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>';
                // line 128
                echo twig_escape_filter($this->env, $this->getAttribute($context['oReportProjectGropedByCompany'], 'name', array(), 'array'), 'html', null, true);
                echo '</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>   
                                </tr>
                                ';
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['oReportProjectGropedByCompany'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 137
            echo ' 
                            ';
        }
        // line 139
        echo '                            </tbody>
                        </table>
                        </form>    
                    </div>
                </div><!--/span-->
            </div>  
        </div>  
    </div>     
</div>
';
    }

    // line 150
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 151
        echo '    <link href="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/css/bootstrap-datepicker.css'), 'html', null, true);
        echo '" type="text/css" rel="stylesheet" />    
';
    }

    // line 153
    public function block_javascripts($context, array $blocks = array())
    {
        // line 154
        echo '    <script src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/time-tracker.js'), 'html', null, true);
        echo '"></script>
    <script src="';
        // line 155
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/js/bootstrap-datepicker.js'), 'html', null, true);
        echo '"></script>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (419 => 155,  414 => 154,  411 => 153,  404 => 151,  401 => 150,  388 => 139,  384 => 137,  368 => 128,  360 => 123,  354 => 119,  349 => 118,  347 => 117,  343 => 115,  335 => 113,  329 => 111,  327 => 110,  323 => 109,  319 => 108,  315 => 107,  301 => 104,  295 => 103,  292 => 102,  290 => 101,  286 => 100,  280 => 99,  274 => 98,  266 => 97,  262 => 96,  258 => 95,  254 => 94,  251 => 93,  247 => 92,  240 => 88,  232 => 83,  227 => 80,  218 => 79,  214 => 77,  208 => 76,  196 => 74,  193 => 73,  189 => 72,  184 => 71,  181 => 70,  178 => 69,  174 => 68,  161 => 66,  157 => 64,  154 => 63,  151 => 62,  148 => 61,  146 => 60,  142 => 59,  131 => 53,  109 => 33,  103 => 31,  98 => 29,  94 => 28,  88 => 25,  85 => 24,  78 => 21,  74 => 20,  71 => 19,  69 => 18,  65 => 17,  49 => 5,  42 => 3,  39 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\activation_user.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('::base.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return '::base.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Activation user
';
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        // line 6
        echo '<div class="container activation_user modal-content">
    ';
        // line 7
        if (array_key_exists('form', $context)) {
            // line 8
            echo '        <form action="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_activation', array('account' => $this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'slug', array()), 'salt' => (isset($context['salt']) ? $context['salt'] : $this->getContext($context, 'salt')))), 'html', null, true);
            echo '" method="post" class="form-signin">
            <h2>';
            // line 9
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oAccount']) ? $context['oAccount'] : $this->getContext($context, 'oAccount')), 'name', array()), 'html', null, true);
            echo '</h2>
            ';
            // line 10
            $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
            // line 11
            echo '            <p>Sign in to get started with Thalamus</p>
            <div class="form-group plain-password">
                ';
            // line 13
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'plainPassword', array()), 'widget');
            echo '
            </div>
            ';
            // line 15
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
            echo '
            <div class="form-group">
                ';
            // line 17
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
            echo "
                <button class=\"btn btn-lg btn-primary btn-block\"  type=\"submit\">OK, let's go</button>
            </div>
        </form>
    ";
        } else {
            // line 22
            echo '        ';
            $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
            // line 23
            echo '    ';
        }
        echo '    
</div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (89 => 23,  86 => 22,  78 => 17,  73 => 15,  68 => 13,  64 => 11,  62 => 10,  58 => 9,  53 => 8,  51 => 7,  48 => 6,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\add.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Add new person
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading">
                Add a person to ';
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oCompany']) ? $context['oCompany'] : $this->getContext($context, 'oCompany')), 'name', array()), 'html', null, true);
        echo '
            </div>
            <div class="panel-body">
                <div class="row">
                    ';
        // line 13
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 14
        echo '                    ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 15
            echo '                        <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                    ';
        }
        // line 17
        echo '                    <div class="panel-forms">
                        <form action="';
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_add', array('company' => $this->getAttribute((isset($context['oCompany']) ? $context['oCompany'] : $this->getContext($context, 'oCompany')), 'id', array()))), 'html', null, true);
        echo "\" class=\"add-user-form\" method=\"Post\">
                            <input type='hidden' name=\"company\" id=\"company_id\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oCompany']) ? $context['oCompany'] : $this->getContext($context, 'oCompany')), 'id', array()), 'html', null, true);
        echo '">
                            ';
        // line 20
        if ($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'project'), 'method')) {
            // line 21
            echo "                                <input type='hidden' id=\"wwsc_thalamus_user_project\"  name=\"project\" value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'request', array()), 'get', array(0 => 'project'), 'method'), 'html', null, true);
            echo '">
                            ';
        }
        // line 23
        echo "                            <p>This person's name will be displayed next to their messages, comments, to-dos, milestones, and files.</p>
                            <fieldset>
                                <div class=\"form-group col-xs-12\">
                                    ";
        // line 26
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'first_name', array()), 'label');
        echo '
                                    <div class="col-md-4">  
                                        ';
        // line 28
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'first_name', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    ';
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'last_name', array()), 'label');
        echo '
                                    <div class="col-md-4">      
                                        ';
        // line 34
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'last_name', array()), 'widget');
        echo '
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    ';
        // line 38
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'email', array()), 'label');
        echo '
                                    <div class="col-md-4">       
                                        ';
        // line 40
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'email', array()), 'widget');
        echo "
                                    </div>
                                </div>
                            </fieldset>    
                            <p>The rest is optional. You can fill it in later if you'd like.</p>
                            <fieldset>
                                ";
        // line 46
        $this->env->loadTemplate('WWSCThalamusBundle:User:profile_form.html.twig')->display(array_merge($context, array('profile' => $this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'profile', array()))));
        // line 47
        echo '                            </fieldset>  
                            <h3>Include a personal note along with the invitation to set up their account?</h3>
                            <p>This person will receive a welcome email with a link to choose their username and password. You can also add a personalized note that will appear at the bottom of the email. Please use plain text (no HTML tags).</p>
                            <fieldset>
                                <div class="form-group col-xs-12">
                                    <div class="col-md-6"> 
                                        ';
        // line 53
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'profile', array()), 'description', array()), 'widget');
        echo '
                                    </div>
                                </div>
                            </fieldset>     
                            ';
        // line 57
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo "
                            <h3>What happens now?</h3>
                            <p>When you click the \"Add this person\" button below, we'll fire off a nice invitation to the email address you entered above. The email will contain a link to a web page where this person will complete the setup process by picking their own username and password. Plus, you can immediately start involving them in projects even before they've chosen their username and password.</p>
                            <div class=\"form-group col-xs-12 btn-action\">
                                <button class=\"btn btn-sm btn-primary btn-save\" type=\"submit\">Save changes</button>
                                or <a class=\"btn-cancel\" href=\"";
        // line 62
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_all_people');
        echo '"> Cancel </a> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>                          
        <div class="col-md-3 sidebar sidebar-user">
            <div class="col">
                <div class="title-panel">Sample welcome email</div>
                <div class="info-panel">
                    As soon as you submit this form, this person will receive a welcome email with a link to pick their own username and password.
                </div>   
            </div>
        </div><!--/span-->
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (158 => 62,  150 => 57,  143 => 53,  135 => 47,  133 => 46,  124 => 40,  119 => 38,  112 => 34,  107 => 32,  100 => 28,  95 => 26,  90 => 23,  84 => 21,  82 => 20,  78 => 19,  74 => 18,  71 => 17,  65 => 15,  62 => 14,  60 => 13,  53 => 9,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\block_info_user.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="name">
    ';
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'lastName', array()), 'html', null, true);
        echo '
</div><br>
<ul>
    <li>';
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'firstName', array()), 'html', null, true);
        echo '</li>
    <li>';
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'email', array()), 'html', null, true);
        echo '</li>
        ';
        // line 7
        if ($this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'imName', array())) {
            // line 8
            echo '        <li>';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'serviceIm', array()), 'html', null, true);
            echo ' : ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'imName', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 10
        echo '        ';
        if ($this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'office', array())) {
            // line 11
            echo '        <li>O: ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'office', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 13
        echo '        ';
        if ($this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'mobile', array())) {
            // line 14
            echo '        <li>M: ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'mobile', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 16
        echo '        ';
        if ($this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'fax', array())) {
            // line 17
            echo '        <li>H: ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'fax', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 19
        echo '        ';
        if ($this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'home', array())) {
            // line 20
            echo '        <li>F: ';
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['user']) ? $context['user'] : $this->getContext($context, 'user')), 'profile', array()), 'home', array()), 'html', null, true);
            echo '</li>
        ';
        }
        // line 22
        echo '</ul>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (84 => 22,  78 => 20,  75 => 19,  69 => 17,  66 => 16,  60 => 14,  57 => 13,  51 => 11,  48 => 10,  40 => 8,  38 => 7,  34 => 6,  30 => 5,  22 => 2,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\contact_edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Edit person
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading">
                Edit ';
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'company', array()), 'name', array()), 'html', null, true);
        echo ' -developer
            </div>
            <div class="panel-body">
                <div class="row">
                    ';
        // line 13
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 14
        echo '                    ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 15
            echo '                        <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                    ';
        }
        // line 17
        echo '                    <div class="panel-forms">
                        ';
        // line 18
        if ((0 == $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'enabled', array()))) {
            // line 19
            echo '                            <div class="info-panel">
                                <h1>';
            // line 20
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array()), 'html', null, true);
            echo " hasn't accepted this invitation yet.</h1>
                                <p>The last invitation was sent on ";
            // line 21
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'updated', array()), 'F d, Y'), 'html', null, true);
            echo " . If you'd like, you can 
                                    <a href=\"";
            // line 22
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_user_resend_email', array('id' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'id', array()))), 'html', null, true);
            echo '">re-send the email</a> 
                                    or you can send ';
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array()), 'html', null, true);
            echo ' this invite link yourself:</p>
                                <p>';
            // line 24
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_user_activation', array('account' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'company', array()), 'account', array()), 'slug', array()), 'salt' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'salt', array()))), 'html', null, true);
            echo '</p>            
                            </div>
                        ';
        }
        // line 27
        echo '                        ';
        if (((1 == $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'enabled', array())) && (0 == $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'checkActiveUserCompany', array())))) {
            // line 28
            echo '                            <div class="info-panel">
                                <h1>';
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array()), 'html', null, true);
            echo " hasn't accepted this invitation yet.</h1>
                                <p>The last invitation was sent on ";
            // line 30
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'updated', array()), 'F d, Y'), 'html', null, true);
            echo " . If you'd like, you can 
                                    <a href=\"";
            // line 31
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_user_exist-user-resend-email', array('user' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'id', array()), 'company' => $this->getAttribute($this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'company', array()), 'id', array()))), 'html', null, true);
            echo '">re-send the email</a> 
                                    or you can send ';
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array()), 'html', null, true);
            echo ' this invite link yourself:</p>
                                <p>';
            // line 33
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl('wwsc_thalamus_user_acccept_invitation', array('account' => $this->getAttribute($this->getAttribute($this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'company', array()), 'account', array()), 'slug', array()), 'company' => $this->getAttribute($this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'company', array()), 'id', array()), 'salt' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'salt', array()))), 'html', null, true);
            echo '</p>            
                            </div>
                        ';
        }
        // line 36
        echo '                        ';
        if ((((1 == $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'enabled', array())) && (0 != $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'checkActiveUserCompany', array()))) || ((0 == $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'enabled', array())) && (0 == $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'checkActiveUserCompany', array()))))) {
            // line 37
            echo '                        <form action="';
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_edit', array('id' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'id', array()))), 'html', null, true);
            echo '"  ';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'enctype');
            echo ' method="Post">
                            <div class="form-group col-md-12">
                                <div class="avatar-user col-md-2">
                                    ';
            // line 40
            if ($this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'avatar', array())) {
                // line 41
                echo '                                        ';
                $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'avatar', array()));
                // line 42
                echo '                                    ';
            } else {
                // line 43
                echo '                                        ';
                $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
                // line 44
                echo '                                    ';
            }
            // line 45
            echo '                                    <img src="';
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
            echo '">
                                </div>    
                                <div class="col-md-4">
                                    ';
            // line 48
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'avatarFile', array()), 'label');
            echo '
                                    ';
            // line 49
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'avatarFile', array()), 'widget');
            echo '
                                </div>
                            </div>
                            <div class="form-group col-xs-12">
                                ';
            // line 53
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'company', array()), 'label');
            echo '
                                <div class="col-md-4">       
                                    ';
            // line 55
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'company', array()), 'widget');
            echo '
                                </div>
                            </div>
                            ';
            // line 58
            $this->env->loadTemplate('WWSCThalamusBundle:User:profile_form.html.twig')->display(array_merge($context, array('profile' => $this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'profile', array()))));
            // line 59
            echo '                            ';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
            echo '
                            <div class="form-group col-xs-12 btn-action">
                                <button class="btn btn-sm btn-primary btn-save" type="submit">Save changes</button>
                                or <a class="btn-cancel" href="';
            // line 62
            echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_all_people');
            echo '"> Cancel </a> 
                            </div>
                        </form>
                        ';
        }
        // line 65
        echo '    
                    </div>
                </div>
            </div>  
        </div>                          
        <div class="col-md-3 sidebar sidebar-user">
            <div class="col">
                <div class="title-panel">Delete this person?</div>
                <div class="info-panel">
                    This will permanently remove ';
        // line 74
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array()), 'html', null, true);
        echo " from your Thalamus account.
                    Don't worry, their messages, comments, and history will not be erased.<br> 
                    <a class=\"btn-delete-user\" href=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_delete', array('id' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'id', array()))), 'html', null, true);
        echo '">Delete ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array()), 'html', null, true);
        echo ' now</a>
                </div>   
            </div>
        </div><!--/span-->
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (218 => 76,  213 => 74,  202 => 65,  195 => 62,  188 => 59,  186 => 58,  180 => 55,  175 => 53,  168 => 49,  164 => 48,  157 => 45,  154 => 44,  151 => 43,  148 => 42,  145 => 41,  143 => 40,  134 => 37,  131 => 36,  125 => 33,  121 => 32,  117 => 31,  113 => 30,  109 => 29,  106 => 28,  103 => 27,  97 => 24,  93 => 23,  89 => 22,  85 => 21,  81 => 20,  78 => 19,  76 => 18,  73 => 17,  67 => 15,  64 => 14,  62 => 13,  53 => 9,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\my_contact_edit.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    Edit person
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row">
        <div class="panel panel-default col-md-9">
            <div class="panel-heading my-personal-data col-xs-12">
                <div class="col-md-5">
                    <h4><a href="';
        // line 10
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_myinfo');
        echo '">Edit your personal information</a></h4>
                    <p class="unformatted_text">Change your name, photo, email address, username or password.</p>
                </div>
                <div class="col-md-4">
                    ';
        // line 14
        $this->env->loadTemplate('WWSCThalamusBundle:User:my_info_block.html.twig')->display(array_merge($context, array('oUser' => (isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')))));
        // line 15
        echo '                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    ';
        // line 19
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 20
        echo '                    ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 21
            echo '                        <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                    ';
        }
        // line 23
        echo '                    <div class="panel-forms">
                        <form action="';
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_edit', array('id' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'id', array()))), 'html', null, true);
        echo '"  ';
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'enctype');
        echo ' method="Post">
                            <fieldset>
                                ';
        // line 26
        $this->env->loadTemplate('WWSCThalamusBundle:User:profile_form.html.twig')->display(array_merge($context, array('profile' => $this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'profile', array()))));
        // line 27
        echo '                            </fieldset>
                            <h4>Email notifications</h4>
                            <p>Send all email notifications and reminders to this address:</p>
                            <div class="form-group col-xs-12">
                                ';
        // line 31
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'email', array()), 'label');
        echo '
                                <div class="col-md-4">       
                                    ';
        // line 33
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'email', array()), 'widget');
        echo '
                                </div>
                            </div>
                            ';
        // line 36
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                            <div class="form-group col-xs-12 btn-action">
                                <button class="btn btn-sm btn-primary btn-save" type="submit">Save changes</button>
                                or <a class="btn-cancel" href="';
        // line 39
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_all_people');
        echo '"> Cancel </a> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>                          
    </div>
';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (115 => 39,  109 => 36,  103 => 33,  98 => 31,  92 => 27,  90 => 26,  83 => 24,  80 => 23,  74 => 21,  71 => 20,  69 => 19,  63 => 15,  61 => 14,  54 => 10,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\my_info.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate('WWSCThalamusBundle:Content:layout.html.twig');
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return 'WWSCThalamusBundle:Content:layout.html.twig';
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo '    My info
';
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        echo '   
    <div class="row col-xs-offset-2 col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update your Thalamus ID details
            </div>
            <div class="panel-body">
                <div class="row">
                    ';
        // line 13
        $this->env->loadTemplate('WWSCThalamusBundle:Content:flash_notice.html.twig')->display($context);
        // line 14
        echo '                    ';
        if ($this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors')) {
            // line 15
            echo '                        <div class="alert alert-error error" role="alert">';
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'errors');
            echo '</div>
                    ';
        }
        // line 17
        echo '                    <div class="panel-forms">
                        <form  class="my-info" action="';
        // line 18
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_user_myinfo');
        echo '"  ';
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'enctype');
        echo ' method="Post">
                            <div class="form-group col-md-12">
                                <div class="avatar-user col-md-2">
                                    ';
        // line 21
        if ($this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'avatar', array())) {
            // line 22
            echo '                                        ';
            $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute($this->getAttribute((isset($context['app']) ? $context['app'] : $this->getContext($context, 'app')), 'user', array()), 'avatar', array()));
            // line 23
            echo '                                    ';
        } else {
            // line 24
            echo '                                        ';
            $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
            // line 25
            echo '                                    ';
        }
        // line 26
        echo '                                    <img src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
        echo '">
                                </div>    
                                <div class="col-md-7">
                                    ';
        // line 29
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'avatarFile', array()), 'label');
        echo '
                                    ';
        // line 30
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'avatarFile', array()), 'widget');
        echo '
                                </div>
                            </div>
                            <div class="form-group col-xs-12">
                                ';
        // line 34
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'first_name', array()), 'label');
        echo '
                                <div class="col-md-7">  
                                    ';
        // line 36
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'first_name', array()), 'widget');
        echo '
                                </div>
                            </div>
                            <div class="form-group col-xs-12">
                                ';
        // line 40
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'last_name', array()), 'label');
        echo '
                                <div class="col-md-7">      
                                    ';
        // line 42
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'last_name', array()), 'widget');
        echo '
                                </div>
                            </div>
                            <div class="form-group col-xs-12">
                                ';
        // line 46
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'email', array()), 'label');
        echo '
                                <div class="col-md-7">       
                                    ';
        // line 48
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'email', array()), 'widget');
        echo '
                                </div>
                            </div>
                            <div class="form-group  col-xs-12">
                                ';
        // line 52
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'language', array()), 'label');
        echo '
                                <div class="col-md-7"> 
                                    ';
        // line 54
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'language', array()), 'widget');
        echo '
                                </div>
                            </div>   
                            <div class="form-group  col-xs-12">
                                ';
        // line 58
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'timeZone', array()), 'label');
        echo '
                                <div class="col-md-7"> 
                                    ';
        // line 60
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'timeZone', array()), 'widget');
        echo '
                                </div>
                            </div>   
                            <div class="form-group col-xs-12 plain-password">
                                <label class="control-label col-xs-2 " for="wwsc_thalamusbundle_user_plainPassword">Password:</label>
                                <div class="col-md-7"> 
                                    ';
        // line 66
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), 'plainPassword', array()), 'widget');
        echo '
                                </div>
                            </div>
                            ';
        // line 69
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['form']) ? $context['form'] : $this->getContext($context, 'form')), '_token', array()), 'widget');
        echo '
                            <div class="form-group col-xs-12 btn-action">
                                <button class="btn btn-sm btn-primary btn-save" type="submit">Save changes</button>
                                or <a class="btn-cancel" href="';
        // line 72
        echo $this->env->getExtension('routing')->getPath('wwsc_thalamus_account_all_people');
        echo '"> Cancel </a> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>                          
    ';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (185 => 72,  179 => 69,  173 => 66,  164 => 60,  159 => 58,  152 => 54,  147 => 52,  140 => 48,  135 => 46,  128 => 42,  123 => 40,  116 => 36,  111 => 34,  104 => 30,  100 => 29,  93 => 26,  90 => 25,  87 => 24,  84 => 23,  81 => 22,  79 => 21,  71 => 18,  68 => 17,  62 => 15,  59 => 14,  57 => 13,  45 => 5,  40 => 3,  37 => 2,  11 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\my_info_block.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class=" panel panel-default col-md-4 my-info-block">
    <div class="panel-heading col-xs-12">
        Your Tgalamus Id
    </div>
    <div class="panel-body">
        <div class="item col-xs-12">
            <div class="avatar">
                ';
        // line 8
        if ($this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'avatar', array())) {
            // line 9
            echo '                    ';
            $context['icon'] = ($this->env->getExtension('assets')->getAssetUrl('uploads/user/').$this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'avatar', array()));
            // line 10
            echo '                ';
        } else {
            // line 11
            echo '                    ';
            $context['icon'] = $this->env->getExtension('assets')->getAssetUrl('bundles/wwscthalamus/images/user_icon.png');
            // line 12
            echo '                ';
        }
        // line 13
        echo '                <img src="';
        echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context['icon']) ? $context['icon'] : $this->getContext($context, 'icon')), 'my_thumb', array('thumbnail' => array('size' => array(0 => 64, 1 => 64)))), 'html', null, true);
        echo '">
            </div>
            <div class="desc">
                <div class="name">
                    ';
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array()), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'lastName', array()), 'html', null, true);
        echo '
                </div>
                <ul>
                    <li>';
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'email', array()), 'html', null, true);
        echo '</li>
                    <li>Username: ';
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'username', array()), 'html', null, true);
        echo '</li>
                    <li>Password: •••••• </li>
                </ul>                               
            </div>
        </div>
    </div>
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (62 => 21,  58 => 20,  50 => 17,  42 => 13,  39 => 12,  36 => 11,  33 => 10,  30 => 9,  28 => 8,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\popup_add_existing_user.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="modal add-existing-user container">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">';
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array(), 'array'), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'lastName', array(), 'array'), 'html', null, true);
        echo ' already exists on Thalamus account</h4>
      </div>
      <div class="modal-body">
        <p>';
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'firstName', array(), 'array'), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'lastName', array(), 'array'), 'html', null, true);
        echo "'s email address (";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oExistentUser']) ? $context['oExistentUser'] : $this->getContext($context, 'oExistentUser')), 'email', array(), 'array'), 'html', null, true);
        echo ') already matches someone else on Thalamus account named ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oExistentUser']) ? $context['oExistentUser'] : $this->getContext($context, 'oExistentUser')), 'firstName', array(), 'array'), 'html', null, true);
        echo ' ';
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['oExistentUser']) ? $context['oExistentUser'] : $this->getContext($context, 'oExistentUser')), 'lastName', array(), 'array'), 'html', null, true);
        echo '.</p>
        <p>Are you sure you want to add this user to your account?</p>
        <p><div class="form-group without-padding  btn-action">
            <a class="btn btn-sm btn-primary btn-save" href="';
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath('wwsc_thalamus_add-existent-user-to-company', array('company' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'company', array(), 'array'), 'user' => $this->getAttribute((isset($context['oExistentUser']) ? $context['oExistentUser'] : $this->getContext($context, 'oExistentUser')), 'id', array()), 'project' => $this->getAttribute((isset($context['oUser']) ? $context['oUser'] : $this->getContext($context, 'oUser')), 'project', array(), 'array'))), 'html', null, true);
        echo '">Add user to account</a>
            or <a class="btn-cancel" href="#"> Cancel </a> 
        </div><p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (48 => 12,  34 => 9,  26 => 6,  19 => 1);
    }
}
/*
 * Resource: WWSCThalamusBundle
 * File: src\WWSC\ThalamusBundle\Resources\views\User\profile_form.html.twig
 */

class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo '<div class="form-group col-xs-12">
    ';
        // line 2
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'title', array()), 'label');
        echo '
    <div class="col-md-4"> 
        ';
        // line 4
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'title', array()), 'widget');
        echo '
    </div>
</div>
<div class="form-group col-xs-12">
    ';
        // line 8
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'office', array()), 'label');
        echo '
    <div class="col-md-4"> 
        ';
        // line 10
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'office', array()), 'widget');
        echo '
    </div>
</div>
<div class="form-group col-xs-12">
    ';
        // line 14
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'mobile', array()), 'label');
        echo '
    <div class="col-md-4"> 
        ';
        // line 16
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'mobile', array()), 'widget');
        echo '
    </div>
</div>
<div class="form-group col-xs-12">
    ';
        // line 20
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'fax', array()), 'label');
        echo '
    <div class="col-md-4"> 
        ';
        // line 22
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'fax', array()), 'widget');
        echo '
    </div>
</div>
<div class="form-group col-xs-12">
    ';
        // line 26
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'home', array()), 'label');
        echo '
    <div class="col-md-4"> 
        ';
        // line 28
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'home', array()), 'widget');
        echo '
    </div>
</div>
<div class="form-group col-xs-12">
    ';
        // line 32
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'imName', array()), 'label');
        echo '
    <div class="col-xs-6">
        <div class="sub-field col-xs-8">   
            ';
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'imName', array()), 'widget');
        echo '
        </div>
        <div class="col-xs-4"> 
            ';
        // line 38
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context['profile']) ? $context['profile'] : $this->getContext($context, 'profile')), 'serviceIm', array()), 'widget');
        echo '
        </div>    
    </div>
</div>';
    }

    public function getTemplateName()
    {
        return null;
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (94 => 38,  88 => 35,  82 => 32,  75 => 28,  70 => 26,  63 => 22,  58 => 20,  51 => 16,  46 => 14,  39 => 10,  34 => 8,  27 => 4,  22 => 2,  19 => 1);
    }
}
