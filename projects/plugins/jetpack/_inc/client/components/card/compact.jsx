import classnames from 'classnames';
import Card from 'components/card';
import { assign } from 'lodash';
import React from 'react';

export default class CompactCard extends React.Component {
	static displayName = 'CompactCard';

	render() {
		const props = assign( {}, this.props, {
			className: classnames( this.props.className, 'is-compact' ),
		} );

		return <Card { ...props }>{ this.props.children }</Card>;
	}
}
