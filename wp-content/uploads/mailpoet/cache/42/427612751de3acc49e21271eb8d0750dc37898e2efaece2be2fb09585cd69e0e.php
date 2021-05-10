<?php

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Error\RuntimeError;
use MailPoetVendor\Twig\Markup;
use MailPoetVendor\Twig\Sandbox\SecurityError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedTagError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFilterError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFunctionError;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\Template;

/* revenue_tracking_permission.html */
class __TwigTemplate_450a5fca472adcd34b4ab5938c32765d5a8420a8bf3e62bf05e10a07f2199f57 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html", "revenue_tracking_permission.html", 1);
        $this->blocks = [
            'content' => [$this, 'block_content'],
            'translations' => [$this, 'block_translations'],
        ];
    }

    protected function doGetParent(array $context)
    {
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "<script>
  var mailpoet_logo_url = '";
        // line 5
        echo $this->env->getExtension('MailPoet\Twig\Assets')->generateCdnUrl("welcome-wizard/mailpoet-logo.20190109-1400.png");
        echo "';
  var finish_wizard_url = '";
        // line 6
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["finish_wizard_url"] ?? null), "html", null, true);
        echo "';
</script>

<div id=\"mailpoet_wizard_container\"></div>

";
    }

    // line 13
    public function block_translations($context, array $blocks = [])
    {
        // line 14
        echo $this->env->getExtension('MailPoet\Twig\I18n')->localize(["revenueTrackingInfo1" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("MailPoet can use browser cookies for more precise WooCommerce tracking.", "Browser cookies are data created by websites and stored in visitors web browser"), "revenueTrackingInfo2" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("This is practical for abandoned cart emails and when a customer uses several email addresses.", "“abandoned cart emails“ are emails which are sent automatically from e-commerce websites when a customer add a product to the cart and then leave the website"), "revenueTrackingAllow" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Allow MailPoet cookies. My visitors are made aware that cookies are used on my website.", "“MailPoet cookies” and “cookies” are browser cookies created by MailPoet"), "revenueTrackingDontAllow" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Don’t allow MailPoet cookies and rely on basic revenue tracking.", "“MailPoet cookies” are browser cookies created by MailPoet"), "revenueTrackingSubmit" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Save", "Submit button caption")]);
        // line 20
        echo "
";
    }

    public function getTemplateName()
    {
        return "revenue_tracking_permission.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 20,  63 => 14,  60 => 13,  50 => 6,  46 => 5,  43 => 4,  40 => 3,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "revenue_tracking_permission.html", "C:\\Xampp\\htdocs\\sachhay\\wp-content\\plugins\\mailpoet\\views\\revenue_tracking_permission.html");
    }
}
