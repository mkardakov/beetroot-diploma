<?php

namespace App\Form;

use App\Entity\Price;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('image')
            ->add('categories', null, ['by_reference' => false]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Product $product */
            $product = $event->getData();
            $form = $event->getForm();

            $form->add('price', NumberType::class, ['data' => $product->getCurrentPrice(), 'mapped' => false]);
        });
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            /** @var Product $product */
            $product = $event->getData();
            $form = $event->getForm();

            foreach ($product->getPrice() as $pr) {
                $pr->setIsCurrent(false);
            }
            $price = new Price();
            $price->setValue($form->get('price')->getData());
            $price->setIsCurrent(true);
            $product->addPrice($price);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
