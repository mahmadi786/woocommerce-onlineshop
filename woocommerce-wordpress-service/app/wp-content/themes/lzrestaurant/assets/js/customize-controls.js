( function( api ) {

	// Extends our custom "lzrestaurant" section.
	api.sectionConstructor['lzrestaurant'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );