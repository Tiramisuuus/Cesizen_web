<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmotionsTrackerController extends AbstractController{

    /**
     * @return mixed
     * Route for the emotions tracker
     * Take the user in session if exist (no emotions tracker for not registered user)
     * create a form with all emotions ( primary and secondary ) that are linked to checkbox
     * On form submit -> calculate emotion tracker final score and add the emotions tracker in Database
     *
     */
    #[Route('/Traqueur', name : 'emotions-tracker')]
    public function emotionsTracker(){


        return $this->render('pages/emotions-tracker.html.twig');
    }

    /**
     * @return void
     * Shows the list of all emotions trackers linked to the user in session
     */
    #[Route('/Liste des traqueurs', name :'emotions-tracker-list')]
    public function emotionsTrackerList(){
        return $this->render('pages/emotions-tracker-list.html.twig');

    }

    /**
     * Page for emotions statistics
     *
     */
    #[Route('/Statistiques', name:'emotions-stats')]
    public function emotionsStats(){
        $this->render('pages/emotions-statistics');

    }

}