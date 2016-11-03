<?php

class PagePresenter extends BasePresenter
{
    /** @var \Model\Api\ApiService */
    protected $apiService;

    /** @var \Model\ClAccountInfo */
    protected $clAccountInfo;


    public function injectApiService(\Model\Api\ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function injectClAccountInfo(\Model\ClAccountInfo $clAccountInfo)
    {
        $this->clAccountInfo = $clAccountInfo;
    }

    protected function startup()
    {
        parent::startup();

        //TODO Solve deprecated Nette\Diagnostics\Debugger::$bar
        Nette\Diagnostics\Debugger::$bar = FALSE;

        // set XSRF-TOKEN cookie - for AngularJS built-in CSRF protection
        $this->getHttpResponse()->setCookie('XSRF-TOKEN', $this->getCsrfToken(), 0, NULL, NULL, NULL, FALSE);

        // HTML HEAD DATA - ENUMs
        $this->template->enums = array();

        $this->template->enums['E_TroubleState'] = \Model\Enum\TroubleState::getConstants();
        $this->template->enums['E_ProjectType'] = \Model\Enum\ProjectType::getConstants();

        $this->template->configSectionLoc = $this->context->configSectionLoc;
        $this->template->configSectionApp = $this->context->configSectionApp;

        $runningTracking = $this->dm->getDb()->select('dt')->from('tracking')
            ->where("person_id = %i AND [in] IS NULL", $this->clIdentity->getPersonId())
            ->execute()->fetchSingle();

        $this->template->trackingStartTime = $runningTracking ? $runningTracking->format('Y-m-d H:i:s') : NULL;
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
