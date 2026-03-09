// WordPress menu customizer options
(function () {
    const PIX_NAV = pix_customize_object.PIX_NAV_SECTIONS;
	// Augment each menu item control once it is added and embedded.
	wp.customize.control.bind( 'add', ( control ) => {
		if ( control.extended( wp.customize.Menus.MenuItemControl ) ) {
			control.deferred.embedded.done( () => {
				extendControl( control );
			} );
		}
	} );

	/**
	 * Extend the control with roles information.
	 *
	 * @param {wp.customize.Menus.MenuItemControl} control
	 */
	function extendControl( control ) {
		const MENU_ITEM_DATA = control.setting._value.pix_menu_data;
		for (var menu_section in PIX_NAV) {
			let section_elements = PIX_NAV[menu_section];
			for (var menu_element in section_elements) {
				if(section_elements[menu_element]['element']){
					let element_name = 'menu-item-'+menu_element;
					let element_id_selector = '#edit-menu-item-'+menu_element;
					// Text fields
					if(section_elements[menu_element]['element']==='text'){
						control.container.find( element_id_selector ).val(MENU_ITEM_DATA[menu_element]);
						setSettingRoles( control.setting, { [element_name]: MENU_ITEM_DATA[menu_element] } );
						control.container.find( element_id_selector ).on( 'change keydown paste input', function () {
							setSettingRoles( control.setting, {[element_name]: this.value} );
						} );
					}
					if(section_elements[menu_element]['element']==='advanced'){
						control.container.find( element_id_selector ).val(MENU_ITEM_DATA[menu_element]);
						setSettingRoles( control.setting, { [element_name]: MENU_ITEM_DATA[menu_element] } );
						control.container.find( element_id_selector ).on( 'change keydown paste input', function () {
							setSettingRoles( control.setting, {[element_name]: this.value} );
						} );
					}
					if(section_elements[menu_element]['element']==='media'){
						control.container.find( element_id_selector ).val(MENU_ITEM_DATA[menu_element]);
						setSettingRoles( control.setting, { [element_name]: MENU_ITEM_DATA[menu_element] } );
						control.container.find( element_id_selector ).on( 'change keydown paste input', function () {
							setSettingRoles( control.setting, {[element_name]: this.value} );
						} );
					}
					if(section_elements[menu_element]['element']==='select'){
						if(MENU_ITEM_DATA[menu_element]){
							control.container.find( element_id_selector ).val(MENU_ITEM_DATA[menu_element]);
							setSettingRoles( control.setting, { [element_name]: MENU_ITEM_DATA[menu_element] } );
						}
						control.container.find( element_id_selector ).on( 'change keydown paste input', function () {
							setSettingRoles( control.setting, {[element_name]: this.value} );
						} );
					}
					if(section_elements[menu_element]['element']==='checkbox'){
						if(MENU_ITEM_DATA[menu_element]){
							control.container.find( element_id_selector ).prop('checked', true);
							setSettingRoles( control.setting, { [element_name]: MENU_ITEM_DATA[menu_element] } );
						}
						control.container.find( element_id_selector ).on( 'change keydown paste input', function () {
							if(control.container.find( element_id_selector ).prop('checked')){
								setSettingRoles( control.setting, {[element_name]: true} );
							}else{
								setSettingRoles( control.setting, {[element_name]: false} );
							}
						} );
					}
				}
			}
		}
	}

	/**
	 * Extend the setting with data information.
	 *
	 * @param {wp.customize.Setting} setting
	 * @param {string|Array} data
	 */
	function setSettingRoles( setting, data ) {
		setting.set(
			Object.assign(
				{},
				_.clone( setting() ),
				data 
			)
		);
	}

})();