<?php

class LoyalsAdminExtension extends LeftAndMainExtension
{
    public function init()
    {

        Config::inst()
            ->update(
                'LeftAndMain',
                'application_link',
                'https://loyals.nl/'
            );

    }

}
