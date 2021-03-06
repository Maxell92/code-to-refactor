<?php

namespace App\Presenters;

use App\Model\Api\ApiService;
use App\Model\ClAccountInfo;
use App\Model\Config;
use App\Model\Enum\ProjectType;
use App\Model\Enum\TroubleState;
use App\Model\Tracking;

class PagePresenter extends BasePresenter
{

    /** @var ApiService @inject */
    public $apiService;

    /** @var ClAccountInfo @inject */
    public $clAccountInfo;

    /** @var Config @inject */
    public $config;

    /** @var Tracking @inject */
    public $tracking;

    protected function startup()
    {
        parent::startup();

        // set XSRF-TOKEN cookie - for AngularJS built-in CSRF protection
        $this->getHttpResponse()->setCookie('XSRF-TOKEN', $this->getCsrfToken(), 0, NULL, NULL, NULL, FALSE);

        // HTML HEAD DATA - ENUMs
        $this->template->enums = array();

        $this->template->enums['E_TroubleState'] = TroubleState::getConstants();
        $this->template->enums['E_ProjectType'] = ProjectType::getConstants();

        $this->template->configSectionLoc = $this->config->getLoc();
        $this->template->configSectionApp = $this->config->getApp();

        $this->template->trackingStartTime = $this->tracking->getRunningTracking();;
    }


    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);
        $template->getLatte()->addFilter(NULL, 'Cl\TemplateHelperLoader::loader');

        return $template;
    }

    protected function createComponentHead()
    {
        return new Head();
    }
}
