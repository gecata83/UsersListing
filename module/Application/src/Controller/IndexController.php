<?php

namespace Application\Controller;

use Application\Service\UsersListing;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * @var UsersListing
     */
    protected $usersListingService;

    /**
     * IndexController constructor.
     * @param UsersListing $usersListingService
     */
    public function __construct(UsersListing $usersListingService)
    {
        $this->usersListingService = $usersListingService;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();

        $usersInfo = $this->usersListingService->getResult();

        $viewModel->setVariable("usersInfo", $usersInfo);
        return $viewModel;
    }

    public function loadMoreAction()
    {
        $viewModel = new JsonModel();
        $recordNumber = $this->params()->fromQuery("recordNumber", 0);

        $usersInfo = $this->usersListingService->getResult(9, $recordNumber);

        if (empty($usersInfo)) {
            $viewModel->setVariable("endOfTheList", true);
        } else {
            $viewModel->setVariables($usersInfo);
        }


        return $viewModel;
    }
}
