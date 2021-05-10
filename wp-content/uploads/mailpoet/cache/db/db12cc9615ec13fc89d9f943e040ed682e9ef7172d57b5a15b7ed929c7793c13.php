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

/* newsletters.html */
class __TwigTemplate_effc11c4b288182c46aa81da7bc7769da8e5ae6ff4b51c3fbdf4d9f9fcc8cf00 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html", "newsletters.html", 1);
        $this->blocks = [
            'content' => [$this, 'block_content'],
            'translations' => [$this, 'block_translations'],
            'after_translations' => [$this, 'block_after_translations'],
            'after_javascript' => [$this, 'block_after_javascript'],
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
        echo "  <div id=\"newsletters_container\"></div>

  <script type=\"text/javascript\">
    ";
        // line 8
        echo "      var mailpoet_update_available = ";
        echo ((($context["is_mailpoet_update_available"] ?? null)) ? ("true") : ("false"));
        echo "
      var mailpoet_listing_per_page = ";
        // line 9
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["items_per_page"] ?? null), "js", null, true);
        echo ";
      var mailpoet_display_nps_poll = ";
        // line 10
        echo (($this->getAttribute(($context["settings"] ?? null), "display_nps_poll", [])) ? ("true") : ("false"));
        echo ";
      var mailpoet_segments = ";
        // line 11
        echo json_encode(($context["segments"] ?? null));
        echo ";
      var mailpoet_show_congratulate_after_first_newsletter = ";
        // line 12
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["show_congratulate_after_first_newsletter"] ?? null), "js", null, true);
        echo ";
      var mailpoet_installed_days_ago = ";
        // line 13
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["installed_days_ago"] ?? null), "js", null, true);
        echo ";
      var mailpoet_current_wp_user = ";
        // line 14
        echo json_encode(($context["current_wp_user"] ?? null));
        echo ";
      var mailpoet_current_wp_user_firstname = '";
        // line 15
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["current_wp_user_firstname"] ?? null), "js", null, true);
        echo "';
      var mailpoet_lists = ";
        // line 16
        echo json_encode(($context["lists"] ?? null));
        echo ";
      var mailpoet_roles = ";
        // line 17
        echo json_encode(($context["roles"] ?? null));
        echo ";
      var mailpoet_current_date = ";
        // line 18
        echo json_encode(($context["current_date"] ?? null));
        echo ";
      var mailpoet_current_time = ";
        // line 19
        echo json_encode(($context["current_time"] ?? null));
        echo ";
      var mailpoet_schedule_time_of_day = ";
        // line 20
        echo json_encode(($context["schedule_time_of_day"] ?? null));
        echo ";
      var mailpoet_date_display_format = \"";
        // line 21
        echo $this->env->getExtension('MailPoet\Twig\Functions')->getWPDateFormat();
        echo "\";
      var mailpoet_start_of_week = \"";
        // line 22
        echo $this->env->getExtension('MailPoet\Twig\Functions')->getWPStartOfWeek();
        echo "\";
      var mailpoet_site_url = \"";
        // line 23
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["site_url"] ?? null), "js", null, true);
        echo "\";
      var mailpoet_date_storage_format = \"Y-m-d\";
      var mailpoet_tracking_enabled = ";
        // line 25
        echo json_encode(($context["tracking_enabled"] ?? null));
        echo ";
      var mailpoet_premium_active = ";
        // line 26
        echo json_encode(($context["premium_plugin_active"] ?? null));
        echo ";
      var mailpoet_woocommerce_active = ";
        // line 27
        echo json_encode(($context["is_woocommerce_active"] ?? null));
        echo ";
      var mailpoet_automatic_emails = ";
        // line 28
        echo json_encode(($context["automatic_emails"] ?? null));
        echo ";
      var mailpoet_feature_announcement_has_news = ";
        // line 29
        echo json_encode(($context["feature_announcement_has_news"] ?? null));
        echo ";
      var mailpoet_last_announcement_seen = ";
        // line 30
        echo json_encode(($context["last_announcement_seen"] ?? null));
        echo ";
      var mailpoet_user_locale = '";
        // line 31
        echo $this->env->getExtension('MailPoet\Twig\I18n')->getLocale();
        echo "';
      var mailpoet_congratulations_success_image = '";
        // line 32
        echo $this->env->getExtension('MailPoet\Twig\Assets')->generateCdnUrl("newsletter/congrat-illu-success.20181121-1440.png");
        echo "';
      var mailpoet_congratulations_loading_image = '";
        // line 33
        echo $this->env->getExtension('MailPoet\Twig\Assets')->generateCdnUrl("newsletter/congratulation-page-illustration-transparent-LQ.20181121-1440.png");
        echo "';
      var mailpoet_main_page = '";
        // line 34
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["mailpoet_main_page"] ?? null), "js", null, true);
        echo "';
      var mailpoet_review_request_illustration_url = '";
        // line 35
        echo $this->env->getExtension('MailPoet\Twig\Assets')->generateCdnUrl("review-request/review-request-illustration.20181207-1345.png");
        echo "';
      ";
        // line 36
        $context["newUser"] = (((($context["is_new_user"] ?? null) == true)) ? ("true") : ("false"));
        // line 37
        echo "      var mailpoet_is_new_user = ";
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["newUser"] ?? null), "js", null, true);
        echo ";
      var mailpoet_installed_at = '";
        // line 38
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute(($context["settings"] ?? null), "installed_at", []), "js", null, true);
        echo "';
      var mailpoet_mss_active = ";
        // line 39
        echo json_encode(($context["mss_active"] ?? null));
        echo ";
      var mailpoet_free_plan_announcement_seen = !!+'";
        // line 40
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute(($context["settings"] ?? null), "free_plan_announcement_seen", []), "js", null, true);
        echo "';
      var mailpoet_mta_method = '";
        // line 41
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "mta", []), "method", []), "js", null, true);
        echo "';
      ";
        // line 42
        if ( !($context["premium_plugin_active"] ?? null)) {
            // line 43
            echo "        var mailpoet_subscribers_count = ";
            echo \MailPoetVendor\twig_escape_filter($this->env, ($context["subscribers_count"] ?? null), "js", null, true);
            echo ";
        var mailpoet_free_premium_subscribers_limit = ";
            // line 44
            echo \MailPoetVendor\twig_escape_filter($this->env, ($context["free_premium_subscribers_limit"] ?? null), "js", null, true);
            echo ";
      ";
        }
        // line 46
        echo "    ";
        // line 47
        echo "  </script>
