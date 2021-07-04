<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Class for generating Google Shopping Product XML feed
*
*/
class CR_Google_Shopping_Prod_Feed {
	/**
	* @var string The path to the feed file
	*/
	private $file_path;
	private $chunks_file_path;
	private $include_variable;
	private $cron_options;
	private $default_limit;

	public function __construct( ) {
		$this->default_limit = apply_filters( 'cr_gs_product_feed_cron_limit', 200 );
		$prod_feed = get_option( 'ivole_product_feed_file_url', '' );
		$this->include_variable = get_option( 'ivole_product_feed_variations', 'no' );
		$this->cron_options = get_option( 'ivole_product_feed_cron', array(
			'started' => false,
			'offset' => 0,
			'limit'  => $this->default_limit,
		));

		$upload_url = wp_upload_dir();
		if( !$prod_feed ) {
			$prod_feed = '/cr/product_feed_' . uniqid() . '.xml';
		}
		$this->file_path = $upload_url['basedir'] . $prod_feed;
		$this->chunks_file_path = $upload_url['basedir'] . '/cr/product_feed_temp.xml';
	}

	public function start_cron() {
		$this->cron_options['started'] = true;
		$this->cron_options['offset'] = 0;
		$this->cron_options['limit'] = $this->default_limit;

		update_option('ivole_product_feed_cron', $this->cron_options);

		if ( file_exists( $this->chunks_file_path ) ) {
			@unlink( $this->chunks_file_path );
		}
	}

	public function finish_cron( $w_file ) {
		$this->cron_options['started'] = false;
		$this->cron_options['offset'] = 0;
		update_option( 'ivole_product_feed_cron', $this->cron_options );

		if( $w_file ) {
			file_put_contents( $this->chunks_file_path, "</feed>", FILE_APPEND );
			rename( $this->chunks_file_path, $this->file_path );
		}

		wp_clear_scheduled_hook( 'ivole_generate_prod_feed_chunk' );
	}

