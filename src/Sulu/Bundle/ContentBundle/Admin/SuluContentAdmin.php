<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ContentBundle\Admin;

use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Navigation\Navigation;
use Sulu\Bundle\AdminBundle\Navigation\NavigationItem;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;
use Sulu\Component\Webspace\Webspace;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SuluContentAdmin extends Admin
{
    /**
     * @var WebspaceManagerInterface
     */
    private $webspaceManager;

    public function __construct(WebspaceManagerInterface $webspaceManager, $title, ContainerInterface $container)
    {
        $this->webspaceManager = $webspaceManager;

        $rootNavigationItem = new NavigationItem($title);

        $section = new NavigationItem('navigation.webspaces');

        $rootNavigationItem->addChild($section);

        /** @var Webspace $webspace */
        foreach ($this->webspaceManager->getWebspaceCollection() as $webspace) {
            $webspaceItem = new NavigationItem($webspace->getName());
            $webspaceItem->setIcon('bullseye');

            $contentItem = new NavigationItem('navigation.webspaces.content');
            $contentItem->setAction('content/contents/' . $webspace->getKey());
            $webspaceItem->addChild($contentItem);

            $indexPageItem = new NavigationItem('navigation.webspaces.index-page');
            $indexPageItem->setAction(
                'content/contents/' . $webspace->getKey() . '/edit:index/details'
            );
            $webspaceItem->addChild($indexPageItem);

            $section->addChild($webspaceItem);
        }

        $this->setNavigation(new Navigation($rootNavigationItem));
    }

    /**
     * {@inheritdoc}
     */
    public function getCommands()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getJsBundleName()
    {
        return 'sulucontent';
    }

    /**
     * {@inheritDoc}
     */
    public function getSecurityContexts()
    {
        $webspaceContexts = array();
        foreach ($this->webspaceManager->getWebspaceCollection() as $webspace) {
            /** @var Webspace $webspace */
            $webspaceContexts[] = 'sulu.webspaces.' . $webspace->getKey();
        }
        return array(
            'Sulu' => array(
                'Webspaces' => $webspaceContexts
            )
        );
    }
}