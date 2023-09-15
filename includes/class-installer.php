<?php
namespace Arraytics;

/**
 * Arraytics installer class
 * 
 * @package Arraytics
 */ 
class Installer {

    /**
     * call setup
     * 
     * @return void
     */ 
	public function create_setup() {
        error_log('create setup');
        $this->create_table();
		$this->add_roles();
		$this->setup_pages();
	}

    /**
     * Create Table
     * 
     * @return void
     */
    public function create_table() {
        error_log('create table');

        global $wpdb;

        $collate = '';

        if ( $wpdb->has_cap( 'collation' ) ) {
            if ( !empty( $wpdb->charset ) ) {
                $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
            }

            if ( !empty( $wpdb->collate ) ) {
                $collate .= " COLLATE $wpdb->collate";
            }
        }

        $table_schema = 
            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}arraytics_entries` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `amount` int(10) unsigned NOT NULL,
                `buyer` varchar(255) NOT NULL,
                `receipt_id` varchar(20) NOT NULL,
                `items` varchar(255) NOT NULL,
                `buyer_email` varchar(50) NOT NULL,
                `buyer_ip` varchar(20) DEFAULT NULL,
                `note` text NOT NULL, 
                `city` varchar(20) NOT NULL,
                `phone` varchar(20) NOT NULL,
                `hash_key` varchar(255) DEFAULT NULL,
                `entry_at` date('YYYY-MM-DD') DEFAULT NULL,
                `entry_by` int(10) NOT NULL,
                `created_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) $collate;"; 
        
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        
        // foreach ( $table_schema as $table ) {
            dbDelta( $table_schema );
        // }
        // dbDelta( $table_schema );
    }

    /**
     * add User Roles and Capabilites
     * 
     * @return void
     */ 
	public function add_roles() {
        global $wp_roles;

        if ( class_exists( 'WP_Roles' ) && ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles(); // @codingStandardsIgnoreLine
        }

        add_role(
            'seller', __( 'Seller', 'multistorex' ), [
				'read'                      => true,
				'publish_posts'             => true,
				'edit_posts'                => true,
				'delete_published_posts'    => true,
				'edit_published_posts'      => true,
				'delete_posts'              => true,
				'manage_categories'         => true,
				'moderate_comments'         => true,
				'upload_files'              => true,
				'edit_shop_orders'          => true,
				'edit_product'              => true,
				'read_product'              => true,
				'delete_product'            => true,
				'edit_products'             => true,
				'publish_products'          => true,
				'read_private_products'     => true,
				'delete_products'           => true,
				'delete_private_products'   => true,
				'delete_published_products' => true,
				'edit_private_products'     => true,
				'edit_published_products'   => true,
				'manage_product_terms'      => true,
				'delete_product_terms'      => true,
				'assign_product_terms'      => true,
				'seller'                  	=> true,
			]
        );

        $capabilities = [];

        $wp_roles->add_cap( 'shop_manager', 'seller' );
        $wp_roles->add_cap( 'administrator', 'seller' );

        foreach ( $capabilities as $key => $capability ) {
            $wp_roles->add_cap( 'seller', $capability );
            $wp_roles->add_cap( 'administrator', $capability );
            $wp_roles->add_cap( 'shop_manager', $capability );
        }
    }

    /**
     * setup pages
     * 
     * @return void
     */ 
    public function setup_pages() {
        $meta_key = '_wp_page_template';

        // return if pages were created before
        $page_created = get_option( 'multistorex_pages_created', false );

        if ( $page_created ) {
            return;
        }

        $pages = [
            [
                'post_title' => __( 'Arraytics Dashboard', 'gurux' ),
                'slug'       => 'dashboard',
                'page_id'    => 'dashboard',
                'content'    => '[arraytics-form]',
            ],
            [
                'post_title' => __( 'Arraytics Reports', 'gurux' ),
                'slug'       => 'report',
                'page_id'    => 'report',
                'content'    => '[arraytics-report]',
            ]
        ];

        $gurux_page_settings = [];

        if ( $pages ) {
            foreach ( $pages as $page ) {
                $page_id = $this->create_page( $page );

                if ( $page_id ) {
                    $gurux_page_settings[ $page['page_id'] ] = $page_id;

                    if ( isset( $page['child'] ) && count( $page['child'] ) > 0 ) {
                        foreach ( $page['child'] as $child_page ) {
                            $child_page_id = $this->create_page( $child_page );

                            if ( $child_page_id ) {
                                $arraytics_page_settings[ $child_page['page_id'] ] = $child_page_id;

                                wp_update_post(
                                    [
										'ID'          => $child_page_id,
										'post_parent' => $page_id,
									]
                                );
                            }
                        }
                    }
                }
            }
        }

        update_option( 'arraytics_pages', $arraytics_page_settings );
        update_option( 'arraytics_pages_created', true );
    }

    /**
     * enable woocommerce registration
     * 
     * @return void
     */ 
    public function woocommerce_settings() {
    	update_option( 'woocommerce_enable_myaccount_registration', 'yes' );
    }

    /**
     * create pages
     * 
     * @return boolean
     */ 
    public function create_page( $page ) {
        $meta_key = '_wp_page_template';
        $page_obj = get_page_by_path( $page['post_title'] );

        if ( ! $page_obj ) {
            $page_id = wp_insert_post(
                [
					'post_title'     => $page['post_title'],
					'post_name'      => $page['slug'],
					'post_content'   => $page['content'],
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'comment_status' => 'closed',
				]
            );

            if ( $page_id && ! is_wp_error( $page_id ) ) {
                if ( isset( $page['template'] ) ) {
                    update_post_meta( $page_id, $meta_key, $page['template'] );
                }

                return $page_id;
            }
        }

        return false;
    }
}