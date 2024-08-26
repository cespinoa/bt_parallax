# Bootstrap Toolbox Parallax

**Maintainer:** [Carlos Espino](https://www.drupal.org/u/carlos-espino)  
**Drupal.org project page:** [Bootstrap Toolbox Parallax](https://www.drupal.org/project/bt_parallax)  
**Description:** This module provides a field formatter for creating parallax image effects in Bootstrap themes.

## Description

The `Bootstrap Toolbox Parallax` module allows you to apply a parallax effect to images in Drupal fields. This is useful for creating visually engaging sections on your site where images move at a different speed than the rest of the page content as the user scrolls.

This module is designed to work with fields that reference media entities containing images. You can select an image style, an HTML tag to wrap associated text, and apply custom text styles.

## Features

- Provides a field formatter for entity reference fields pointing to image media.
- Allows configuration of image styles.
- Supports customizable text fields and lengths.
- Offers the ability to apply CSS classes or other text styles.
- Integrates seamlessly with Bootstrap themes.

## Requirements

- [Bootstrap Toolbox](https://www.drupal.org/project/bootstrap_toolbox) module
- Drupal 9.x or higher

## Installation

1. Download and install the module as usual:
    ```bash
    composer require drupal/bt_parallax
    drush en bt_parallax
    ```
2. Go to the **Extend** page and enable the "Bootstrap Toolbox Parallax" module.
3. Ensure you have the required dependencies installed.

## Configuration

1. Go to the **Structure** > **Content types** and manage fields for the content type where you want to use the formatter.
2. Add a field that references media entities of type image if you haven't already.
3. In the **Manage Display** tab, select the "Bootstrap Toolbox Parallax Image Formatter" as the field formatter.
4. Configure the formatter settings:
    - **Image Style**: Choose an image style to apply to the image.
    - **Text Field**: Select a text field to overlay on the image.
    - **Text Length**: Define the maximum number of characters to display.
    - **HTML Tag**: Choose an HTML tag to wrap the text.
    - **Text Style**: Apply any additional styles to the text.

## Customization

The module includes several settings for fine-tuning the parallax effect:

- **Image Style**: Define the image style through the Drupal UI or by using the `image.style.yml` configuration files.
- **Text Field**: Customize the text field used for the overlay by managing the content type’s fields.
- **Text Length**: Control the amount of text displayed on the image.
- **HTML Tag**: Use any valid HTML tag to encapsulate the text (e.g., `h1`, `h2`, `p`).
- **Text Style**: Assign custom CSS classes for additional styling.

## Usage

Once configured, the parallax effect will be automatically applied to the images using the selected formatter settings. You can further enhance the appearance using CSS if needed.

## Troubleshooting

- Ensure the referenced image field contains valid media entities.
- Verify that the necessary image styles are created and configured.
- Clear Drupal's cache after making configuration changes.

## Maintainers

- **[Carlos Espino](https://www.drupal.org/u/tu-usuario)** - Initial development and ongoing maintenance.

## License

This project is licensed under the GPLv2 or later.

## Contributing

Contributions are welcome! Please submit issues and patches via the [project page](https://www.drupal.org/project/bt_parallax).

## Similar Modules

- [Parallax Block](https://www.drupal.org/project/parallax_block)
- [Background Images Formatter](https://www.drupal.org/project/bg_image_formatter)
