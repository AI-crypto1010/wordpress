import { store as coreDataStore } from '@wordpress/core-data';
import { dispatch, useSelect } from '@wordpress/data';

const useStorage = () => {
	const save = async ( data ) => {
		try {
			return await dispatch( coreDataStore ).saveEntityRecord( 'root', 'site', data );
		} catch ( error ) {
			console.error( 'Storage save error:', error );
			return Promise.resolve();
		}
	};

	// Fetch site data with useSelect and check resolution status
	const get = useSelect(
		( select ) => {
			try {
				const coreDataSelect = select( coreDataStore );
				if ( ! coreDataSelect ) {
					return {
						data: { image_optimizer_review_data: {} },
						hasFinishedResolution: true,
					};
				}

				return {
					data: coreDataSelect.getEntityRecord( 'root', 'site' ) || { image_optimizer_review_data: {} },
					hasFinishedResolution: coreDataSelect.hasFinishedResolution( 'getEntityRecord', [ 'root', 'site' ] ),
				};
			} catch ( error ) {
				console.error( 'Storage get error:', error );
				return {
					data: { image_optimizer_review_data: {} },
					hasFinishedResolution: true,
				};
			}
		},
		[],
	);

	return {
		save,
		get,
	};
};

export default useStorage;