";
    }

    // line 50
    public function block_translations($context, array $blocks = [])
    {
        // line 51
        echo "  ";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->localize(["pageTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Emails"), "dismissButton" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Dismiss this notice."), "tabStandardTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Newsletters"), "tabWelcomeTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Welcome Emails"), "tabNotificationTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Post Notifications"), "tabWoocommerceTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("WooCommerce Emails"), "searchLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Search"), "loadingItems" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Loading emails..."), "noItemsFound" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Nothing here yet! But, don't fret - there's no reason to get upset. Pretty soon, you’ll be sending emails faster than a turbo-jet."), "selectAllLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("All emails on this page are selected."), "selectedAllLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("All %d emails are selected."), "selectAllLink" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select all emails on all pages"), "clearSelection" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Clear selection"), "permanentlyDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%d emails were permanently deleted."), "selectBulkAction" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select bulk action"), "bulkActions" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Bulk Actions"), "apply" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Apply"), "filter" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Filter"), "emptyTrash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Empty Trash"), "selectAll" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select All"), "restore" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Restore"), "deletePermanently" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Delete Permanently"), "showMoreDetails" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Show more details"), "previousPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Previous page"), "firstPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("First page"), "nextPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Next page"), "lastPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Last page"), "currentPage" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Current page"), "pageOutOf" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("of"), "numberOfItemsSingular" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 item"), "numberOfItemsMultiple" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d items"), "selectType" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select type"), "events" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Events"), "conditions" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Conditions", "Configuration options for automatic email events"), "template" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Template"), "designer" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Designer"), "send" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send"), "subject" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subject"), "status" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Status"), "statsListingActionTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Statistics"), "statistics" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Opened, Clicked"), "lists" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Lists"), "settings" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Settings"), "history" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("History"), "viewHistory" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("View history"), "createdOn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Created on"), "lastModifiedOn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Last modified on"), "sentOn" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sent on"), "oneNewsletterTrashed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 email was moved to the trash."), "multipleNewslettersTrashed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d emails were moved to the trash."), "oneNewsletterDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 email was permanently deleted."), "multipleNewslettersDeleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d emails were permanently deleted."), "oneNewsletterRestored" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1 email has been restored from the Trash."), "multipleNewslettersRestored" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d emails have been restored from the Trash."), "trash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Trash"), "moveToTrash" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Move to trash"), "edit" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Edit"), "duplicate" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Duplicate"), "newsletterDuplicated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Email \"%\$1s\" has been duplicated."), "notSentYet" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Not sent yet"), "scheduledFor" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Scheduled for"), "scheduleIt" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Schedule it"), "active" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Active"), "inactive" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Not Active"), "newsletterQueueCompleted" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sent to %\$1d of %\$2d"), "sentToXSubscribers" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("%\$1d sent", "number of welcome emails sent"), "scheduledToXSubscribers" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("%\$1d scheduled", "number of welcome emails scheduled to be sent"), "resume" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Resume"), "pause" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Pause"), "paused" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Paused"), "new" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Add New"), "excellentBadgeName" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Excellent"), "excellentBadgeTooltip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Congrats!"), "goodBadgeName" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Good"), "goodBadgeTooltip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Good stuff."), "badBadgeName" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Bad"), "badBadgeTooltip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Something to improve."), "openedStatTooltip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Above 30% is excellent.\\nBetween 10 and 30% is good.\\nUnder 10% is bad."), "clickedStatTooltip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Above 3% is excellent.\\nBetween 1 and 3% is good.\\nUnder 1% is bad."), "unsubscribedStatTooltip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Under 1% is excellent.\\nBetween 1 and 3% is good.\\nOver 3% is bad."), "revenueStatsTooltip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Revenues generated by customers who made a purchase within two weeks after they clicked on this email. This is the sum of the order totals including shipping and taxes."), "checkBackInHours" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Nice job! Check back in %\$1d hour(s) for more stats."), "improveThisLinkText" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("What can I do to improve this?"), "templateFileMalformedError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This template file appears to be damaged. Please try another one."), "importTemplateTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Import a template"), "selectJsonFileToUpload" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select a .json file to upload"), "helpTooltipTemplateUpload" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("You can only upload .json templates that were originally created with MailPoet 3."), "upload" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Upload"), "mailpoetGuideTemplateTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("MailPoet's Guide"), "confirmTemplateDeletion" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("You are about to delete the template named \"%\$1s\"."), "delete" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Delete"), "select" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Select", "Verb"), "preview" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview"), "selectTemplateTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select a responsive template"), "draftNewsletterTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subject"), "draftPostNotificationTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("The last [newsletter:total] posts from our blog"), "pickCampaignType" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select type of email"), "seeVideoGuide" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("See video guide"), "regularNewsletterTypeTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Newsletter"), "regularNewsletterTypeDescription" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send a newsletter with images, buttons, dividers, and social bookmarks. Or, just send a basic text email."), "create" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Create"), "welcomeNewsletterTypeTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Welcome Email"), "welcomeNewsletterTypeDescription" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Automatically send an email (or series of emails) to new subscribers or WordPress users. Send a day, a week, or a month after they sign up."), "premiumFeatureLink" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This is a Premium feature"), "setUp" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Set up"), "postNotificationNewsletterTypeTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Latest Post Notifications"), "postNotificationNewsletterTypeDescription" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Let MailPoet email your subscribers with your latest content. You can send daily, weekly, monthly, or even immediately after publication."), "selectFrequency" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select a frequency"), "postNotificationSubjectLineTip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Insert [newsletter:total] to show number of posts, [newsletter:post_title] to show the latest post's title & [newsletter:number] to display the issue number."), "activate" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Activate"), "sendWelcomeEmailWhen" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send this Welcome Email when..."), "daily" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Once a day at..."), "weekly" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Weekly on..."), "monthly" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Monthly on the..."), "monthlyEvery" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Monthly every..."), "immediately" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Immediately"), "sunday" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sunday"), "monday" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Monday"), "tuesday" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Tuesday"), "wednesday" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Wednesday"), "thursday" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Thursday"), "friday" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Friday"), "saturday" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Saturday"), "first" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("1st"), "second" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("2nd"), "third" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("3rd"), "nth" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1dth"), "last" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("last", "e.g. monthly every last Monday"), "next" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Next", "Button label: Next step"), "selectEventToSendWelcomeEmail" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("When is this Welcome Email sent?"), "onSubscriptionToList" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("When someone subscribes to the list..."), "onWPUserRegistration" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("When a new WordPress user is added to your site..."), "delayImmediately" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("immediately"), "delayHoursAfter" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("hour(s) later"), "delayDaysAfter" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("day(s) later"), "delayWeeksAfter" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("week(s) later"), "subjectLine" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subject line"), "subjectLineTip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Be creative! It's the first thing that your subscribers see. Tempt them to open your email."), "emptySubjectLineError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please specify a subject"), "segments" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Lists"), "segmentsTip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This subscriber segment will be used for this email."), "selectSegmentPlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select a list"), "noSegmentsSelectedError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please select a list"), "sender" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sender"), "senderTip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your name and email"), "senderNamePlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("John Doe"), "senderAddressPlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("john.doe@email.com"), "replyTo" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Reply-to"), "replyToTip" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("When your subscribers reply to your emails, their emails will go to this address."), "replyToNamePlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("John Doe"), "replyToAddressPlaceholder" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("john.doe@email.com"), "newsletterUpdated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Email was updated successfully!"), "newsletterAdded" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Email was added successfully!"), "newsletterSendingError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("An error occurred while trying to send. <a href=\"%\$1s\">Please check your settings</a>."), "finalNewsletterStep" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Final Step: Last Details"), "saveDraftAndClose" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Save as draft and close"), "helpTooltipSendEmail" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("You cannot send the same email twice, as that would be considered spam. <br /> If you must send the same email more than one time, simply duplicate this email first."), "orSimply" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("or simply"), "goBackToDesign" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("go back to the Design page"), "websiteTimeIs" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your website’s time is"), "noScheduledDateError" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please enter the scheduled date."), "schedule" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Schedule"), "close" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Close"), "today" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Today"), "january" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("January"), "february" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("February"), "march" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("March"), "april" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("April"), "may" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("May"), "june" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("June"), "july" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("July"), "august" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("August"), "september" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("September"), "october" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("October"), "november" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("November"), "december" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("December"), "januaryShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Jan"), "februaryShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Feb"), "marchShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Mar"), "aprilShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Apr"), "mayShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("May"), "juneShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Jun"), "julyShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Jul"), "augustShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Aug"), "septemberShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sep"), "octoberShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Oct"), "novemberShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Nov"), "decemberShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Dec"), "sundayShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sun"), "mondayShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Mon"), "tuesdayShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Tue"), "wednesdayShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Wed"), "thursdayShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Thu"), "fridayShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Fri"), "saturdayShort" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sat"), "sundayMin" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("S", "Sunday - one letter abbreviation"), "mondayMin" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("M", "Monday - one letter abbreviation"), "tuesdayMin" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("T", "Tuesday - one letter abbreviation"), "wednesdayMin" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("W", "Wednesday - one letter abbreviation"), "thursdayMin" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("T", "Thursday - one letter abbreviation"), "fridayMin" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("F", "Friday - one letter abbreviation"), "saturdayMin" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("S", "Saturday - one letter abbreviation"), "next" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Next"), "previous" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Previous"), "newsletterBeingSent" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("The newsletter is being sent..."), "newsletterHasBeenScheduled" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("The newsletter has been scheduled."), "newsletterSendingHasBeenResumed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("The newsletter sending has been resumed."), "newsletterInvalidFromAddress" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("You need to authorize the email address <i>%\$1s</i> to be able to send with it. [link]Authorize my email address[/link]", "Users need to confirm that they own the email address they want to use to send their newsletter"), "welcomeEmailActivated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your Welcome Email is now activated!"), "welcomeEmailActivationFailed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your Welcome Email could not be activated, please check the settings."), "postNotificationActivated" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your post notification is now active!"), "postNotificationActivationFailed" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your Post Notification could not be activated, check the settings."), "welcomeEventSegment" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This newsletter is sent when someone subscribes to the list: \"%\$1s\"."), "welcomeEventWPUserAnyRole" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This newsletter is sent when a new WordPress user is added to your site."), "welcomeEventWPUserWithRole" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This newsletter is sent when a new WordPress user with the role \"%\$1s\" is added to your site."), "sendingDelayMinutes" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d minute(s) later"), "sendingDelayHours" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d hour(s) later"), "sendingDelayDays" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d day(s) later"), "sendingDelayWeeks" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("%\$1d week(s) later"), "sendingDelayInvalid" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Invalid sending delay"), "sendDaily" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send daily at %\$1s"), "sendWeekly" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send weekly on %\$1s at %\$2s"), "sendMonthly" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send monthly on the %\$1s at %\$2s"), "sendNthWeekDay" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send every %\$1s %\$2s of the month at %\$3s"), "sendImmediately" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Send immediately"), "ifNewContentToSegments" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("if there's new content to %\$1s."), "sendingToSegmentsNotSpecified" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("You need to select a list to send to."), "backToPostNotifications" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Back to Post notifications"), "noSubscribers" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("No subscribers!"), "mailerSendErrorNotice" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sending has been paused due to a technical issue with %\$1s"), "mailerSendErrorCheckConfiguration" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Please check your sending method configuration, you may need to consult with your hosting company."), "mailerSendErrorUseSendingService" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("The easy alternative is to <b>send emails with MailPoet Sending Service</b> instead, like thousands of other users do."), "mailerSendErrorSignUpForSendingService" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sign up for free in minutes"), "mailerConnectionErrorNotice" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sending is paused because the following connection issue prevents MailPoet from delivering emails"), "mailerErrorCode" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Error code: %\$1s"), "mailerCheckSettingsNotice" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Check your [link]sending method settings[/link]."), "mailerResumeSendingButton" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Resume sending"), "confirmEdit" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sending is in progress. Do you want to pause sending and edit the newsletter?"), "confirmTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Confirm to proceed"), "confirmLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Confirm"), "cancelLabel" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Cancel"), "recentlySent" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Recently sent"), "savedTemplates" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Your saved templates"), "templatePreview" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Template preview"), "zoom" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview"), "allTemplates" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("All", "Name of a section with all email templates"), "tabImportTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Import", "Importing template tab title"), "noTemplates" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("This category does not contain any template yet!"), "soon" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Soon"), "beta" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Beta"), "errorWhileTakingScreenshot" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("An error occured while saving the template in \"Recently sent\""), "selectAutomaticEmailsEventsHeading" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Select %\$1s events"), "cronNotAccessibleNotice" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Oops! There seems to be an issue with the sending on your website. [link]See our guide[/link] to solve this yourself."), "introLists" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Welcome on board. Let’s get you started quickly. Here, you can create new lists."), "introForms" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Create a form and add it to your website so your visitors can subscribe to your list."), "introChat" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("You have a question? Start a chat or send a message to get an answer from our support team."), "introEmails" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("We suggest you begin by creating a newsletter, a welcome email or a post notification. Enjoy!"), "introNext" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Next", "A label on a button"), "introBack" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Back", "A label on a button"), "introSkip" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Skip", "A label on a button"), "introDone" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Done", "A label on a button"), "whatsNew" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("What’s new"), "updateMailPoetNotice" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("[link]Update MailPoet[/link] to see the latest changes"), "freePlanTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("A new and more generous free plan!"), "freePlanDescription" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("MailPoet Premium and sending is now entirely free for users that have 1,000 subscribers or less."), "freePlanButton" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Get MailPoet Premium for free now"), "congratulationsSendSuccessHeader" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Congratulations, your newsletter is being sent!"), "congratulationsScheduleSuccessHeader" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Congratulations, your newsletter is scheduled to be sent."), "congratulationsWooSuccessHeader" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Congratulations, your WooCommerce email has been activated."), "congratulationsPostNotificationSuccessHeader" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Congratulations, your Post Notification is now active."), "congratulationsWelcomeEmailSuccessHeader" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Congratulations, your Welcome Email is now active."), "congratulationsSendFailHeader" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Oops! We can’t send your newsletter 😕"), "congratulationsSendFailExplain" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Rest assured, this is fairly common and is usually fixed quickly. [link]See our quick guide[/link] to help you solve this and get your website sending."), "congratulationsLoadingHeader" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Congrats, you’re sending your first newsletter! We’re doing a quick verification to make sure everything works fine."), "reviewRequestHeading" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Thank you! Time to tell the world?", "After a user gives us positive feedback via the NPS poll, we ask them to review our plugin on WordPress.org."), "reviewRequestDidYouKnow" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("[username], did you know that hundreds of WordPress users read the reviews on the plugin repository? They’re also a source of inspiration for our team."), "reviewRequestUsingForDays" => $this->env->getExtension('MailPoet\Twig\I18n')->pluralize("You’ve been using MailPoet for [days] day now, and we would love to read your own review.", "You’ve been using MailPoet for [days] days now, and we would love to read your own review.",         // line 351
