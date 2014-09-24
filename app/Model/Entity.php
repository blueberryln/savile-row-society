<?php

App::uses('AppModel', 'Model');

/**
 * Entity Model
 *
 * @property User $User
 * @property Post $Post
 * @property Product $Product
 */
class Entity extends AppModel {
      
    public $validate = array(
        'sku' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'slug' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
    );
    
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'products_entities';  

    
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    public $hasMany = array(
        'Detail' => array(
            'className' => 'Detail',
            'foreignKey' => 'product_entity_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true            
        ), 
        'Image' => array(
            'className' => 'Image',
            'foreignKey' => 'product_entity_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true            
        ),
        'Wishlist' => array(
            'className' => 'Wishlist',
            'foreignKey' => 'product_entity_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Dislike' => array(
            'className' => 'Dislike',
            'foreignKey' => 'product_entity_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Like' => array(
            'className' => 'Like',
            'foreignKey' => 'product_entity_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'OrderItem' => array(
            'className' => 'OrderItem',
            'foreignKey' => 'product_entity_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'CartItem' => array(
            'className' => 'CartItem',
            'foreignKey' => 'product_entity_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    
    public $hasAndBelongsToMany = array(
        'Color' => array(
            'className' => 'Color',
            'joinTable' => 'colors_entities',
            'foreignKey' => 'product_entity_id',
            'associationForeignKey' => 'color_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
    );
    
    
    
    /**
     * Get attached by Product ID
     * 
     * @param type $product_id
     * @return type
     */
    function getByProductID($product_id) {
        return $this->find('all', array(
                    'conditions' => array(
                        'Entity.product_id' => $product_id
                    )
        ));
    }

    /**
     * Get details by Id
     *
     * @param type $slug
     * @return type
     */
    function getById($id, $user_id=null) {
        $find_array = array(
            'contain' => array('Image', 'Color', 'Detail'),
            'conditions' => array('Entity.id' => $id),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id',
                    )
                ),        
            ), 
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
        );
        
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                    'alias' => 'Wishlist',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Wishlist.user_id' => $user_id,
                        'Wishlist.product_entity_id = Entity.id'
                    )
                );
            $find_array['joins'][] = array('table' => 'dislikes',
                    'alias' => 'Dislike',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Dislike.user_id' => $user_id,
                        'Dislike.product_entity_id = Entity.id',
                        'Dislike.show' => true
                    )
                );
            
            $find_array['fields'][] = 'Dislike.*';
            $find_array['fields'][] = 'Wishlist.*'; 
        }
        
        return $this->find('first', $find_array);
    }


    function getMultipleById($id, $user_id=null) {
        $find_array = array(
            'contain' => array('Image', 'Color', 'Detail'),
            'conditions' => array('Entity.id' => $id),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id',
                    )
                ),        
            ), 
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
        );
        
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                    'alias' => 'Wishlist',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Wishlist.user_id' => $user_id,
                        'Wishlist.product_entity_id = Entity.id'
                    )
                );
            $find_array['joins'][] = array('table' => 'dislikes',
                    'alias' => 'Dislike',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Dislike.user_id' => $user_id,
                        'Dislike.product_entity_id = Entity.id',
                        'Dislike.show' => true
                    )
                );
            
            $find_array['fields'][] = 'Dislike.*';
            $find_array['fields'][] = 'Wishlist.*'; 
        }
        
        return $this->find('all', $find_array);
    }

