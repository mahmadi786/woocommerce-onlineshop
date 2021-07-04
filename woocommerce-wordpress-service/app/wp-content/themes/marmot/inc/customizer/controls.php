<?php

namespace Marmot\Customizer;

defined('ABSPATH') || exit;

/**
 * Contains controls for customizing the theme.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since 1.0.0
 */
class Controls extends \WP_Customize_Control {

    public $type;
    public $link;
    public $url;
    public $title;
    public $step;
    public $min;
    public $subcontrols;

    public function render_content() {
        switch ($this->type) { // Escape non value from set Customize::setDefauls
            case 'hr':
                echo '<hr class="customize-separator" />';
                break;

            case 'sub-title':
                if (isset($this->label)) {
                    ?>
                    <h4 class="customize-sub-title"><?php echo esc_html($this->label); ?></h4>
                    <?php
                    if (!empty($this->description)) {
                        echo '<span class="description customize-control-description">' . esc_html($this->description) . '</span>';
                    }
                }
                break;

            case 'raw_html':
                echo esc_html($this->description);
                break;

            case 'link':
                echo '<a class="customize-link" href="' . esc_attr($this->url) . '" target="_blank">' . esc_html($this->label) . '</a>';
                break;

            case 'description':
                ?>
                <p class="customize-description"><span>Info:</span> <?php echo esc_html($this->label); ?></p>
                <?php
                break;

            case 'warning':
                ?>
                <p class="customize-warning"><span>Warning:</span> <?php echo esc_html($this->label); ?></p>
                <?php
                break;

            case 'multiple-select':
                ?>
                <label>
                    <?php
                    if (!empty($this->label)) {
                        echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                    }
                    if (!empty($this->description)) {
                        echo '<span class="description customize-control-description">' . esc_html($this->description) . '</span>';
                    }
                    ?>
                    <select <?php $this->link(); ?> multiple="multiple" style="height: 156px;">
                        <?php
                        foreach ($this->choices as $value => $label) {
                            $selected = (in_array($value, $this->value())) ? selected(1, 1, false) : '';
                            // phpcs:ignore
                            echo '<option value="' . esc_attr($value) . '"' . $selected . '>' . $label . '</option>';
                        }
                        ?>
                    </select>
                </label>
                <?php
                break;

            case 'pro':
                ?>
                <label>
                    <?php
                    if (!empty($this->label)) {
                        echo '<span class="customize-control-title">' . esc_html($this->label) . ' PRO</span>';
                    }
                    if (!empty($this->description)) {
                        echo '<span class="description customize-control-description">' . esc_html($this->description) . '</span>';
                    }
                    /* translators: %1$s: a tag open; %2$s: a tag close; */
                    echo '<span class="description customize-control-description">' . esc_html(sprintf(_x('This contol is available only with PRO license. %1$sLearn more%2$s', 'settings', 'marmot'), '<a href="' . esc_url(admin_url('admin.php?page=marmot#marmot-enhancer-pro')) . '" target="_blank">', '</a>')) . '</span>';
                    ?>
                </label>
                <?php
                break;

            default:
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo 'MISSING CONTROLL ' . $this->type;
                die;
                break;
        }
    }

}
