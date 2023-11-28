<?php

namespace App\Twig\Components;

use App\Entity\Document;
use App\Form\DocumentType;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent()]
final class Editor extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?Document $data = null;

    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(DocumentType::class, $this->data);
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();

        $data = $this->getForm()->getData();

        $entityManager->persist($data);
        $entityManager->flush();

        return $this->redirectToRoute('app_document_edit', [
            'id' => $data->getId(),
        ]);
    } 
    
    #[LiveAction]
    public function update()
    {
        try {
            $this->submitForm();
        } catch (LogicException $e) {
            
        }
        $this->data = $this->getForm()->getData();
    }

    private function getDataModelValue(): ?string
    {
        return '';
    }
}
