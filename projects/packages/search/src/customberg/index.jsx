import { render } from '@wordpress/element';
import Layout from 'components/layout';
import 'styles.scss';

/**
 * Collapses wp-admin's sidebar menu for additional space.
 */
function collapseWpAdminSidebar() {
	document.body.classList.add( 'folded' );
}

/**
 * Initializes the widgets screen
 *
 * @param {string} id - Id of the root element to render the screen.
 */
function initialize( id ) {
	collapseWpAdminSidebar();
	render( <Layout />, document.getElementById( id ) );
}

global.jetpackSearchConfigureInit = initialize;
