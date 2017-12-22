<?php

namespace Includes\Modules\Facebook;

use Includes\Modules\Facebook\FacebookInstance;

class FacebookSettings
{
    protected $status;

    public function __construct()
    {
        $this->save();
    }

    public function setupPage()
    {
        $this->createNavLabel();
    }

    protected function createNavLabel()
    {

        add_action('admin_menu', function () {
            add_menu_page('Facebook Settings', 'Facebook Settings', 'manage_options', 'facebook-settings', function () {
                $this->createSettingsPage();
            }, 'dashicons-admin-generic', 999);
        });

    }

    protected function createSettingsPage(){ ?>
        <div class="wrap">
            <h1 class="wp-heading-inline" style="margin-bottom: .5rem;">Facebook Settings</h1>
            <div>
                <?php
                $fbSession = new FacebookInstance( '139165192785547' );
                $hasSavedToken = false; //TODO: check if saved in DB and display
                //TODO: save to DB button

                if($fbSession->checkLogin() || $hasSavedToken) {
                    $fbSession->refreshTokenButton();
                }else{
                    $fbSession->getTokenButton();
                }

                ?>
            </div>
        </div>
        <?php
    }

    protected function save(){



    }

}