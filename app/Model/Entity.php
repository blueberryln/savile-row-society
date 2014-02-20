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
        //Check if product stock is available
        //$sql = "SELECT pe.id, pc.category_id 
//                FROM products_entities pe
//                INNER JOIN products_categories pc ON pe.product_id = pc.product_id
//                INNER JOIN categories cat ON pc.category_id = cat.id 
//                INNER JOIN products_details pd ON pd.product_entity_id = pe.id 
//                WHERE pe.show = 1 AND cat.parent_id IS NULL AND pd.show = 1 AND pd.stock > (SELECT COALESCE(SUM(Item.quantity),0) AS usedstock FROM carts_items Item INNER JOIN carts Cart ON Item.cart_id = Cart.id WHERE Cart.updated > (NOW() - INTERVAL 1 DAY) AND Item.product_entity_id = pe.id AND pd.size_id = Item.size_id) 
//                GROUP BY pc.category_id";
                
        //$sql = "SELECT pe.id, pc.category_id 
//                FROM products_entities pe
//                INNER JOIN products_categories pc ON pe.product_id = pc.product_id
//                INNER JOIN categories cat ON pc.category_id = cat.id 
//                WHERE pe.show = 1     
//                GROUP BY pc.category_id";
        
        
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
                //'Entity.is_featured' => true,
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
}
