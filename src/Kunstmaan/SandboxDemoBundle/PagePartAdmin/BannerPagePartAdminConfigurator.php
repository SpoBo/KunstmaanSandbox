<?php

namespace Kunstmaan\SandboxDemoBundle\PagePartAdmin;

use Kunstmaan\PagePartBundle\PagePartAdmin\AbstractPagePartAdminConfigurator;

class BannerPagePartAdminConfigurator extends AbstractPagePartAdminConfigurator
{

    /**
     * @var array
     */
    private $pagePartTypes;

    /**
     * @param array $pagePartTypes
     */
    public function __construct(array $pagePartTypes = array())
    {
        $this->pagePartTypes = array_merge(
            array(
                array(
                    'name' => 'Header',
                    'class'=> 'Kunstmaan\PagePartBundle\Entity\HeaderPagePart'
                ),
                array(
                    'name' => 'Text',
                    'class'=> 'Kunstmaan\PagePartBundle\Entity\TextPagePart'
                ),
                array(
                    'name' => 'Line',
                    'class'=> 'Kunstmaan\PagePartBundle\Entity\LinePagePart'
                ),
                array(
                    'name' => 'Image',
                    'class'=> 'Kunstmaan\MediaPagePartBundle\Entity\ImagePagePart'
                )
            ), $pagePartTypes
        );
    }

    /**
     * @return array
     */
    function getPossiblePagePartTypes()
    {
        return $this->pagePartTypes;
    }

    /**
     * @return string
     */
    function getName()
    {
        return "Banners";
    }

    /**
     * @return string
     */
    function getDefaultContext()
    {
        return "banners";
    }
}