//for users outfits
    function getMultipleByIdUser($id, $user_id=null) {
        $find_array = array(
            'contain' => array('Image','Wishlist'),
            'conditions' => array('Entity.id' => $id),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id',
                    )
                ),
                // array('table' => 'outfits_items',
                //     'alias' => 'OutfitItem',
                //     'type' => 'LEFT',
                //     'conditions' => array(
                //         'Entity.product_id = OutfitItem.product_entity_id',
                //     )
                // ),          
            ), 
            'fields' => array(
                //'Entity.*', 'Product.*', 'Brand.*','OutfitItem.size_id',
                'Entity.*', 'Product.*', 'Brand.*',
            ),
        );
        
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                    'alias' => 'Wishlist',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Wishlist.user_id' => $user_id,
                        'Wishlist.product_entity_id = Entity.id'
                    )
                );
            
            $find_array['fields'][] = 'Wishlist.*'; 
        }
        
        return $this->find('all', $find_array);
    }

    function getCategory($id){
        return $this->find('first', array(
                'conditions' => array('Entity.id' => $id),
                'joins' => array(
                    array('table' => 'products_categories',
                        'alias' => 'PCategory',
                        'type' => 'INNER',
                        'conditions' => array(
                            'PCategory.product_id = Entity.product_id'
                        )
                    ),
                    array('table' => 'categories',
                        'alias' => 'Category',
                        'type' => 'INNER',
                        'conditions' => array(
                            'PCategory.category_id = Category.id'
                        )
                    ),
                ),
                'fields' => array(
                    'Category.*'
                )
            )
        );
    }

    /**
     * Get by Slug
     * 
     * @param type $slug
     * @return type
     */
    function getBySlug($slug) {
        return $this->find('first', array(
                    'contain' => array('Product', 'Image', 'Color'),
                    'conditions' => array('Entity.slug' => $slug)
        ));
    }



    function getSimilarProducts($id, $product_id){
        $entity = $this->find('all', array(
            'contain' => array('Color'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.product_id' => $product_id
            ),
            'order' => "Entity.id ASC",
        ));

        return $entity;
    }

    /**
     * Get by Category
     * 
     * @param type $category
     * @return type
     */
    function getByCategory($category_ids, $user_id=null, $brands = null, $colors = null) {
        $find_array = array(
            'contain' => array('Image', 'Color'),
            'conditions' => array(
                'Entity.show' => true
            ),
            'group' => array('Entity.id'),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Category.category_id' => $category_ids,
                        'Category.product_id = Entity.product_id'
                    )
                ),
                array('table' => 'wishlists',
                    'alias' => 'Wishlist',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Wishlist.user_id' => $user_id,
                        'Wishlist.product_entity_id = Entity.id'
                    )
                ),
                array('table' => 'dislikes',
                    'alias' => 'Dislike',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Dislike.user_id' => $user_id,
                        'Dislike.product_entity_id = Entity.id',
                        'Dislike.show' => true
                    )
                )
            ),
            'fields' => array(
                'Entity.*', 'Wishlist.*', 'Dislike.*'
            )
        );
        
        if($colors && count($colors) > 0){
            $color_join = array('table' => 'colors_entities',
                    'alias' => 'Color1',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Color1.color_id' => $colors,
                        'Color1.product_entity_id = Entity.id'
                    )
                );
            $find_array['joins'][] = $color_join; 
        }
        
         if($brands && count($brands) > 0){
            $brand_join = array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id' => $brands,
                        'Product.id = Entity.product_id'
                    )
                );
            $find_array['joins'][] = $brand_join; 
        }

        $entity = $this->find('all', $find_array);

        return $entity;
    }
    
    
    /**
     * get Entities By Id
     * 
     * @param type $category
     * @return type
     */
    function getEntitiesById($entity_list, $user_id = null) {
        $find_array = array(
            'contain' => array('Image', 'Color'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.id' => $entity_list
            ),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Category.product_id = Entity.product_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
            ),
            'fields' => array(
                'Entity.*', 'Category.category_id', 'Product.*', 'Brand.*',
            ),
            'order' => 'Category.category_id ASC'
        );
        
        
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.user_id' => $user_id,
                                            'Wishlist.product_entity_id = Entity.id'
                                        )
                                    );
            $find_array['joins'][] = array('table' => 'dislikes',
                                        'alias' => 'Dislike',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Dislike.user_id' => $user_id,
                                            'Dislike.product_entity_id = Entity.id',
                                            'Dislike.show' => true
                                        )
                                    );   
            
            $find_array['fields'][] = 'Wishlist.*';
            $find_array['fields'][] = 'Dislike.*'; 
        }
        
        $entity = $this->find('all', $find_array);

        return $entity;
    }


    function getEntitiesByIdLikes($entity_list, $user_id = null) {
        $find_array = array(
            'contain' => array('Image'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.id' => $entity_list
            ),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),

              
            ),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
            'order' => array('FROM_UNIXTIME(Wishlist.created) DESC'),

           
        );
        
       
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.user_id' => $user_id,
                                            'Wishlist.product_entity_id = Entity.id'
                                        ),
                                        
                                        
                                    );
        $find_array['joins'][] = array('table' => 'outfits',
                    'alias' => 'Outfit',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Outfit.id = Wishlist.outfit_id',
                    )
                );

            
        
            $find_array['fields'][] = 'Wishlist.*';
            $find_array['fields'][] = 'Outfit.*';

             
        }
        
        $entity = $this->find('all', $find_array);
        //print_r($entity);
        return $entity;
    }

    function getEntitiesByIdLikesAsc($entity_list, $user_id = null,$sortingorder) {
        
        $find_array = array(
            'contain' => array('Image'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.id' => $entity_list
            ),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
            ),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
            'order' => array('FROM_UNIXTIME(Wishlist.created)' => $sortingorder),
            
        );
        
        
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.user_id' => $user_id,
                                            'Wishlist.product_entity_id = Entity.id'
                                        ),
                                        
                                    );
            $find_array['joins'][] = array('table' => 'outfits',
                    'alias' => 'Outfit',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Outfit.id = Wishlist.outfit_id',
                    )
                );

            
            $find_array['fields'][] = 'Wishlist.*';
            $find_array['fields'][] = 'Outfit.*';
             
        }
        
    $entity = $this->find('all', $find_array);

        return $entity;
    }


    function getEntitiesByIdPurchaseSorting($entity_list,$sortingorder) {
        $ids = join(',',$entity_list);
        $db = $this->getDataSource();
        
                $sql = "Select * 
                FROM (
                SELECT Entity.name, Entity.id, OrderItem.created,(Image.name) as imagename ,(Brand.name) as brandname,Entity.price,Outfit.outfitname,(Outfit.id) as outfitid
                FROM  `products_entities` AS Entity
                INNER JOIN products_images AS Image ON Entity.id = Image.product_entity_id
                INNER JOIN products AS Product ON Entity.product_id = Product.id
                INNER JOIN brands AS Brand ON Product.brand_id = Brand.id
                INNER JOIN orders_items AS OrderItem ON Entity.id = OrderItem.product_entity_id
                INNER JOIN outfits AS Outfit ON OrderItem.outfit_id = Outfit.id
                WHERE Entity.id
                IN (".$ids.") 
                GROUP BY Image.product_entity_id
                ORDER BY OrderItem.created ".$sortingorder."
                ) AS purchase_data_sort
                ORDER BY created ".$sortingorder;

        $entity = $this->query($sql);
        return $entity;
    }


    function getEntitiesByIdPurchaseDes($entity_list) {
        $ids = join(',',$entity_list);
        $db = $this->getDataSource();
        
                $sql = "Select * 
                FROM (
                SELECT Entity.name, Entity.id, OrderItem.created,(Image.name) as imagename ,(Brand.name) as brandname,Entity.price,Outfit.outfitname,(Outfit.id) as outfitid
                FROM  `products_entities` AS Entity
                INNER JOIN products_images AS Image ON Entity.id = Image.product_entity_id
                INNER JOIN products AS Product ON Entity.product_id = Product.id
                INNER JOIN brands AS Brand ON Product.brand_id = Brand.id
                INNER JOIN orders_items AS OrderItem ON Entity.id = OrderItem.product_entity_id
                INNER JOIN outfits AS Outfit ON OrderItem.outfit_id = Outfit.id
                WHERE Entity.id
                IN (".$ids.") 
                GROUP BY Image.product_entity_id
                ORDER BY OrderItem.created DESC
                ) AS purchase_data
                ORDER BY created DESC";

        $entity = $this->query($sql);
        return $entity;
    }

    function getCloset($parent_categories){
        return $this->find('all', array(
            'conditions' => array('Entity.show' => true),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'PCategory',
                    'type' => 'INNER',
                    'conditions' => array(
                        'PCategory.category_id' => $parent_categories,
                        'PCategory.product_id = Entity.product_id',
                    )
                )
            ),
            'group' => array('PCategory.category_id'),
            'fields' => array('Entity.id')
        ));
    }


    /**
     * Checking if product is available needs to be done
     * 
     */
    function getClosestItems(){
        $sql = "SELECT pe.id, pc.category_id 
                FROM products_entities pe
                INNER JOIN products_categories pc ON pe.product_id = pc.product_id
                INNER JOIN categories cat ON pc.category_id = cat.id 
                WHERE pe.show = 1 AND pe.is_featured = 1 AND pe.is_gift != 1  
                GROUP BY pc.category_id";
                
        $result = $this->query($sql);
        return $result;
    }
    
    function getSimilarProduct($category_id, $product_id, $user_id = null){
        $find_array = array(
            'contain' => array('Image', 'Color'),
            'conditions' => array(
                'Entity.show' => true, 
                'Entity.id !=' => $product_id, 
                'Entity.hide_from_client' => false,
            ),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Category.category_id' => $category_id,
                        'Category.product_id = Entity.product_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
            ),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*', 'Category.*',
            ),
            'order' => 'rand()'
        );
        
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.user_id' => $user_id,
                                            'Wishlist.product_entity_id = Entity.id'
                                        )
                                    );
            $find_array['joins'][] = array('table' => 'dislikes',
                                        'alias' => 'Dislike',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Dislike.user_id' => $user_id,
                                            'Dislike.product_entity_id = Entity.id',
                                            'Dislike.show' => true
                                        )
                                    );   
            
            $find_array['fields'][] = 'Wishlist.*';
            $find_array['fields'][] = 'Dislike.*';    
        }
        
        return $this->find('first', $find_array);
    }
    
    function getProductDetails($entity_list){
        return $this->find('all', array(
            'contain' => array('Image', 'Color'),
            'conditions' => array(
                'Entity.id' => $entity_list
            ),
        ));
    }

    
    function getEntityStockAvailable($entity_id){
        $find_array = array(
            
        );
    }
    
    
    /**
     * Return all the gift cards
     */
    function getGiftCards(){
        return $this->find('all', array(
            'conditions' => array('Entity.show' => true, 'Entity.is_gift' => true, 'Entity.price >' => 0),
             
        ));
    }


    /**
     * Get list of random products for the closet landing - SRS Team
     * 
     */
    function getTeamClosestItems(){
        $sql = "SELECT pe.id, pc.category_id 
                FROM products_entities pe
                INNER JOIN products_categories pc ON pe.product_id = pc.product_id
                INNER JOIN categories cat ON pc.category_id = cat.id 
                WHERE pe.show = 1 AND pe.is_featured = 1    
                GROUP BY pc.category_id";
                
        $result = $this->query($sql);
        return $result;
    }


    /**
    * Get list of random products for the closet landing - Client
     * 
     */
    function getClientClosestItems(){
        $sql = "SELECT pe.id, pc.category_id 
                FROM products_entities pe
                INNER JOIN products_categories pc ON pe.product_id = pc.product_id
                INNER JOIN categories cat ON pc.category_id = cat.id 
                WHERE pe.show = 1 AND pe.is_featured = 1 AND pe.hide_from_client = 0 
                GROUP BY pc.category_id";
                
        $result = $this->query($sql);
        return $result;
    }

    
    
    /**
     * Google product shoping data
     */
    function getGoogleProductShopping(){
        $sql = "
        SELECT p.id, p.name AS title, p.description, CONCAT('http://www.savilerowsociety.com/product/',p.id,'/',p.slug) AS link, 
        CONCAT('http://www.savilerowsociety.com/files/products/', pimg.name) AS `image link`,
        'new' AS `condition`,
        CASE
        	WHEN pc.category_id IN (18,19,21,22,24,25,27,39,45,47,48,49,56,57,62,63,75,76,77,78,79,80,82,84,86,89) THEN 'Apparel & Accessories > Clothing'
        	WHEN pc.category_id IN (23) THEN 'Apparel & Accessories > Shoes'
        	WHEN pc.category_id IN (85) THEN 'Apparel & Accessories > Clothing Accessories > Socks'
        	WHEN pc.category_id IN (26,54,58,71,73) THEN 'Apparel & Accessories > Handbags, Wallets & Cases > Handbags'
        	WHEN pc.category_id IN (83,87,88) THEN 'Apparel & Accessories > Jewelry > Watches'
        	WHEN pc.category_id IN (90,91,92,93,94) THEN 'Apparel & Accessories > Jewelry > Miscellaneous'
        END AS category,  
        'in stock' AS availability, CONCAT(p.price, ' USD') AS `price`, 
        b.name, 'male' AS gender, 'adult' AS age_group, 
        GROUP_CONCAT(DISTINCT(c.name) SEPARATOR '/') AS color, GROUP_CONCAT(DISTINCT(s.name) SEPARATOR '-') AS size,
        pr.id AS item_group_id 
        FROM products_entities p
        INNER JOIN products pr ON p.product_id = pr.id
        INNER JOIN brands b ON b.id = pr.brand_id
        INNER JOIN products_categories AS pc ON pr.id = pc.product_id
        LEFT JOIN (
        	SELECT pim.name, pim.product_entity_id, MIN(pim.id) AS pid
        	FROM products_images AS pim
        	GROUP BY pim.product_entity_id
        ) AS pimg ON pimg.product_entity_id = p.id
        LEFT JOIN colors_entities AS ce ON ce.product_entity_id = p.id
        LEFT JOIN colors c ON c.id = ce.color_id
        LEFT JOIN products_details AS pd ON p.id = pd.product_entity_id
        LEFT JOIN sizes s ON pd.size_id = s.id
        WHERE pimg.name IS NOT NULL AND p.price > 0 
        GROUP BY p.id";
                
        $result = $this->query($sql);
        return $result;    
    }

    // outfit client likes ajax

    function getOutfitClientLikes($entity_list, $user_id = null) {
        $find_array = array(
            'contain' => array('Image'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.id' => $entity_list
            ),
            'joins' => array(
                array('table' => 'wishlists',
                    'alias' => 'Wishlist',
                    'type' => 'LEFT',
                    'conditions' => array(
                    'Wishlist.user_id' => $user_id,
                    'Wishlist.product_entity_id = Entity.id'
                    ),
                ),
            ),
            'fields' => array('Entity.*', 'Wishlist.*',));
        $entity = $this->find('all', $find_array);
        return $entity;
    }

    // outfit stylist likes ajax

    function getOutfitStylistLikes($entity_list, $user_id = null) {
        $find_array = array(
            'contain' => array('Image'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.id' => $entity_list
            ),
            'joins' => array(
                array('table' => 'wishlists',
                    'alias' => 'Wishlist',
                    'type' => 'LEFT',
                    'conditions' => array(
                    'Wishlist.user_id' => $user_id,
                    'Wishlist.product_entity_id = Entity.id'
                    ),
                ),
            ),
            'fields' => array('Entity.*', 'Wishlist.*',));
        $entity = $this->find('all', $find_array);
        //print_r($entity);
        return $entity;
    }
}
