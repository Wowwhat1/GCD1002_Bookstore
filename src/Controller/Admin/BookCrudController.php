<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Publisher;
use App\Repository\CategoryRepository;
use App\Repository\PublisherRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Config\VichUploaderConfig;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return array(
            TextField::new('Title'),
            TextField::new('Author'),
            AssociationField::new('Category'),
            AssociationField::new('Publisher'),
            NumberField::new('Cost'),
            ImageField::new('imgUrl')
                ->setBasePath('images/book')
                ->setUploadDir('public/images/book')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        );
    }
}
