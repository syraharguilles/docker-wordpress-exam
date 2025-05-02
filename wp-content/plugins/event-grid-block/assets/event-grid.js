document.addEventListener('DOMContentLoaded', () => {
	const blocks = document.querySelectorAll('[data-category][data-limit]');

	blocks.forEach((block) => {
		const limit = block.dataset.limit || 6;
		let category = block.dataset.category || '';
		const order = block.dataset.order || 'ASC';
		const orderby = block.dataset.orderby || 'meta_value';

		// Create a wrapper with filter + results
		const wrapper = document.createElement('div');
		wrapper.innerHTML = `
			<div class="mb-4">
				<label for="event-category-filter" class="block text-sm font-medium mb-1">Filter by Category:</label>
				<select id="event-category-filter" class="border rounded px-2 py-1"></select>
			</div>
			<div class="event-grid-results">Loading events...</div>
		`;
		block.innerHTML = '';
		block.appendChild(wrapper);

		const resultsContainer = wrapper.querySelector('.event-grid-results');
		const categorySelect = wrapper.querySelector('#event-category-filter');

		// Fetch categories for the dropdown
		fetch('/wp-json/wp/v2/event-category?per_page=100')
			.then((res) => res.json())
			.then((cats) => {
				categorySelect.innerHTML = `<option value="">All Categories</option>` +
					cats.map((cat) => {
						const selected = cat.slug === category ? 'selected' : '';
						return `<option value="${cat.slug}" ${selected}>${cat.name}</option>`;
					}).join('');
			});

		// Fetch and render events
		const fetchEvents = () => {
			const url = new URL('/wp-json/proevent/v1/next', window.location.origin);
			if (category) url.searchParams.append('category', category);
			url.searchParams.append('limit', limit);
			url.searchParams.append('order', order);
			url.searchParams.append('orderby', orderby);

			fetch(url)
				.then(res => res.json())
				.then(data => {
					if (!Array.isArray(data) || data.length === 0) {
						resultsContainer.innerHTML = `<p>No events found.</p>`;
						return;
					}

					resultsContainer.innerHTML = `<div class="grid md:grid-cols-3 gap-6">` + data.map(event => `
						<div class="bg-white shadow border rounded p-4">
							<h3 class="text-lg font-semibold mb-2">${event.title}</h3>
							<p class="text-sm text-gray-600">${event.date} ${event.time || ''}</p>
							<p class="text-sm">${event.location || ''}</p>
							<a href="${event.link}" class="text-blue-600 hover:underline text-sm">View Details →</a>
						</div>
					`).join('') + `</div>`;
				});
		};

		// Listen to dropdown change
		categorySelect.addEventListener('change', (e) => {
			category = e.target.value;
			fetchEvents();
		});

		// Initial load
		fetchEvents();
	});
});
