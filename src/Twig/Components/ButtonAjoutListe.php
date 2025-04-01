<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('ButtonAjoutListe')]
final class ButtonAjoutListe
{
    public array $articles;

    public function __construct(array $articles)
    {
        $this->articles = $articles;
    }
}
