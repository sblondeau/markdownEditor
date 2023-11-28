<?php

namespace App\Twig;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Environment\EnvironmentBuilderInterface;

class CommonMarkConfiguration implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addExtension(new TableExtension());
    }

}