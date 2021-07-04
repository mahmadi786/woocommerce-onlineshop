/*admin css*/
( function( diet_shop_api ) {

	diet_shop_api.sectionConstructor['diet_shop_upsell'] = diet_shop_api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