	public function generate() {

		if(!$this->is_enabled()){
			$this->deactivate();
			return;
		}

		$products = $this->get_product_data();

		// Exit if XML library is not available
		if( ! class_exists( 'XMLWriter' ) ) {
			$this->finish_cron( false );
			WC_Admin_Settings::add_error( __( 'Error: XMLWriter PHP extension could not be found. Please reach out to the hosting support to enable it.', 'customer-reviews-woocommerce' ) );
			return;
		}

		$xml_writer = new XMLWriter();
		//$xml_writer->openURI( $this->file_path );
		$xml_writer->openMemory();
		$xml_writer->setIndent( true );
		if( !$xml_writer ) {
			//no write access in the folder
			$this->finish_cron( false );
			return;
		}

		// Exit if there are no products
		if ( count( $products ) < 1 ) {
			unset( $xml_writer );
			if( $this->cron_options['offset'] > 0 ) {
				$this->finish_cron( true );
			} else {
				$this->finish_cron( false );
			}
			WC_Admin_Settings::add_error( __( 'Error: no products found for the XML Product Feed. Please check exclusion settings for products and product categories.', 'customer-reviews-woocommerce' ) );
			return;
		}

		if( $this->cron_options['offset'] == 0 ) {
			$xml_writer->startDocument( '1.0', 'UTF-8' );
			// <feed>
			$xml_writer->startElement( 'feed' );
			$xml_writer->startAttribute( 'xmlns' );
			$xml_writer->text( 'http://www.w3.org/2005/Atom' );
			$xml_writer->endAttribute();
			$xml_writer->startAttribute( 'xmlns:g' );
			$xml_writer->text( 'http://base.google.com/ns/1.0' );
			$xml_writer->endAttribute();
			// <title>
			$xml_writer->startElement( 'title' );
			$blog_name = get_option( 'ivole_shop_name', '' );
			$blog_name = empty( $blog_name ) ? get_option( 'blogname' ) : $blog_name;
			$xml_writer->text( $blog_name );
			$xml_writer->endElement();
			// <link>
			$xml_writer->startElement( 'link' );
			$xml_writer->startAttribute( 'rel' );
			$xml_writer->text( 'self' );
			$xml_writer->endAttribute();
			$xml_writer->startAttribute( 'href' );
			$xml_writer->text( Ivole_Email::get_blogurl() );
			$xml_writer->endAttribute();
			$xml_writer->endElement();
			// <updated>
			$xml_writer->startElement( 'updated' );
			$xml_writer->text( gmdate("Y-m-d\TH:i:s\Z") );
			$xml_writer->endElement();
			// <author>
			$xml_writer->startElement( 'author' );
			// <name>
			$xml_writer->startElement( 'name' );
			$xml_writer->text( 'Cusrev' );
			$xml_writer->endElement();
			$xml_writer->endElement();
		}

		// products
		foreach ( $products as $review ) {
			// <entry>
			$xml_writer->startElement( 'entry' );

			// <id>
			$xml_writer->startElement( 'g:id' );
			$xml_writer->text( $review->id );
			$xml_writer->endElement();

			// <title>
			$xml_writer->startElement( 'g:title' );
			$xml_writer->text( $review->title );
			$xml_writer->endElement();

			// <description>
			if( $review->description ) {
				$xml_writer->startElement( 'g:description' );
				$xml_writer->text( $review->description );
				$xml_writer->endElement();
			}

			// <link>
			$xml_writer->startElement( 'g:link' );
			$xml_writer->text( $review->link );
			$xml_writer->endElement();

			// <image_link>
			$xml_writer->startElement( 'g:image_link' );
			$xml_writer->text( $review->image );
			$xml_writer->endElement();

			// <additional_image_link>
			foreach ($review->gallery_images as $key => $value) {
				$xml_writer->startElement( 'g:additional_image_link' );
				$xml_writer->text( $value );
				$xml_writer->endElement();
			}

			// <availability>
			$xml_writer->startElement( 'g:availability' );
			$xml_writer->text( $review->availability );
			$xml_writer->endElement();

			// <price>
			$xml_writer->startElement( 'g:price' );
			$xml_writer->text( $review->price );
			$xml_writer->endElement();

			// <unit_​​pricing_​​measure>
			if( $review->unit_pricing_measure ) {
				$xml_writer->startElement( 'g:unit_pricing_measure' );
				$xml_writer->text( $review->unit_pricing_measure );
				$xml_writer->endElement();
			}

			// <unit_pricing_base_measure>
			if( $review->unit_pricing_base_measure ) {
				$xml_writer->startElement( 'g:unit_pricing_base_measure' );
				$xml_writer->text( $review->unit_pricing_base_measure );
				$xml_writer->endElement();
			}

			// <gtin>
			if( $review->gtin ) {
				$xml_writer->startElement( 'g:gtin' );
				$xml_writer->text( $review->gtin );
				$xml_writer->endElement();
			}

			// <mpn>
			if( $review->mpn ) {
				$xml_writer->startElement( 'g:mpn' );
				$xml_writer->text( $review->mpn );
				$xml_writer->endElement();
			}

			// <brand>
			if( $review->brand ) {
				$xml_writer->startElement( 'g:brand' );
				$xml_writer->text( $review->brand );
				$xml_writer->endElement();
			}

			// <identifier_exists>
			if( $review->identifier_exists ) {
				$xml_writer->startElement( 'g:identifier_exists' );
				$xml_writer->text( 'no' );
				$xml_writer->endElement();
			}

			// <product_type>
			if( $review->product_type ) {
				$xml_writer->startElement( 'g:product_type' );
				$xml_writer->text( $review->product_type );
				$xml_writer->endElement();
			}

			// <google_product_category>
			if( $review->google_product_category ) {
				$xml_writer->startElement( 'g:google_product_category' );
				$xml_writer->text( $review->google_product_category );
				$xml_writer->endElement();
			}

			// <item_group_id>
			if( $review->item_group_id ) {
				$xml_writer->startElement( 'g:item_group_id' );
				$xml_writer->text( $review->item_group_id );
				$xml_writer->endElement();
			}

			// <shipping_weight>
			if( $review->shipping_weight ) {
				$xml_writer->startElement( 'g:shipping_weight' );
				$xml_writer->text( $review->shipping_weight );
				$xml_writer->endElement();
			}

			// <shipping_length>
			if( $review->shipping_length ) {
				$xml_writer->startElement( 'g:shipping_length' );
				$xml_writer->text( $review->shipping_length );
				$xml_writer->endElement();
			}

			// <shipping_width>
			if( $review->shipping_width ) {
				$xml_writer->startElement( 'g:shipping_width' );
				$xml_writer->text( $review->shipping_width );
				$xml_writer->endElement();
			}

			// <shipping_height>
			if( $review->shipping_height ) {
				$xml_writer->startElement( 'g:shipping_height' );
				$xml_writer->text( $review->shipping_height );
				$xml_writer->endElement();
			}

			// <age_group>
			if( $review->age_group ) {
				$xml_writer->startElement( 'g:age_group' );
				$xml_writer->text( $review->age_group );
				$xml_writer->endElement();
			}

			// <color>
			if( $review->color ) {
				$xml_writer->startElement( 'g:color' );
				$xml_writer->text( $review->color );
				$xml_writer->endElement();
			}

			// <gender>
			if( $review->gender ) {
				$xml_writer->startElement( 'g:gender' );
				$xml_writer->text( $review->gender );
				$xml_writer->endElement();
			}

			$xml_writer->endElement(); // </entry>
		}

		if( false === file_put_contents( $this->chunks_file_path, $xml_writer->flush( true ), FILE_APPEND ) ) {
			//no write access to the file
			unset( $xml_writer );
			$this->finish_cron( false );
			return;
		}
		unset( $xml_writer );

		$this->reschedule_cron();
	}

