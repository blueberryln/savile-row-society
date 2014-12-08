<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Offers Controller
 */
class OffersController extends AppController {

	public function register($offer){

		$current_offers = array('giveaway50', 'giveaway100', 'cybermonday', 'holiday-offer');
		$offer_details = array('giveaway50' => array('discount' => 50, 'minimum' => 250), 'giveaway100' => array('discount' => 100, 'minimum' => 250), 'cybermonday' => array('discount' => 100, 'minimum' => 100), 'holiday-offer' => array('discount' => 100, 'minimum' => 250)); 

		$text = '';
		if($offer == 'giveaway50'){
			$text = "<p>Welcome to Savile Row Society.</p>  
					<p>In addition to Zero Membership Fees,<br>
					Please enjoy this exclusive offer of<br>
					$50 Off Your First Order <br>
					of $250 or More.</p>
					<p>Welcome to the new you!</p>";
		}
		else if($offer == 'giveaway100'){
			$text = "<p>Welcome to Savile Row Society.</p>  
					<p>In addition to Zero Membership Fees,<br>
					Please enjoy this exclusive offer of<br>
					$100 Off Your First Order <br>
					of $250 or More.</p>
					<p>Welcome to the new you!</p>";
		}
		else if($offer == 'cybermonday'){
			$text = "<p>Welcome to Savile Row Society.</p>  
					<p>In addition to Zero Membership Fees,<br>
					Please enjoy this exclusive offer of<br>
					$100 Off Your First Order <br>
					of $100 or More.</p>
					<p>Welcome to the new you!</p>";
		}
		else if($offer == 'holiday-offer'){
			$text = "<p>Welcome to Savile Row Society.</p>  
					<p>Please enjoy this exclusive Holiday offer of<br>
					$100 Off Your Order<br>
					of $250 or More.</p>
					<p>Happy Holidays from all of us at SRS!</p>
					<p>Welcome to the new you!</p>";
		}

		$user = $this->getLoggedUser();
        if(!$user && in_array($offer, $current_offers)){
            
            $landing_offer = array();
            $landing_offer['UserOffer']['offer'] = $offer;
            $landing_offer['UserOffer']['discount'] = $offer_details[$offer]['discount'];
            $landing_offer['UserOffer']['minimum'] = $offer_details[$offer]['minimum'];

            $this->Session->write('landing_text', $text);
            $this->Session->write('landing_offer', $landing_offer);
            $this->Session->write('showAffiliatePopup', true);

            $noindex = 1;
            $this->set(compact('noindex'));
        }
        else{
            $this->redirect('/');
            exit;
        }

        $this->render('/Pages/home');

	}

}