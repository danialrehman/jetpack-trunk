import { getActiveStyleName } from '../../../../shared/block-styles';
import { LAYOUT_STYLES } from './constants';
import Layout from './layout';

export function defaultColumnsNumber( attributes ) {
	return Math.min( 3, attributes.images.length );
}

export default function TiledGallerySave( { attributes } ) {
	const { images } = attributes;

	if ( ! images.length ) {
		return null;
	}

	const { align, className, columns = defaultColumnsNumber( attributes ), linkTo } = attributes;

	return (
		<Layout
			align={ align }
			className={ className }
			columns={ columns }
			images={ images }
			layoutStyle={ getActiveStyleName( LAYOUT_STYLES, className ) }
			linkTo={ linkTo }
		/>
	);
}
