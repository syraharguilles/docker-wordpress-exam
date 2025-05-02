import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

function Edit({ attributes, setAttributes }) {
	const { limit, category, order, orderby } = attributes;

	// Fetch event-category terms from REST API
	const categories = useSelect(
		(select) =>
			select(coreStore).getEntityRecords('taxonomy', 'event-category', {
				per_page: -1,
			}),
		[]
	);

	const categoryOptions = Array.isArray(categories)
	? [
		{ label: __('All Categories', 'proevent'), value: '' },
		...categories.map((cat) => ({
		  label: cat.name,
		  value: cat.slug,
		})),
	  ]
	: [{ label: __('Loading…', 'proevent'), value: '' }];

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Event Grid Settings', 'proevent')}>
					<TextControl
						label={__('Limit', 'proevent')}
						type="number"
						value={limit}
						onChange={(val) => setAttributes({ limit: parseInt(val, 10) || 6 })}
						min={1}
					/>

					<SelectControl
						label={__('Category', 'proevent')}
						value={category}
						options={categoryOptions}
						onChange={(val) => setAttributes({ category: val })}
					/>

					<SelectControl
						label={__('Order', 'proevent')}
						value={order}
						options={[
							{ label: 'ASC', value: 'ASC' },
							{ label: 'DESC', value: 'DESC' },
						]}
						onChange={(val) => setAttributes({ order: val })}
					/>

					<SelectControl
						label={__('Order By', 'proevent')}
						value={orderby}
						options={[
							{ label: __('Date (Meta)', 'proevent'), value: 'meta_value' },
							{ label: __('Title', 'proevent'), value: 'title' },
						]}
						onChange={(val) => setAttributes({ orderby: val })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				<p>
					<strong>{__('Event Grid Block:', 'proevent')}</strong> {limit} {__('events', 'proevent')}
				</p>
			</div>
		</>
	);
}

registerBlockType('proevent/event-grid', {
	apiVersion: 3,
	title: __('Event Grid', 'proevent'),
	icon: 'grid-view',
	category: 'widgets',
	attributes: {
		limit: { type: 'number', default: 6 },
		category: { type: 'string', default: '' },
		order: { type: 'string', default: 'ASC' },
		orderby: { type: 'string', default: 'meta_value' },
	},
	edit: Edit,
	save: () => null, // Dynamic block – rendered via PHP
});
