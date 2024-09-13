<?php

declare(strict_types=1);

namespace Drupal\bt_parallax\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\bootstrap_toolbox\UtilityServiceInterface;


/**
 * @FieldFormatter(
 *   id = "bt_parallax_image_formatter",
 *   label = @Translation("BT Parallax Image Formatter"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
      
class ParallaxImageFormatter extends FormatterBase {
  
  /**
   * The entity field manager service.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $pluginManager;

  /**
   * The utility service.
   *
   * @var \Drupal\bootstrap_toolbox\UtilityServiceInterface
   */
  protected $utilityService;
  
  // Define constants for default settings
  private const TEXT_FIELD_DEFAULT = '';
  private const IMAGE_STYLE_DEFAULT = 'thumbnail';
  private const TAG_DEFAULT = 'h2';
  private const TEXT_LENGTH_DEFAULT = 0;
  private const TEXT_STYLE_DEFAULT = NULL;
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {
    $instance = parent::create($container, $configuration, $pluginId, $pluginDefinition);
    $instance->utilityService = $container->get('bootstrap_toolbox.utility_service');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'text_field' => self::TEXT_FIELD_DEFAULT,
      'image_style' => self::IMAGE_STYLE_DEFAULT,
      'tag' => self::TAG_DEFAULT,
      'text_length' => self::TEXT_LENGTH_DEFAULT,
      'text_style' => self::TEXT_STYLE_DEFAULT,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc} 
   */
  public function settingsForm(array $form, FormStateInterface $formState) {
    $form = parent::settingsForm($form, $formState);
    
    $settings = $this->getSettings();
    
    $imageStyles = $this->utilityService->getImageStyles();

    $entityType = $this->fieldDefinition->getTargetEntityTypeId();
    $bundle = $this->fieldDefinition->getTargetBundle();

    $textFields = [];
    if($entityType && $bundle){
      $textFields = $this->utilityService->getBundleFields($entityType, $bundle, ['string', 'text', 'text_with_summary' ]);  
    }
    

    $tagsStyles = $this->utilityService->getTagStyles();
    
    $form['image_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Image style'),
      '#options' => $imageStyles,
      '#default_value' => $settings['image_style'],
    ];
    
    $form['text_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Text field'),
      '#options' => $textFields,
      '#default_value' => $settings['text_field'],
    ];

    $form['text_length'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text length (Number of characters)'),
      '#default_value' => $settings['text_length'] ?? 0,
    ];

    $form['text_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Texy field style'),
      '#options' => $this->utilityService->getScopeListFiltered(['text_area_formatters']),
      '#empty_option' => 'None',
      '#default_value' => $settings['text_style'],
    ];
    
    $form['tag'] = [
      '#type' => 'select',
      '#title' => $this->t('Html tag'),
      '#options' => $tagsStyles,
      '#default_value' => $settings['tag'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    
    $imageStyles = $this->utilityService->getImageStyles();
    $imageStyle = $imageStyles[$settings['image_style']];

    $entityType = $this->fieldDefinition->getTargetEntityTypeId();
    $bundle = $this->fieldDefinition->getTargetBundle();
    $textFields = $this->utilityService->getBundleFields($entityType, $bundle, ['string', 'text', 'text_with_summary' ]);
    $textField = $textFields[$settings['text_field']];
    
    $tagsStyles = $this->utilityService->getTagStyles();
    $tagStyle = $tagsStyles[$settings['tag']];

    $textStyles = $this->utilityService->getScopeListFiltered(['text_area_formatters']);
    $textStyle = $textStyles[$settings['text_style']];
    
    $summary = [];
    $summary[] = $this->t('Image style: @image_style', ['@image_style' => $imageStyle ] );
    $summary[] = $this->t('Text field: @field', ['@field' => $textField]);
    $summary[] = $this->t('HTML tag: @tag', ['@tag' => $tagStyle]);
    $summary[] = $this->t('Text style: @text_style', ['@text_style' => $textStyle]);
    return $summary;
  }


  /**
   * Returns a renderable array for a list of field items.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *   The field items.
   * @param string $langcode
   *   The language code.
   *
   * @return array
   *   A renderable array.
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {


    /**
     * Falta aplicar los estilos de Bootstrap Tooolbox
     * */
    
    $elements = [];
    $settings = $this->getSettings();
    $textField = $settings['text_field'];
    $textLength = $settings['text_length'];
    $imageStyle = $settings['image_style'];
    $tag = $settings['tag'];

    $parentEntity = $items->getEntity();
    
    foreach ($items as $delta => $item) {
      $mediaId = $item->target_id;
      $imageUrl = $this->utilityService->getMediaUrlByMediaIdAndImageStyle($mediaId,$imageStyle);
      if ($parentEntity->hasField($textField)) {
        $textValue = $parentEntity->get($textField)->value;
      }
      if($parentEntity->getEntityTypeId() == 'block_content' && $texfield == 'info'){
        $textValue = $parentEntity->label();
      }
      if($textLength){
        $textValue = text_summary($textValue ?? '', NULL, $textLength);
      }
      if($settings['text_style']){
        $classes = $this->utilityService->getStyleById($settings['text_style']);
      } else {
        $classes = NULL;
      }
      
      $elements[$delta] = [
        '#theme' => 'bt_parallax_image',
        '#image_url' => $imageUrl,
        '#text' => $textValue ? $this->utilityService->createMarkup($textValue) : '',
        '#classes' =>  $classes,
        '#tag' => $tag,
        '#attached' => [
          'library' => [
            'bt_parallax/bt_parallax_image',
          ],
        ],
      ];
    }
    return $elements;
  }
  
}