	protected function reschedule_cron(){
		wp_clear_scheduled_hook( 'ivole_generate_prod_feed_chunk' );
		wp_schedule_single_event( time(), 'ivole_generate_prod_feed_chunk' );
	}

	/**
	* Fetches reviews to include in the feed.
	*
	* @since 3.47
	*
	* @return array
	*/
	protected function get_product_data() {
		$identifiers = get_option( 'ivole_product_feed_identifiers', array(
			'pid'   => '',
			'gtin'  => '',
			'mpn'   => '',
			'brand' => ''
		) );

		$attributes = get_option( 'ivole_product_feed_attributes', array(
			'age_group'		=> '',
			'color'			=> '',
			'gender'		=> '',
		) );

		$current_options = $this->cron_options;
		$current_options['offset'] = $this->cron_options['offset'] + $this->cron_options['limit'];
		update_option('ivole_product_feed_cron', $current_options);

		$exclude = get_option( 'ivole_excl_product_ids', array() );
		if( !is_array( $exclude ) ) {
			$exclude = array_filter( array_map( 'intval', explode( ',', trim( $exclude ) ) ) );
		}
		$product_status = apply_filters( 'cr_gs_product_feed_product_status', array( 'publish' ) );

		$products = wc_get_products( apply_filters( 'cr_gs_product_feed_query', array(
			'limit' => $this->cron_options['limit'],
			'offset' => $this->cron_options['offset'],
			'status' => $product_status,
			'exclude' => $exclude
		) ) );

		if( 'yes' === $this->include_variable ) {
			// remove variable products from the standard list of products
			$products = array_filter( $products, function( $product ) {
				if( $product->is_type( 'variable' ) ) {
					return false;
				} else {
					return true;
				}
			} );

			// get variations
			$variation_products = wc_get_products( array(
				'type' => 'variation',
				'limit' => $this->cron_options['limit'],
				'offset' => $this->cron_options['offset'],
				'status' => $product_status,
				'exclude' => $exclude
			) );

			// exclude variations linked to products that are excluded
			$variation_products = array_filter( $variation_products, function( $variation_product ) use( $product_status, $exclude ) {
				$parent = wc_get_product( $variation_product->get_parent_id() );
				if( $parent ) {
					if( !in_array( $parent->get_status(), $product_status ) || in_array( $parent->get_id(), $exclude ) ) {
						return false;
					}
				}
				return true;
			} );

			$products = array_merge( $products, $variation_products );
		}

		$products = array_map( function( $product ) use( $identifiers, $attributes ) {
			/**
			* @var WC_Product $product
			*/
			$_product = new stdClass;

			$_product->parent_variable = null;
			if( $product->is_type( 'variation' ) ) {
				$_product->parent_variable = wc_get_product( $product->get_parent_id() );
			}

			$_product->woo_id = $product->get_id();
			if( is_array( $identifiers ) && isset( $identifiers['pid'] ) ) {
				$_product->id = CR_Google_Shopping_Prod_Feed::get_field( $identifiers['pid'], $product );
				if( ! $_product->id ) {
					$_product->id = $product->get_id();
				}
			}
			$_product->title = $product->get_title();
			if( $_product->parent_variable ) {
				$_product->title = $product->get_name();
			}
			$_product->title = apply_filters( 'cr_gs_product_feed_title', $_product->title, $product );
			$_product->description = wp_strip_all_tags( $product->get_short_description() );
			if( !$_product->description ) {
				// if the product does not have a short description, try using  a full description
				$_product->description = wp_strip_all_tags( $product->get_description() );
			}
			if( $_product->parent_variable && !$_product->description ) {
				// if the variation doesn't have a description, try to use the description from the parent
				$_product->description = wp_strip_all_tags( $_product->parent_variable->get_short_description() );
				if( !$_product->description ) {
					// if the parent product does not have a short description, try using  a full description
					$_product->description = wp_strip_all_tags( $_product->parent_variable->get_description() );
				}
			}
			$_product->description = apply_filters( 'cr_gs_product_feed_description', $_product->description, $product );
			$_product->link = $product->get_permalink();
			$_product->image = wp_get_attachment_image_url( $product->get_image_id(), 'full', false );
			$gallery_images = $product->get_gallery_image_ids();
			if( $_product->parent_variable && 0 === count( $gallery_images ) ) {
				$gallery_images = $_product->parent_variable->get_gallery_image_ids();
			}
			$_product->gallery_images = array();
			foreach ($gallery_images as $key => $value) {
				$_product->gallery_images[] = wp_get_attachment_image_url( $value, 'full', false );
				// Google allows up to 10 images
				if( 10 === count( $_product->gallery_images ) ) {
					break;
				}
			}
			$_product->availability = $product->is_in_stock() ? 'in stock' : 'out of stock';
			$_product->price = $product->get_price() . ' ' . get_woocommerce_currency();

			$_product->unit_pricing_measure = '';
			$unit_product = CR_Google_Shopping_Prod_Feed::get_field( 'meta__unit_product', $product );
			if( $_product->parent_variable && ! $unit_product ) {
				$unit_product = CR_Google_Shopping_Prod_Feed::get_field( 'meta__unit_product', $_product->parent_variable );
			}
			$unit = CR_Google_Shopping_Prod_Feed::get_field( 'meta__unit', $product );
			if( $_product->parent_variable && ! $unit ) {
				$unit = CR_Google_Shopping_Prod_Feed::get_field( 'meta__unit', $_product->parent_variable );
			}
			if( !empty( $unit_product ) ) $_product->unit_pricing_measure = $unit_product . ' ' . $unit;

			$_product->unit_pricing_base_measure = '';
			$unit_base = CR_Google_Shopping_Prod_Feed::get_field( 'meta__unit_base', $product );
			if( $_product->parent_variable && ! $unit_base ) {
				$unit_base = CR_Google_Shopping_Prod_Feed::get_field( 'meta__unit_base', $_product->parent_variable );
			}
			if( !empty( $unit_base ) ) $_product->unit_pricing_base_measure = $unit_base . ' ' . $unit;

			$_product->gtin = '';
			if( is_array( $identifiers ) && isset( $identifiers['gtin'] ) ) {
				$_product->gtin = CR_Google_Shopping_Prod_Feed::get_field( $identifiers['gtin'], $product );
			}
			$_product->mpn = '';
			if( is_array( $identifiers ) && isset( $identifiers['mpn'] ) ) {
				$_product->mpn = CR_Google_Shopping_Prod_Feed::get_field( $identifiers['mpn'], $product );
			}
			$_product->brand = '';
			if( is_array( $identifiers ) && isset( $identifiers['brand'] ) ) {
				$_product->brand = CR_Google_Shopping_Prod_Feed::get_field( $identifiers['brand'], $product );
				if( !$_product->brand ) {
					$_product->brand = trim( get_option( 'ivole_google_brand_static', '' ) );
				}
			}
			//attributes
			$_product->age_group = '';
			if( is_array( $attributes ) && isset( $attributes['age_group'] ) ) {
				$_product->age_group = CR_Google_Shopping_Prod_Feed::get_field( $attributes['age_group'], $product );
			}
			$_product->color = '';
			if( is_array( $attributes ) && isset( $attributes['color'] ) ) {
				$_product->color = CR_Google_Shopping_Prod_Feed::get_field( $attributes['color'], $product );
			}
			$_product->gender = '';
			if( is_array( $attributes ) && isset( $attributes['gender'] ) ) {
				$_product->gender = CR_Google_Shopping_Prod_Feed::get_field( $attributes['gender'], $product );
			}
			$_product->identifier_exists = CR_Google_Shopping_Prod_Feed::get_field( 'meta__cr_identifier_exists', $product );
			$_product->product_type = '';
			$_product->google_product_category = '';
			$category_ids = $product->get_category_ids();
			if( $_product->parent_variable && is_array( $category_ids ) && 0 === count( $category_ids ) ) {
				$category_ids = $_product->parent_variable->get_category_ids();
			}
			if( is_array( $category_ids ) ) {
				$categories_count = count( $category_ids );
				if( $categories_count > 0 ) {
					$args_cat = array(
						'taxonomy' => 'product_cat',
						'hide_empty' => false,
						'term_taxonomy_id' => $category_ids
					);
					$categories = get_categories( $args_cat );
					usort( $categories, function( $a, $b ) {
						return $a->term_id > $b->term_id;
					} );
					$categories_mapping = get_option( 'ivole_product_feed_categories', array() );
					$max_cat_path_length = 0;
					foreach ( $categories as $e ) {
						$category_path = $this->get_category_path( $e, $categories_mapping );
						if( $category_path['length'] > $max_cat_path_length ) {
							$_product->product_type = $category_path['path'];
							if( $category_path['google'] ) {
								$_product->google_product_category = $category_path['google'];
							}
						}
					}
				}
			}
			$_product->item_group_id = '';
			if( $_product->parent_variable ) {
				if( is_array( $identifiers ) && isset( $identifiers['pid'] ) ) {
					$_product->item_group_id = CR_Google_Shopping_Prod_Feed::get_field( $identifiers['pid'], $_product->parent_variable );
					if( ! $_product->item_group_id ) {
						$_product->item_group_id = $_product->parent_variable->get_id();
					}
				}
			}

			$_product->shipping_weight = '';
			$weight = $product->get_weight();
			if( !empty( $weight ) ) {
				$_product->shipping_weight = $weight . ' ' . strtolower( get_option( 'woocommerce_weight_unit' ) );
			}

			$_product->shipping_length = '';
			$length = $product->get_length();
			if( !empty( $length ) ) {
				$_product->shipping_length = $length . ' ' . strtolower( get_option( 'woocommerce_dimension_unit' ) );
			}

			$_product->shipping_width = '';
			$width = $product->get_width();
			if( !empty( $width ) ) {
				$_product->shipping_width = $width . ' ' . strtolower( get_option( 'woocommerce_dimension_unit' ) );
			}

			$_product->shipping_height = '';
			$height = $product->get_height();
			if( !empty( $height ) ) {
				$_product->shipping_height = $height . ' ' . strtolower( get_option( 'woocommerce_dimension_unit' ) );
			}

			return $_product;
		}, $products );

		// filter products from excluded categories
		$categories_exclude = get_option( 'ivole_product_feed_categories_exclude', array() );
		$products = array_filter( $products, function( $product ) use( $categories_exclude ) {
			$include = true;
			$category_ids = get_the_terms( $product->woo_id, 'product_cat' );
			if( $product->parent_variable && !$category_ids ) {
				$category_ids = get_the_terms( $product->parent_variable->get_id(), 'product_cat' );
			}
			if( $category_ids ) {
				foreach ( $category_ids as $category_id ) {
					if( in_array( $category_id->term_id, $categories_exclude ) ) {
						$include = false;
						break;
					}
				}
			}
			return $include;
		} );

		return $products;
	}

