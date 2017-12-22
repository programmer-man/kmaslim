<?php

namespace Includes\Modules\SEO;

class MetaSettings
{
    protected $post;
    protected $wpScreen;
    protected $allowedPostTypes;
    protected $templateDir;

    public function __construct()
    {
        $this->allowedPostTypes = [ //TODO: Add to Settings page
            'page',
            'post'
        ];

        $this->templateDir = dirname(__FILE__) . '/templates';

        add_action('current_screen', function(){
            $this->wpScreen = get_current_screen();
            if(in_array($this->wpScreen->post_type, $this->allowedPostTypes)) {
                $this->setupPageFields();
            }
        });

        // Listen for the save post hook
        $this->save();
    }

    protected function setupPageFields()
    {
        add_action( 'add_meta_boxes', function(){
            add_meta_box( 'seo-meta-box', 'SEO Settings', function(){
                $this->addFieldsToMetaBox();
            });
        });

    }

    public function addFieldsToMetaBox(){

        global $post;
        $meta = get_post_custom($post->ID);

        $seoTitle        = isset($meta['kma_seo_title']) ? $meta['kma_seo_title'][0] : '';
        $metaDescription = isset($meta['kma_meta_description']) ? $meta['kma_meta_description'][0] : '';
        $allowIndexing   = isset($meta['kma_allow_indexing']) ? $meta['kma_allow_indexing'][0] : '';
        $permalink       = get_permalink($post->ID);

        include(wp_normalize_path($this->templateDir . '/seo-meta-box.php'));
    }

    public function save()
    {
        add_action(
            'save_post',
            function () {
                // Deny the WordPress autosave function
                if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                    return;
                }

                $customFields = [
                    'kma_seo_title',
                    'kma_meta_description'
                ];

                global $post;

                foreach($customFields as $field){
                    if(isset($post->ID) && isset($_POST['custom_meta'][$field])) {
                        update_post_meta($post->ID, $field, $_POST['custom_meta'][$field]);
                    }
                }
            }
        );
    }
}