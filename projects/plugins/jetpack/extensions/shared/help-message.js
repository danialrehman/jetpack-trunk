import classNames from 'classnames';
import GridiconNoticeOutline from 'gridicons/dist/notice-outline';
import './help-message.scss';

export default ( { children = null, isError = false, ...props } ) => {
	const classes = classNames( 'help-message', {
		'help-message-is-error': isError,
	} );

	return (
		children && (
			<div className={ classes } { ...props }>
				{ isError && (
					<GridiconNoticeOutline size="24" aria-hidden="true" role="img" focusable="false" />
				) }
				<span>{ children }</span>
			</div>
		)
	);
};
