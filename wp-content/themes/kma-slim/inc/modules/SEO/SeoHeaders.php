<?php
/**
 * Created by PhpStorm.
 * User: Bryan
 * Date: 12/22/2017
 * Time: 3:59 PM
 */

namespace Includes\Modules\SEO;

class SeoHeaders
{
    public function __construct()
    {
        $this->setMetaDescription();
        $this->setSeoTitle();
    }

    protected function setMetaDescription()
    {
        add_action('wp_head', function(){
            global $post;
            $description = get_post_meta($post->ID,'kma_meta_description',true);
            $description = strip_tags($description);
            $description = strip_shortcodes( $description );
            $description = str_replace( array("\n", "\r", "\t"), ' ', $description );
            $description = substr( $description, 0, 160 );
            echo '<meta name="description" content="' . $description . '" />' . "\n";
        });
    }

    protected function setSeoTitle()
    {
        add_filter('wp_title', function(){
            global $post;
            $customTitle = get_post_meta($post->ID,'kma_seo_title',true);
            $finalTitle = ($customTitle != '' ? $customTitle : $post->post_title . ' | ' . get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description', 'display' ) );
            return $finalTitle;
        });
    }
}