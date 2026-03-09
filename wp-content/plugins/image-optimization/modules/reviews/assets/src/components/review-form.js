import FormControl from '@elementor/ui/FormControl';
import Button from '@elementor/ui/Button';
import Typography from '@elementor/ui/Typography';
import { __ } from '@wordpress/i18n';
import useStorage from '../hooks/use-storage';
import { WORDPRESS_REVIEW_LINK } from '../constants';

const ReviewForm = ( { close } ) => {
	const { save, get } = useStorage();

	const handleSubmit = async () => {
		await save( {
			image_optimizer_review_data: {
				...get.data.image_optimizer_review_data,
				repo_review_clicked: true,
			},
		} );

		close();
		window.open( WORDPRESS_REVIEW_LINK, '_blank' );
	};

	return (
		<FormControl fullWidth>
			<Typography variant="body1" marginBottom={ 1 }>
				{ __( 'It would mean a lot if you left us a quick review, so others can discover it too.', 'image-optimization' ) }
			</Typography>
			<Button
				color="primary"
				variant="contained"
				onClick={ handleSubmit }
			>
				{ __( 'Leave a review', 'image-optimization' ) }
			</Button>
		</FormControl>
	);
};

export default ReviewForm;
