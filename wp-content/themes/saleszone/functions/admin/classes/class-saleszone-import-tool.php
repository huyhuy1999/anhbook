<?php
/**
 * Created by PhpStorm.
 * User: kir
 * Date: 23.01.18
 * Time: 17:34
 */


class SaleszoneImportTool{

    /**
     *
     * Stores inserted posts IDs
     *
     * @var array
     */
    private $insertedPosts = array();

	/**
	 * @var
	 */
    private $importStatus;

	/**
	 * @var int
	 */
    private $currentPost = 0;

	/**
	 * @var array
	 */
    private $importChecklist = array();

    /**
     * @var
     */
    private $imagesUrl;


	/**
	 * Main import function
	 *
	 * @param string $link
	 */
    public function run($link = ''){

        $this->importChecklist = array(
            'cleanDB',
            'clearTransients',
            'addWCAttributes',
            'importTerms',
            'insertPost',
            'importOptions',
            'importBundles',
            'importBundlesProducts',
	        'updateWPMLTranslations',
	        'clearTransients',
            'deleteTempOptions'

        );


        if(!is_plugin_active('premmerce-product-bundles/premmerce-product-bundles.php')){
        	$this->removeChecklistItem('importBundles');
            $this->removeChecklistItem('importBundlesProducts');
        }

        if(!is_plugin_active('woocommerce/woocommerce.php')){
           $this->removeChecklistItem('addWCAttributes');
        }


        if(! defined('WPML_PLUGIN_FILE')){
	        $this->removeChecklistItem('updateWPMLTranslations');
        }

	    if($link){//First run of current import

            $this->deleteTempOptions();

            $json      = wp_remote_retrieve_body(wp_remote_get($link));

            $dataArray = (array)json_decode($json, true);

            update_option('premmerceImportContent', $dataArray);
            $parsed          = parse_url($link);
            $this->imagesUrl = $parsed['scheme'] . '://' . $parsed['host'] . '/wp-content/uploads/';
            update_option('premmerceImagesUrl', $this->imagesUrl);
        }else{

            $dataArray           = get_option('premmerceImportContent');
            $this->imagesUrl     = get_option('premmerceImagesUrl');
            $this->insertedPosts = get_option('premmerceInsertedPosts');
        }

        if(!$dataArray || !$this->imagesUrl){
            die('nothing to import');
        }


        $importChecklist = get_option('premmerceImportChecklist') ? get_option('premmerceImportChecklist') : $this->importChecklist;

        $this->import($dataArray, $importChecklist);
    }

	/**
	 * Return translated status text
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
    private function getStatusText($key){

        $translations = array(
            'cleanDB'               => __('clean DB', 'saleszone'),
            'clearTransients'       => __('clean transients', 'saleszone'),
            'addWCAttributes'       => __('Import attributes', 'saleszone'),
            'insertPost'            => __('Import posts', 'saleszone'),
            'importTerms'           => __('Import terms', 'saleszone'),
            'importOptions'         => __('Import options', 'saleszone'),
            'importBundles'         => __('Import bundles', 'saleszone'),
            'importBundlesProducts' => __('Import bundles products', 'saleszone'),
	        'updateWPMLTranslations'=> __('Update WPML translations', 'saleszone'),
            'deleteTempOptions'     => __('Import end', 'saleszone'),
        );

        return $translations[ $key ];

    }

    /**
     * Update option temporary storing current import progress
     *
     * @param $newChecklistData
     * @param string $additionalCheck
     */
    private function updateChecklistOption($newChecklistData, $additionalCheck = ''){

        if($additionalCheck === 'posts'){
            $postsToUpdate = get_option('premmerceImportPostsChecklist');

            $this->currentPost = count($postsToUpdate);

            $this->importStatus = 'insertPost';

            array_shift($postsToUpdate);

            if($postsToUpdate){
                update_option('premmerceImportPostsChecklist', $postsToUpdate);
            }else{
                delete_option('premmerceImportPostsChecklist');
                $this->importStatus = 'insertPost';

                array_shift($newChecklistData);
	            update_option( 'premmerceImportChecklist', $newChecklistData );
            }
        }else{
            array_shift($newChecklistData);
	        if($newChecklistData) {
		        update_option( 'premmerceImportChecklist', $newChecklistData );
	        }
        }

    }