	protected function get_category_path( $category, $categories_mapping ) {
		$length = 1;
		$path = $category->name;
		$google = '';
		if( isset( $categories_mapping[ $category->term_id ] )) {
			$google = $categories_mapping[ $category->term_id ];
		}
		for( $i=0; $i<1000; $i++ ) {
			if( $category->parent > 0 ) {
				$category = get_term( $category->parent, 'product_cat', OBJECT, 'raw' );
				$length++;
				$path = $category->name . ' > ' . $path;
			} else {
				break;
			}
		}
		return array( 'length' => $length, 'path' => $path, 'google' => $google );
	}

	/**
	* Returns true if Google Shopping Reviews XML feed is enabled
	*
	* @since 3.47
	*
	* @return bool
	*/
	public function is_enabled() {
		return ( get_option( 'ivole_product_feed', 'no' ) === 'yes' );
	}

	/**
	* Schedules the job to generate the feed
	*
	* @since 3.47
	*/
	public function activate() {
		// Check to ensure that the wp-content/uploads/cr directory exists
		if ( ! is_dir( IVOLE_CONTENT_DIR ) ) {
			@mkdir( IVOLE_CONTENT_DIR, 0755 );
		}

		$this->deactivate();

		do_action( 'ivole_generate_prod_feed' );

		if ( ! wp_next_scheduled( 'ivole_generate_prod_feed' ) && $this->is_enabled()) {
			wp_schedule_event( time() + DAY_IN_SECONDS, 'daily', 'ivole_generate_prod_feed' );
		}
	}

