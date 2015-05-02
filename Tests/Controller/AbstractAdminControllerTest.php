<?php
/*
 * This file is part of the LightCMSBundle package.
 *
 * (c) Fulgurio <http://fulgurio.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fulgurio\LightCMSUserBundle\Tests\Controller;
use Fulgurio\LightCMSBundle\Tests\Controller\AbstractAdminControllerTest as LiipWebTestCase;

/**
 * Abstract used for tests
 */
abstract class AbstractAdminControllerTest extends LiipWebTestCase
{
    /**
     * Init database
     */
    public function setup()
    {
        $this->loadFixtures(array(
            'Fulgurio\LightCMSUserBundle\Tests\DataFixtures\ORM\LoadUsers'
        ));
    }

    /**
     * Login to a page
     *
     * @param string $url
     * @return Client
     */
    protected function login($url)
    {
        $client = static::createClient();
        if ($client->getContainer()->has('security.firewall.map.context.lightcms_secured_area'))
        {
            $client->request('GET', $url);

            $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));

            $crawler = $client->followRedirect();

            $form = $crawler->filter('button[type=submit]')->form();

            // set some values
            $form['_username'] = 'test1';
            $form['_password'] = 'test1Password';

            // submit the form
            $client->submit($form);
            $client->followRedirect();

            // User is authentified
            $security = $client->getContainer()->get('security.context');
            $this->assertTrue($security->isGranted('ROLE_ADMIN'));
            return $client;
        }
        return parent::login($url);
    }
}