    /**
     *
     * Manages import process.
     *
     * @param array $contentArray
     * @param array $checklist
     *
     */
    public function import(array $contentArray, $checklist){
        $action = reset($checklist);

        switch($action){
            case 'cleanDB':
                $this->cleanDB();
                $this->importStatus = 'cleanDB';
                break;

            case 'clearTransients':
                $this->clearTransients();
                $this->importStatus = 'clearTransients';
                break;

            case 'addWCAttributes':
                $this->insertWCAttributes($contentArray['woocommerce_attributes_taxonomies']);
                $this->importStatus = 'addWCAttributes';
                break;

            case 'importTerms':
                $this->importTerms($contentArray['terms']);
                $this->importStatus = 'importTerms';
                break;

            case 'insertPost':
                $postsChecklist = get_option('premmerceImportPostsChecklist') ? get_option('premmerceImportPostsChecklist') : array_keys($contentArray['posts']);
                update_option('premmerceImportPostsChecklist', $postsChecklist);
                $nextPost = reset($postsChecklist);
                $this->insertPost($contentArray['posts'][ $nextPost ]);
                break;

            case 'importOptions':
                $this->importOptions($contentArray['options']);
                $this->importStatus = 'importOptions';
                break;

            case 'importBundles':
                $this->importBundles($contentArray['bundles']);
                $this->importStatus = 'importBundles';
                break;

            case 'importBundlesProducts':
                $this->importBundlesProducts($contentArray['bundles_products']);
                $this->importStatus = 'importBundlesProducts';
                break;
	        case 'updateWPMLTranslations':
	        	$this->updateWPMLTranslations();
	        	$this->importStatus = 'updateWPMLTranslations';
	        	break;

            case 'deleteTempOptions':
                $this->deleteTempOptions();
                $this->importStatus = 'deleteTempOptions';
                break;

            default:
                die(esc_html($action));
        }


        $toCheck = '';

        if('insertPost' === $action){
            $this->importStatus =
            $toCheck = 'posts';
        }

        $this->updateChecklistOption($checklist, $toCheck);

        $this->sendStatus($this->importStatus);

    }

	/**
	 * Send current status info to frontend
	 *
	 * @param string $action
	 * @param string $status
	 */
    private function sendStatus($action = '', $status = 'done'){

        $premmerceImportChecklist = get_option('premmerceImportChecklist');

        $nextStatus = $premmerceImportChecklist[0] ? $premmerceImportChecklist[0] : 'none';

        if($this->currentPost != 0){
            $status = $this->currentPost;
        }

        wp_send_json(array(
            'stage'              => $action,
            'action'             => $this->getStatusText($action),
            'status'             => $status,
            'nextStatus'         => $this->getStatusText($nextStatus),
            'stateBlockSelector' => $nextStatus
        ));
    }

    /**
     * Truncate some tables in wordpress DB. Full tables list see below.
     *
     */
    private function cleanDB(){
        global $wpdb;


        $tablesToTruncate = array(
            'commentmeta',
            'comments',
            'postmeta',
            'posts',
            'term_relationships',
            'term_taxonomy',
            'termmeta',
            'terms',
            'woocommerce_attribute_taxonomies',
            'saleszone_bundles',
            'saleszone_bundles_products',
        );

        foreach($tablesToTruncate as $table){

            $tableName = $wpdb->prefix . $table;

            if($this->tableExists($tableName)){
                $query = 'TRUNCATE TABLE ' . $tableName;
                $wpdb->query($query);
            }
        }
    }

    /**
     * Check if table exists in DB
     *
     * @param $tableFullName
     *
     * @return bool
     */
    private function tableExists($tableFullName){
        global $wpdb;

        if($wpdb->get_var("SHOW TABLES LIKE '{$tableFullName}'") === $tableFullName){
            return true;
        }

        return false;
    }

    /**
     * Import Premmerce Bundles
     *
     * @param $bundles
     *
     */
    private function importBundles($bundles){
        global $wpdb;

        $bundlesTable = $wpdb->prefix . 'saleszone_bundles';

        if(!$this->tableExists($bundlesTable)){
            return;
        }

        foreach($bundles as $bundle){
            $mainProductID = $bundle['main_product_id'];

            $query = 'INSERT INTO ' . $bundlesTable . ' (main_product_id, active) VALUES (%d, %d)';
            $query = $wpdb->prepare($query, $mainProductID, $bundle['active']);
            $wpdb->query($query);
        }
    }


    /**
     * Import Premmerce Bundles.
     *
     * @param $bundlesProducts
     */
    private function importBundlesProducts($bundlesProducts){
        global $wpdb;

        $bundlesProductsTable = $wpdb->prefix . 'saleszone_bundles_products';

        if(!$this->tableExists($bundlesProductsTable)){
            return;
        }

        foreach($bundlesProducts as $element){
            $bundleID  = $element['bundle_id'];
            $productID = $element['product_id'];
            $query     = 'INSERT INTO ' . $bundlesProductsTable . ' (bundle_id, product_id, discount) VALUES (%d, %d, %d)';
            $query     = $wpdb->prepare($query, $bundleID, $productID, $element['discount']);
            $wpdb->query($query);
        }
    }