	/**
	* Stops the generation of the feed and deletes the feed file
	*
	* @since 3.47
	*/
	public function deactivate() {
		if ( wp_next_scheduled( 'ivole_generate_prod_feed_chunk' ) ) wp_clear_scheduled_hook( 'ivole_generate_prod_feed_chunk' );
		if ( wp_next_scheduled( 'ivole_generate_prod_feed' ) ) wp_clear_scheduled_hook( 'ivole_generate_prod_feed' );

		$this->cron_options['offset'] = 0;
		$this->cron_options['started'] = false;
		update_option('ivole_product_feed_cron', $this->cron_options);

		if ( file_exists( $this->file_path ) ) {
			@unlink( $this->file_path );
		}
		if ( file_exists( $this->chunks_file_path ) ) {
			@unlink( $this->chunks_file_path );
		}
	}

	/**
	* Returns the value of a field
	*
	*/
	public static function get_field( $field, $product ) {
		$field_type = strstr( $field, '_', true );
		$field_key = substr( strstr( $field, '_' ), 1 );
		$temp = '';
		$value = '';
		switch ( $field_type ) {
			case 'product':
			$func = 'get_' . $field_key;
			$temp = $product->$func();
			if( $temp ) {
				$value = $temp;
			}
			break;
			case 'attribute':
			$temp = $product->get_attribute( $field_key );
			if( $temp ) {
				$value = $temp;
			}
			break;
			case 'meta':
			$temp = $product->get_meta( $field_key, true );
			if( $temp ) {
				$value = $temp;
			}
			break;
			case 'tags':
			$temp = $product->get_tag_ids();
			if( $temp && is_array( $temp ) && count( $temp ) > 0 ) {
				$tag_name = get_term( $temp[0], 'product_tag' );
				if( $tag_name && $tag_name->name ) {
					$value = $tag_name->name;
				}
			}
			break;
			case 'terms':
			$temp = get_the_terms( $product->get_id(), $field_key );
			if( $temp && !is_wp_error( $temp ) && is_array( $temp ) ) {
				if( 0 < count( $temp ) ) {
					$value = $temp[0]->name;
				}
			}
			break;
		}

		return strval( $value );
	}

}
