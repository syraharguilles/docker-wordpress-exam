import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, MediaUpload, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

function Edit({ attributes, setAttributes }) {
  const { imageUrl, heading, buttonText, buttonUrl } = attributes;

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Hero Settings', 'proevent')}>
          <MediaUpload
            onSelect={(media) => setAttributes({ imageUrl: media.url })}
            allowedTypes={["image"]}
            render={({ open }) => (
              <Button onClick={open} isPrimary>
                {imageUrl ? __('Change Image', 'proevent') : __('Select Image', 'proevent')}
              </Button>
            )}
          />
          {imageUrl && (
            <div style={{ marginTop: '1em' }}>
              <img src={imageUrl} alt="Preview" style={{ maxWidth: '100%', borderRadius: '4px' }} />
            </div>
          )}
          <TextControl
            label={__('Heading', 'proevent')}
            value={heading}
            onChange={(val) => setAttributes({ heading: val })}
          />
          <TextControl
            label={__('Button Text', 'proevent')}
            value={buttonText}
            onChange={(val) => setAttributes({ buttonText: val })}
          />
          <TextControl
            label={__('Button URL', 'proevent')}
            value={buttonUrl}
            onChange={(val) => setAttributes({ buttonUrl: val })}
          />
        </PanelBody>
      </InspectorControls>
      <div {...useBlockProps()} className="bg-cover bg-center text-white p-12" style={{ backgroundImage: `url(${imageUrl})` }}>
        <h2 className="text-4xl font-bold mb-4">{heading}</h2>
        <a href={buttonUrl} className="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">
          {buttonText}
        </a>
      </div>
    </>
  );
}

// ✅ Register the block
registerBlockType('proevent/hero-cta', {
  title: 'Hero with CTA',
  icon: 'megaphone',
  category: 'design',
  attributes: {
    imageUrl: { type: 'string', default: '' },
    heading: { type: 'string', default: 'Join Our Event' },
    buttonText: { type: 'string', default: 'Learn More' },
    buttonUrl: { type: 'string', default: '#' }
  },
  edit: Edit,
  save: () => null // dynamic block
});
