( function( api ) {

	// Extends our custom "food-restaurant" section.
	api.sectionConstructor['food-restaurant'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );