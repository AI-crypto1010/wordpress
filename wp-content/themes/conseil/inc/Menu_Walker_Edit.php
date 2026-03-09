<?php
/**
 * Custom walker for Edit menu.
 */

class PixFort_Menu_Walker_Edit extends Walker_Nav_Menu_Edit {

	/**
	 * Start the element output.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		parent::start_el( $output, $item, $depth, $args, $id );


		$custom_fields = Menu::$custom_fields;

		// Prevent from displaying warnings about invalid HTML.
		libxml_use_internal_errors( true );

		$dom = new DOMDocument();

		// Prevent using LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD as support deppends on Libxml version.
		// Wrapping the output in a container div.
		$dom->loadHTML( mb_convert_encoding( '<div>' . $output . '</div>', 'HTML-ENTITIES', 'UTF-8' ) );
		// Remove this container from the document, DOMElement of it still exists.
		$container = $dom->getElementsByTagName( 'div' )->item( 0 );
		$container = $container->parentNode->removeChild( $container );
		// Remove all  direct children from the document ( <html>,<head>,<body> ).
		while ( $dom->firstChild ) {
			$dom->removeChild( $dom->firstChild );
		}
		// Document clean. Add direct children of the container to the document again.
		while ($container->firstChild ) {
			$dom->appendChild( $container->firstChild );
		}

		$xpath = new \DOMXpath( $dom );

		// Clear the errors so they are not kept in memory.
		libxml_clear_errors();

		$classname = 'menu-item';

		// Get last li element as output will contain all menu elements before the current element.
		$li = $xpath->query( "(//li[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')])[last()]" );
		$menu_element_id = (int) str_replace( 'menu-item-', '', $li->item( 0 )->getAttribute( 'id' ) );

		// Safety check.
		if ( (int) $menu_element_id !== (int) $item->ID ) {
			return;
		}
		// Get the fieldset in the list element.
		// a faire: need to make sure is the correct fieldset by class. No risk now as there is only one.
		$fieldset = $li->item( 0 )->getElementsByTagName( 'fieldset' );
		// Get the firs element of the fieldset, in this case it's a span.
		// a faire: get first element independently of the tag.
		$in_fieldset = $fieldset->item( 0 )->getElementsByTagName( 'span' );
		// Create an element as a wrapper for the fields.
		$custom_fields_wrapper = $dom->createElement( 'div' );
		$custom_fields_wrapper->setAttribute( 'class', 'menu_custom_fields' );

		foreach ( $custom_fields as $field_key => $field ) {

			$label = false;
			$input = false;

			if ( ! isset( $field['label'] ) || ! isset( $field['element'] )  ) {
				continue;
			}


			$field_wrapper = $dom->createElement( 'p' );
			$field_wrapper->setAttribute( 'class', 'description-wide' );

			// Create the label and input elements.
			$label = $dom->createElement( 'label', esc_html( $field['label'] ) );
			$label->setAttribute( 'for', "edit-{$field_key}-{$item->ID}" );

			$input = $dom->createElement( $field['element'] );
			$input->setAttribute( 'id', "edit-{$field_key}-{$item->ID}" );
			$input->setAttribute( 'name', "{$field_key}[{$item->ID}]" );

			// Set the atrributes.
			if ( isset( $field['attrs'] ) ) {
				foreach ( $field['attrs'] as $attr_key => $attr_value ) {
					$input->setAttribute( $attr_key, $attr_value );
				}
			}


			// If the element has options then create the options.
			if ( isset( $field['options'] ) ) {
				if ( method_exists( $this, 'create_options_for_' . $field['element'] ) ) {
					$input = call_user_func( array( $this, 'create_options_for_' . $field['element'] ), $dom, $field_key, $item->ID, $input, $field );
				}
			} else {
				// Set the value.
				$input->setAttribute( 'value', get_post_meta( $item->ID, $field_key, true ) );
                if ( isset( $field['attrs']['type'] ) ) {
                    if($field['attrs']['type']=="checkbox"){
                        if(get_post_meta( $item->ID, $field_key, true )!=""){
                            $input->setAttribute( 'checked', "true" );
                        }
                    }
                }


			}


			// Append the elements.
            $label->appendChild( $input );
			$field_wrapper->appendChild( $label );
			$custom_fields_wrapper->appendChild( $field_wrapper );
		}

		// Intert it at the beginng of the fieldset.
		$in_fieldset->item( 0 )->parentNode->insertBefore( $custom_fields_wrapper, $in_fieldset->item( 0 ) );

		$output = $dom->saveHTML();



	}

	/**
	 * Appends and returns the option elements for a select dropdown.
	 */
	public function create_options_for_select( $dom, $field_key, $menu_item_id, $input, $field ) {

		foreach ( $field['options'] as $key => $name ) {

			$option = $dom->createElement( 'option', esc_html( $name ) );
			$option->setAttribute( 'value', $key );

			if ( selected( get_post_meta( $menu_item_id, $field_key, true ), $key, false ) ) {
				$option->setAttribute( 'selected', 'selected' );
			}

			$input->appendChild( $option );
		}

		return $input;
	}
}
