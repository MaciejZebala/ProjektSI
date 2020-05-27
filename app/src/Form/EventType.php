<?php
/**
 * Category type.
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EventType.
 */
class EventType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'date',
            DateType::class,
            [
                'label' => 'label_date',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );

        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label_title',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );

        $builder->add(
            'category',
            EntityType::class,
            [
                'label' => 'label_category',
                'required' => true,
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getTitle();
                },
            ]
        );
        $builder->add(
            'contact',
            EntityType::class,
            [
                'label' => 'label_contact',
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'class' => Contact::class,
                'choice_label' => function ($contact) {
                    $name = $contact->getName();
                    $surname = $contact->getSurname();

                    return $name.' '.$surname;
                },
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Event::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'event';
    }
}
