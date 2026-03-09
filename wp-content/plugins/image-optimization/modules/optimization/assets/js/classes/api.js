import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

import APIError from './exceptions/APIError';

const v1Prefix = '/image-optimizer/v1';

class API {
	static async request( { path, data, method = 'POST' } ) {
		try {
			const response = await apiFetch( {
				path,
				method,
				data,
			} );

			if ( ! response.success ) {
				throw new APIError( response.data.message );
			}

			return response.data;
		} catch ( e ) {
			if ( e instanceof APIError ) {
				throw e;
			} else {
				throw new APIError( e.message );
			}
		}
	}

	static async optimizeSingleImage( { imageId, reoptimize = false } ) {
		return API.request( {
			path: `${ v1Prefix }/optimize/image`,
			data: {
				imageId,
				reoptimize,
				'image-optimization-optimize-image': window?.imageOptimizerControlSettings?.optimizeSingleImageNonce,
			},
		} );
	}

	static async restoreSingleImage( imageId ) {
		return API.request( {
			path: `${ v1Prefix }/backups/restore/${ imageId }`,
			data: {
				'image-optimization-restore-single': window?.imageOptimizerControlSettings?.restoreSingleImageNonce,
			},
		} );
	}

	static async getOptimizationStatus( imageIds ) {
		return API.request( {
			path: `${ v1Prefix }/optimize/status`,
			data: {
				image_ids: imageIds,
			},
		} );
	}

	static async getOptimizationDetails( imageId ) {
		const queryParams = {
			image_id: imageId,
		};

		return API.request( {
			method: 'GET',
			path: addQueryArgs( `${ v1Prefix }/stats/optimization-details`, queryParams ),
		} );
	}
}

export default API;
