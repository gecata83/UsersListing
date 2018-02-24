<?php

namespace Application\Controller;

use Application\Service\UsersListing;
use Zend\Mvc\Controller\AbstractActionController;
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

    }
}