    /**
     * Import terms with original IDs.
     *
     * @param $terms
     *
     * @return void
     */
    private function importTerms($terms){

        global $currentTermID;

        add_filter('wp_insert_term_data', array($this, 'wp_insert_term_data_filter'));

        foreach($terms as $singleTerm){

            $currentTermID = $singleTerm['term_id'];

            $this->insertTermWithMeta($singleTerm);

        }

        foreach($terms as $term){
            if($term['parent'] > 0){

                wp_update_term($term['term_id'], $term['taxonomy'], array('parent' => $term['parent']));
            }
        }

    }

    public function wp_insert_term_data_filter($data){
        global $currentTermID;
        $data['term_id'] = $currentTermID;

        return $data;
    }
    /**
     *
     * Insert term with it's metadata.
     *
     * @param $term
     *
     * @return int|false
     *
     */
    private function  insertTermWithMeta($term){

        $termTaxonomy = $term['taxonomy'];


        if(taxonomy_exists($termTaxonomy)){
            $termName = $term['name'];

            //Insert term with meta if not exists
            if($termID = term_exists($termName, $term['taxonomy'])){
                return $termID;
            }else{
                $termArgs = array(
                    'description' => $term['description'] ? $term['description'] : '',
                    'slug'        => $term['slug'] ? $term['slug'] : '',
                );

                $insertTermResult = wp_insert_term($termName, $termTaxonomy, $termArgs);

                if(is_wp_error($insertTermResult)){

                    return false;
                }


                if(isset($term['meta'])){
                    foreach($term['meta'] as $metaKey => $metaValue){
                        if(is_array($metaValue)){
                            if(count($metaValue) < 2){
                                $metaValue = $metaValue[0];
                            }
                        }
                        add_term_meta($insertTermResult['term_id'], $metaKey, maybe_unserialize($metaValue));
                    }
                }

            }

            return $termID;
        }

    }


    /**
     *
     * Insert a post and it's meta.
     *
     * @param array $postToInsert
     *
     * @return int|false
     */
    private function insertPost($postToInsert){


        $meta                                  = $postToInsert['meta'];
        $terms                                 = $postToInsert['terms'];
        $postToInsert['import_id']             = $postToInsert['ID'];
        $postToInsert['post_content_filtered'] = $postToInsert['post_content'];

        unset(
            $postToInsert['post_modified_gmt'],
            $postToInsert['post_modified'],
            $postToInsert['terms'],
            $postToInsert['meta'],
            $postToInsert['guid'],
            $postToInsert['ID'],
            $postToInsert['content']
        );

        if('attachment' === $postToInsert['post_type']){
            $insertedPostID = $this->insertAttachment($postToInsert, $meta);
            if(!$insertedPostID){
                return false;
            }
        }else{

            remove_all_actions('save_post');

            $insertedPostID = wp_insert_post($postToInsert, true);

            if($insertedPostID instanceof WP_Error){
                return false;
            }else{
                $this->insertedPosts[] = $insertedPostID;
            }

            //Insert meta
            foreach($meta as $metaKey => $metaValue){

                foreach($metaValue as $item){
                    add_post_meta($insertedPostID, $metaKey, maybe_unserialize($item));
                }
            }

        }

        $byTax = array();
        foreach($terms as $id){
	        $term = get_term( $id );

            if(! $term || is_wp_error($term)){
            	continue;
            }

            $byTax[ $term->taxonomy ][] = $id;

        }

        foreach($byTax as $tax => $byTax){

            wp_set_post_terms($insertedPostID, $byTax, $tax);
        }

        update_option('premmerceInsertedPosts', $this->insertedPosts);

        return $insertedPostID;
    }


    /**
     * Insert post of type 'attachment', create thumbnails, generate and update it's metadata. Returns inserted post ID.
     *
     * @param array $attachment
     *
     * @return int|false
     *
     */
    private function insertAttachment(array $attachment, $meta){


        $fileName = $this->downloadImage($meta['_wp_attached_file'][0]);


        if($fileName){

            $insertedPostID = wp_insert_attachment($attachment, $fileName, 0, true);

            if(is_wp_error($insertedPostID)){
                return false;
            }
            $insertedPostMetadata = wp_generate_attachment_metadata($insertedPostID, $fileName);

            wp_update_attachment_metadata($insertedPostID, $insertedPostMetadata);

            return $insertedPostID;
        }

    }


