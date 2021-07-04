import { registerBlockType } from "@wordpress/blocks";
import "./style.scss";
import Edit from "./edit";
import save from "./save";

// phpcs:disable
/**
 * Subscribe block.
 * Adds the gutenberg block subscibe so that users can add a contactform block
 * for creative mail
 * @package CreativeMail
 */
registerBlockType("ce4wp/subscribe", {
  /**
   * @see ./edit.js
   */
  edit: Edit,

  /**
   * @see ./save.js
   */
  save,
  supports: {
    // Remove the support for wide alignment.
    alignWide: false,
  },
});
