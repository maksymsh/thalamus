<?php
/*
 * Resource: app
 * File: app\Resources\views\base.html.twig
 */

/*  */
class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        ";
        // line 6
        if ((($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "attributes", array()), "get", array(0 => "_route"), "method") == "wwsc_thalamus_login_account") || ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "attributes", array()), "get", array(0 => "_route"), "method") == "wwsc_thalamus_user_activation"))) {
            // line 7
            echo "           <meta name=\"viewport\" content=\"width=device-width, initial-scale=0.8, maximum-scale=0.8\">
        ";
        } else {
            // line 9
            echo "            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        ";
        }
        // line 11
        echo "        <title>";
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <link href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/css/bootstrap.min.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/css/app.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/css/fancyzoom.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        ";
        // line 15
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 17
        echo "        <!--[if lt IE 9]>
            <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
            <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
        <![endif]-->
        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 24
        $this->displayBlock('body', $context, $blocks);
        // line 26
        echo "        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
        <script src=\"https://code.jquery.com/ui/1.11.1/jquery-ui.js\"></script>
        <script src=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/js/jquery.fancyzoom.min.js"), "html", null, true);
        echo "\"></script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-57429160-1', 'auto');
            ga('send', 'pageview');
        </script>
        ";
        // line 38
        $this->displayBlock('javascripts', $context, $blocks);
        // line 40
        echo "        <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/js/app.js"), "html", null, true);
        echo "\"></script>
    </body>
</html>";
    }

    // line 11
    public function block_title($context, array $blocks = array())
    {
        echo "Thalamus";
    }

    // line 15
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 16
        echo "        ";
    }

    // line 24
    public function block_body($context, array $blocks = array())
    {
        // line 25
        echo "        ";
    }

    // line 38
    public function block_javascripts($context, array $blocks = array())
    {
        // line 39
        echo "        ";
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
        return array (  126 => 39,  123 => 38,  119 => 25,  116 => 24,  112 => 16,  109 => 15,  103 => 11,  95 => 40,  93 => 38,  81 => 29,  77 => 28,  73 => 26,  71 => 24,  65 => 21,  59 => 17,  57 => 15,  53 => 14,  49 => 13,  45 => 12,  40 => 11,  36 => 9,  32 => 7,  30 => 6,  23 => 1,);
    }
}
/*
 * Resource: app
 * File: app\Resources\views\exception.html.twig
 */

/*  */
class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("::base.html.twig");
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
        return "::base.html.twig";
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
                <h3>This page is not defined</h3>
                <p>Go to the home page <a href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "scheme", array()), "html", null, true);
        echo "://";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "httpHost", array()), "html", null, true);
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "basePath", array()), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "scheme", array()), "html", null, true);
        echo "://";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "httpHost", array()), "html", null, true);
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "basePath", array()), "html", null, true);
        echo "</a></p>
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
        return array (  45 => 7,  39 => 3,  36 => 2,  11 => 1,);
    }
}
/*
 * Resource: app
 * File: app\Resources\views\TwigBundle\views\Exception\error404.html.twig
 */

/*  */
class __TwigTemplate_e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <link href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/css/bootstrap.min.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/css/app.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        ";
        // line 8
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 10
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 13
        $this->displayBlock('body', $context, $blocks);
        // line 22
        echo "        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
        <script src=\"https://code.jquery.com/ui/1.11.1/jquery-ui.js\"></script>
        <script src=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/wwscthalamus/js/app.js"), "html", null, true);
        echo "\"></script>
        ";
        // line 25
        $this->displayBlock('javascripts', $context, $blocks);
        // line 27
        echo "    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Thalamus";
    }

    // line 8
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 9
        echo "        ";
    }

    // line 13
    public function block_body($context, array $blocks = array())
    {
        // line 14
        echo "\t\t<div class=\"logo\">
\t\t\t<p>OOPS! - Could not Find it</p>
\t\t\t<img src=\"images/404-1.png\">
\t\t\t<div class=\"sub\">
\t\t\t  <p><a href=\"#\">Back </a></p>
\t\t\t</div>
\t\t</div>
\t\t";
    }

    // line 25
    public function block_javascripts($context, array $blocks = array())
    {
        // line 26
        echo "        ";
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
        return array (  98 => 26,  95 => 25,  84 => 14,  81 => 13,  77 => 9,  74 => 8,  68 => 5,  62 => 27,  60 => 25,  56 => 24,  52 => 22,  50 => 13,  43 => 10,  41 => 8,  37 => 7,  33 => 6,  29 => 5,  23 => 1,);
    }
}