($context["installed_days_ago"] ?? null)), "reviewRequestUsingForMonths" => $this->env->getExtension('MailPoet\Twig\I18n')->pluralize("You’ve been using MailPoet for [months] month now, and we would love to read your own review.", "You’ve been using MailPoet for [months] months now, and we would love to read your own review.", \MailPoetVendor\twig_round((        // line 352
($context["installed_days_ago"] ?? null) / 30))), "reviewRequestRateUsNow" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Rate us now", "Review our plugin on WordPress.org."), "reviewRequestNotNow" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Not now"), "sendingStatusTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Sending status", "Page title. This page displays a list of emails along with their sending status: unprocessed, sent or failed."), "subscriber" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subscriber"), "sendingStatus" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Sending status", "an email sending status: unprocessed, sent or failed."), "failureReason" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Failure reason (if applicable)"), "resend" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Resend"), "unprocessed" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Unprocessed", "status when the sending of a newsletter has not been processed"), "sent" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Sent", "status when a newsletter has been sent"), "failed" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("Failed", "status when the sending of a newsletter has failed"), "noSendingTaskFound" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("No sending task found."), "statsTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Stats"), "loadingStats" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Loading..."), "backToList" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Back"), "statsPreviewNewsletter" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Preview in browser"), "statsDateSent" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Date"), "statsFromAddress" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("From"), "statsToSegments" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("To"), "statsReplyToAddress" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Reply-to"), "statsTotalSent" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sent to"), "percentageOpened" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("opened", "Percentage of subscribers that opened a newsletter link"), "percentageClicked" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("clicked", "Percentage of subscribers that clicked a newsletter link"), "percentageUnsubscribed" => $this->env->getExtension('MailPoet\Twig\I18n')->translateWithContext("unsubscribed", "Percentage of subscribers that unsubscribed from a newsletter"), "readMoreOnStats" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Read more on stats."), "clickedLinks" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Clicked Links"), "subscriberEngagement" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subscriber Engagement"), "premiumBannerTitle" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Buy the Premium to see your stats", "mailpoet"), "premiumBannerCtaFree" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Sign Up for Free", "mailpoet"), "premiumBannerCtaPremium" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Purchase Now", "mailpoet"), "premiumBannerLink" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Learn more about Premium", "mailpoet")]);
        // line 386
        echo "
