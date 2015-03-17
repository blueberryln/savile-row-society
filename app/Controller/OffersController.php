<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Offers Controller
 */
class OffersController extends AppController {

	public function register($offer){

		$offer_details = $this->getOfferDetails($offer);

		$user = $this->getLoggedUser();
        if(!$user && $offer_details){
            
            $landing_offer = array();
            $landing_offer['UserOffer']['offer'] = $offer;
            $landing_offer['UserOffer']['discount'] = $offer_details['discount'];
            $landing_offer['UserOffer']['minimum'] = $offer_details['minimum'];

            $this->Session->write('landing_text', $offer_details['text']);
            $this->Session->write('landing_offer', $landing_offer);
            $this->Session->write('showAffiliatePopup', true);

            $noindex = 1;
            $this->set(compact('noindex'));
        }
        else{
            $this->redirect('/');
            exit;
        }

        //Get Top Stylists
        $TopStylist = ClassRegistry::init('TopStylist');
        $topStylists = $TopStylist->getTopStylists();

        $firstStylist = count($topStylists) ? $topStylists[0] : false;
        
        //Get Top Outfits
        $TopOutfit = ClassRegistry::init('TopOutfit');
        $topOutfits = $TopOutfit->getTopOutfits();
        $title_for_layout = "Personal Stylist Menswear Online Fashion Shopping Website - Buy Mens Designer Clothes";

        $this->set(compact('topStylists','topOutfits', 'firstStylist'));

        $this->render('/Pages/home');

	}

     //shubham code thankyou
    public function thankyou(){

        if(!$this->Session->read('user')){
            $this->redirect('/');
            exit;
        }
        $TopStylist = ClassRegistry::init('TopStylist');
        $topStylists = $TopStylist->getTopStylists();

        $firstStylist = count($topStylists) ? $topStylists[0] : false;
        
        //Get Top Outfits
        $TopOutfit = ClassRegistry::init('TopOutfit');
        $topOutfits = $TopOutfit->getTopOutfits();
        $title_for_layout = "Personal Stylist Menswear Online Fashion Shopping Website - Buy Mens Designer Clothes";

        $thankyou = $this->Session->read('thankyou');
        //$this->Session->delete('thankyou');
        $this->set(compact('topStylists','topOutfits', 'firstStylist','thankyou','title_for_layout'));
        
        $this->render('/Pages/home');
    }


}