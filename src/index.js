/**
 * Registers the Easy Logo Carousel marquee block.
 *
 * This is a dynamic block — markup is produced server-side by render.php, so
 * there is no save() function (it defaults to null).
 */
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';
import Edit from './edit';

import './style.scss';
import './editor.scss';

registerBlockType( metadata.name, {
	edit: Edit,
} );
