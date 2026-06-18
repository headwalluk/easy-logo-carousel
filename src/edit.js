/**
 * Editor UI for the Easy Logo Carousel marquee block.
 */
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	BlockControls,
	MediaPlaceholder,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	ToggleControl,
	ToolbarGroup,
	ToolbarButton,
} from '@wordpress/components';

const ALLOWED_MEDIA_TYPES = [ 'image' ];

/**
 * Map raw media objects from the picker down to what we store.
 *
 * @param {Object[]} media Selected attachments.
 * @return {Object[]} Trimmed image records.
 */
const toImages = ( media ) =>
	media.map( ( image ) => ( {
		id: image.id,
		url: image.url,
		alt: image.alt || '',
	} ) );

export default function Edit( { attributes, setAttributes } ) {
	const { images, speed, repeat, pauseOnHover, logoHeight, gap, grayscale } =
		attributes;
	const blockProps = useBlockProps();
	const hasImages = Array.isArray( images ) && images.length > 0;

	const onSelectImages = ( media ) =>
		setAttributes( { images: toImages( media ) } );

	const previewStyle = {
		'--elc-gap': `${ gap }px`,
		'--elc-logo-height': `${ logoHeight }px`,
	};

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Carousel settings', 'easy-logo-carousel' ) }
				>
					<RangeControl
						label={ __(
							'Scroll speed (seconds per logo set)',
							'easy-logo-carousel'
						) }
						help={ __(
							'Lower is faster. This stays consistent however many times the set repeats.',
							'easy-logo-carousel'
						) }
						value={ speed }
						onChange={ ( value ) =>
							setAttributes( { speed: value } )
						}
						min={ 5 }
						max={ 120 }
					/>
					<ToggleControl
						label={ __( 'Pause on hover', 'easy-logo-carousel' ) }
						checked={ pauseOnHover }
						onChange={ ( value ) =>
							setAttributes( { pauseOnHover: value } )
						}
					/>
					<RangeControl
						label={ __(
							'Logo height (px)',
							'easy-logo-carousel'
						) }
						value={ logoHeight }
						onChange={ ( value ) =>
							setAttributes( { logoHeight: value } )
						}
						min={ 16 }
						max={ 200 }
					/>
					<RangeControl
						label={ __(
							'Gap between logos (px)',
							'easy-logo-carousel'
						) }
						value={ gap }
						onChange={ ( value ) =>
							setAttributes( { gap: value } )
						}
						min={ 0 }
						max={ 160 }
					/>
					<ToggleControl
						label={ __(
							'Greyscale logos',
							'easy-logo-carousel'
						) }
						checked={ grayscale }
						onChange={ ( value ) =>
							setAttributes( { grayscale: value } )
						}
					/>
				</PanelBody>
				<PanelBody
					title={ __( 'Advanced', 'easy-logo-carousel' ) }
					initialOpen={ false }
				>
					<RangeControl
						label={ __(
							'Repeat logo set',
							'easy-logo-carousel'
						) }
						help={ __(
							'How many copies of the logos fill the strip. Increase this if you see a gap before the loop repeats (e.g. with few or small logos on a wide screen).',
							'easy-logo-carousel'
						) }
						value={ repeat }
						onChange={ ( value ) =>
							setAttributes( { repeat: value } )
						}
						min={ 1 }
						max={ 8 }
					/>
				</PanelBody>
			</InspectorControls>

			{ hasImages && (
				<BlockControls>
					<ToolbarGroup>
						<MediaUploadCheck>
							<MediaUpload
								onSelect={ onSelectImages }
								allowedTypes={ ALLOWED_MEDIA_TYPES }
								multiple
								gallery
								value={ images.map( ( image ) => image.id ) }
								render={ ( { open } ) => (
									<ToolbarButton onClick={ open }>
										{ __(
											'Edit images',
											'easy-logo-carousel'
										) }
									</ToolbarButton>
								) }
							/>
						</MediaUploadCheck>
					</ToolbarGroup>
				</BlockControls>
			) }

			<div { ...blockProps }>
				{ hasImages ? (
					<div
						className="elc-marquee elc-marquee--preview"
						style={ previewStyle }
					>
						<ul
							className={ `elc-track${
								grayscale ? ' is-grayscale' : ''
							}` }
						>
							{ images.map( ( image, index ) => (
								<li
									className="elc-item"
									key={ `${ image.id }-${ index }` }
								>
									<img src={ image.url } alt={ image.alt } />
								</li>
							) ) }
						</ul>
					</div>
				) : (
					<MediaPlaceholder
						icon="images-alt2"
						labels={ {
							title: __(
								'Logo Carousel',
								'easy-logo-carousel'
							),
							instructions: __(
								'Select logo images from your Media Library to scroll in the carousel.',
								'easy-logo-carousel'
							),
						} }
						onSelect={ onSelectImages }
						accept="image/*"
						allowedTypes={ ALLOWED_MEDIA_TYPES }
						multiple
					/>
				) }
			</div>
		</>
	);
}
