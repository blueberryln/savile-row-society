<?php

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    /**
     * Add behaviour
     * @var type 
     */
    public $actsAs = array('Containable');

    /**
     * Not recursive
     * @var type 
     */
    public $recursive = -1;

    /**
     * Cache queries and store them in memeory 
     */
    public $cacheQueries = true;

}
