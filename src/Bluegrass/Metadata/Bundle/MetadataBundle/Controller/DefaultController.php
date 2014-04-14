<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BluegrassMetadataBundleMetadataBundle:Default:index.html.twig', array('name' => $name));
    }
}
