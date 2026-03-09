import APIBase from '../../../../../assets/dev/js/api/apiBase';

const v1Prefix = '/image-optimizer/v1';

class API extends APIBase {
	/**
	 * @param {Object} data
	 * @return {Promise<any>} result
	 */
	static async sendFeedback( data ) {
		return API.request( {
			method: 'POST',
			path: `${ v1Prefix }/reviews/review`,
			data,
		} );
	}
}

export default API;
