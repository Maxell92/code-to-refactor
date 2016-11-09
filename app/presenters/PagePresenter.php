<?php

namespace App\Presenters;

use App\Model\Api\ApiService;
use App\Model\ClAccountInfo;
use App\Model\Enum\ProjectType;
use App\Model\Enum\TroubleState;

class PagePresenter extends BasePresenter
{

    /** @var ApiService @inject */
    public $apiService;

    /** @var ClAccountInfo @inject */
    public $clAccountInfo;

    protected function startup()
    {
        parent::startup();

        // set XSRF-TOKEN cookie - for AngularJS built-in CSRF protection
        $this->getHttpResponse()->setCookie('XSRF-TOKEN', $this->getCsrfToken(), 0, NULL, NULL, NULL, FALSE);

        // HTML HEAD DATA - ENUMs
        $this->template->enums = array();

        $this->template->enums['E_TroubleState'] = TroubleState::getConstants();
        $this->template->enums['E_ProjectType'] = ProjectType::getConstants();

        $this->template->configSectionLoc = $this->context->configSectionLoc;
        $this->template->configSectionApp = $this->context->configSectionApp;

        $runningTracking = $this->dm->getDb()->select('dt')->from('tracking')
            ->where("person_id = %i AND [in] IS NULL", $this->clIdentity->getPersonId())
            ->execute()->fetchSingle();

        $this->template->trackingStartTime = $runningTracking;
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
