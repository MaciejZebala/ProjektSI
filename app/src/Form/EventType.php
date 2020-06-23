<?php
/**
 * Category type.
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Event;
use App\Form\DataTransformer\TagsDataTransformer;
use App\Service\CategoryService;
use App\Service\ContactService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class EventType.
 */
class EventType extends AbstractType
{
    /**
     * Tags data transformer.
     *
     * @var \App\Form\DataTransformer\TagsDataTransformer
     */
    private $tagsDataTransformer;

    /**
     * Category Service.
     *
     * @var CategoryService
     */
    private $categoryService;

    /**
     * Contact Service
     *
     * @var ContactService
     */
    private $contactService;

    /**
     * EventType constructor.
     *
     * @param \App\Form\DataTransformer\TagsDataTransformer $tagsDataTransformer Tags data transformer
     * @param CategoryService                               $categoryService
     * @param ContactService                                $contactService
     */
    public function __construct(TagsDataTransformer $tagsDataTransformer, CategoryService $categoryService, ContactService $contactService)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
        $this->categoryService = $categoryService;
        $this->contactService = $contactService;
    }

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
                'format' => 'dd-MM-yyyy',
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
                'choices' => $this->categoryService->getUserCategories($options['user']),
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
                'choices' => $this->contactService->getUserCategories($options['user']),
                'choice_label' => function ($contact) {
                    $name = $contact->getName();
                    $surname = $contact->getSurname();

                    return $name.' '.$surname;
                },
            ]
        );
        $builder->add(
            'tag',
            TextType::class,
            [
                'label' => 'label_tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );

        $builder->get('tag')->addModelTransformer(
            $this->tagsDataTransformer
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

        $resolver->setRequired('user');
        $resolver->setAllowedTypes('user', [UserInterface::class]);
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
