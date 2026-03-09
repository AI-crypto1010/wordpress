import { styled } from '@elementor/ui/styles';
import Button from '@elementor/ui/Button';
import FormControl from '@elementor/ui/FormControl';
import TextField from '@elementor/ui/TextField';
import { __ } from '@wordpress/i18n';
import { useSettings } from '../hooks/use-settings';

const FeedbackForm = ( { close, handleSubmitForm } ) => {
	const { feedback, setFeedback } = useSettings();

	return (
		<FormControl fullWidth>
			<StyledTextField
				value={ feedback }
				onChange={ ( e ) => setFeedback( e.target.value ) }
				placeholder={ __( 'Share your thoughts on how we can improve Image Optimizer…', 'image-optimization' ) }
				minRows={ 5 }
				multiline />
			<Button
				color="primary"
				variant="contained"
				onClick={ () => handleSubmitForm( close ) }
			>
				{ __( 'Submit', 'image-optimization' ) }
			</Button>
		</FormControl>
	);
};

export default FeedbackForm;

const StyledTextField = styled( TextField )`
	textarea:focus-visible,
	textarea:active {
		outline: none;
		box-shadow: none;
	}
`;

