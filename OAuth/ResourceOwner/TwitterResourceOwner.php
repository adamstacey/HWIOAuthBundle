<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware.Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HWI\Bundle\OAuthBundle\OAuth\ResourceOwner;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * TwitterResourceOwner
 *
 * @author Alexander <iam.asm89@gmail.com>
 */
class TwitterResourceOwner extends GenericOAuth1ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = array(
        'identifier'     => 'id_str',
        'nickname'       => 'screen_name',
        'realname'       => 'name',
        'profilepicture' => 'profile_image_url_https',
    );

    /**
     * {@inheritDoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'authorization_url' => 'https://api.twitter.com/oauth/authenticate',
            'request_token_url' => 'https://api.twitter.com/oauth/request_token',
            'access_token_url'  => 'https://api.twitter.com/oauth/access_token',
            'infos_url'         => 'https://api.twitter.com/1.1/account/verify_credentials.json',
            'x_auth_access_type' => 'write',
            'include_entities' => null,
            'skip_status' => null,
            'include_email' => null,
        ));

        // Symfony <2.6 BC
        if (method_exists($resolver, 'setDefined')) {
            $resolver
                ->setAllowedValues('x_auth_access_type', array('read', 'write'))
                // @link https://dev.twitter.com/oauth/reference/post/oauth/request_token
                ->setAllowedValues('include_entities', array(true, false, null))
                ->setAllowedValues('skip_status', array(true, false, null))
                ->setAllowedValues('include_email', array(true, false, null))
            ;
        } else {
            $resolver->setAllowedValues(array(
                'x_auth_access_type' => array('read', 'write'),
                'include_entities' => array(true, false, null),
                'skip_status' => array(true, false, null),
                'include_email' => array(true, false, null),
            ));
        }
    }
}