";
    }

    // line 389
    public function block_after_translations($context, array $blocks = [])
    {
        // line 390
        echo "  ";
        echo do_action("mailpoet_newsletters_translations_after");
        echo "
";
    }

    // line 393
    public function block_after_javascript($context, array $blocks = [])
    {
        // line 394
        if ($this->getAttribute(($context["settings"] ?? null), "show_intro", [])) {
            // line 395
            echo "<script>
  HS.beacon.ready(function () {
    document.querySelector('#hs-beacon iframe').classList.add('mailpoet-chat');
    MailPoet.showIntro();
  });
</script>
";
        }
    }

    public function getTemplateName()
    {
        return "newsletters.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 395,  228 => 394,  225 => 393,  218 => 390,  215 => 389,  210 => 386,  208 => 352,  207 => 351,  205 => 51,  202 => 50,  197 => 47,  195 => 46,  190 => 44,  185 => 43,  183 => 42,  179 => 41,  175 => 40,  171 => 39,  167 => 38,  162 => 37,  160 => 36,  156 => 35,  152 => 34,  148 => 33,  144 => 32,  140 => 31,  136 => 30,  132 => 29,  128 => 28,  124 => 27,  120 => 26,  116 => 25,  111 => 23,  107 => 22,  103 => 21,  99 => 20,  95 => 19,  91 => 18,  87 => 17,  83 => 16,  79 => 15,  75 => 14,  71 => 13,  67 => 12,  63 => 11,  59 => 10,  55 => 9,  50 => 8,  45 => 4,  42 => 3,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "newsletters.html", "C:\\Xampp\\htdocs\\sachhay\\wp-content\\plugins\\mailpoet\\views\\newsletters.html");
    }
}
