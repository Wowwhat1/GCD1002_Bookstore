<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Image;
use Symfony\Config\VichUploaderConfig;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
//            ChoiceField::new('Category')->setChoices(static function (?CategoryRepository $foo): array {
//                return $foo->findCategoryName($name)->getChoices();
//            }),
            AssociationField::new('Publisher')->autocomplete(),
            NumberField::new('Cost'),
            ImageField::new('imgUrl')
            ->setBasePath('images/thumbnails')
            ->setUploadDir('public/images/thumbnails')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
        );
    }
}