    /**
     * Add Woocommerce attributes.
     *
     * @param $attributes
     *
     * @return bool
     *
     */
	private function insertWCAttributes($attributes){
		global $wpdb;

		$values = array();

		foreach($attributes as $attribute){
				$values[] =  $wpdb->prepare("(%d, %s, %s, %s, %s, %d )", $attribute) ;
		}

		$valuesString = implode(',', $values);

		$woocommerceAttributesTable = $wpdb->prefix . 'woocommerce_attribute_taxonomies';
		$columnsList = 'attribute_id, attribute_name, attribute_label, attribute_type, attribute_orderby, attribute_public';
		$insertAttributesQuery = "INSERT INTO $woocommerceAttributesTable ($columnsList) VALUES $valuesString";
		$wpdb->query($insertAttributesQuery);

		wp_schedule_single_event( time(), 'woocommerce_flush_rewrite_rules' );
		delete_transient( 'wc_attribute_taxonomies' );
	}



    /**
     * Import options and theme mods.
     *
     * @param $options
     *
     */
    private function importOptions($options){

        foreach($options as $optionName => $optionValue){


            $optionName = ('theme_mods' !== $optionName)? $optionName : 'theme_mods_' . get_option('stylesheet');

            update_option($optionName, $optionValue);
        }
    }

	/**
	 * Set WPML translations for imported posts.
	 * Does the same as Set language information button on WPML troubleshooting page.
	 */
    private function updateWPMLTranslations(){
	    global $iclTranslationManagement;

	    if($iclTranslationManagement){
		    $iclTranslationManagement->add_missing_language_information();
	    }
    }

    /**
     * Transliterate string
     *
     * @ref https://htmlweb.ru/php/example/translit.php
     *
     *
     * @param $string
     *
     * @return string
     *
     */
    private function cyr2Translit($string){
        $converter = array(
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '\'',
            'ы' => 'y',
            'ъ' => '\'',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',

            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'Y',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Sch',
            'Ь' => '\'',
            'Ы' => 'Y',
            'Ъ' => '\'',
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',
        );

        return strtr($string, $converter);
    }

    /**
     * basename() replacement for multibyte encodings
     *
     * @see https://stackoverflow.com/questions/4451664/make-php-pathinfo-return-the-correct-filename-if-the-filename-is-utf-8
     *
     * @param $path
     *
     * @return string
     */
    private function mbBasename($path){
        $separator = " qq ";
        $path      = preg_replace("/[^ ]/u", $separator . "\$0" . $separator, $path);
        $base      = basename($path);
        $base      = str_replace($separator, "", $base);

        return $base;
    }

	/**
	 * Get taxonomy slug by term id directly from database
	 *
	 * @param $termID
	 *
	 * @return string|null
	 */
	private function getTermTaxonomy($termID){
		global $wpdb;
		return $wpdb->get_var($wpdb->prepare("SELECT taxonomy FROM {$wpdb->prefix}term_taxonomy WHERE term_id = %d", $termID));
	}

	/**
	 *  Disable import stage
	 *
	 * @param $item
	 */
	private function removeChecklistItem($item){
		$itemKey = array_search($item, $this->importChecklist);
		if(false !== $itemKey){
			array_splice($this->importChecklist, $itemKey, 1);
		}
	}


	/**
     * Get image from server and transliterate filename.
     *
     *
     * @param $filePathLastPart
     *
     * @return string|null
     */
    private function downloadImage($filePathLastPart){

        if(!$filePathLastPart){
            return null;
        }

        $filePathRemoteFull = $this->imagesUrl . $filePathLastPart;

        $cleanFilename = $this->mbBasename($filePathLastPart);

        $fileNameTranslit = $this->cyr2Translit($cleanFilename);

        $dir = wp_upload_dir();

        $fileNameWithPath = $dir['path'] . '/' . $fileNameTranslit;


        if(!file_exists($fileNameWithPath)){

            $tmpFile = download_url($filePathRemoteFull);

            if(!is_wp_error($tmpFile) && rename($tmpFile, $fileNameWithPath)){
                return $fileNameWithPath;
            }
        }

        return $fileNameWithPath;
    }

	/**
	 * Delete temporary import options
	 */
    private function deleteTempOptions(){
        delete_option('premmerceImportContent');
        delete_option('premmerceImagesUrl');
        delete_option('premmerceImportChecklist');
        delete_option('premmerceImportPostsChecklist');
        delete_option('premmerceInsertedPosts');
    }


    /**
     * Delete WP transients before import
     *
     */
    private function clearTransients(){
        global $wpdb;
        /** @var wpdb $wpdb */

        $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE ('_transient_%')");
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE ('_site_transient_%')");
    }
}

