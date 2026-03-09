import FormControl from '@elementor/ui/FormControl';
import FormControlLabel from '@elementor/ui/FormControlLabel';
import ListItem from '@elementor/ui/ListItem';
import ListItemIcon from '@elementor/ui/ListItemIcon';
import Radio from '@elementor/ui/Radio';
import RadioGroup from '@elementor/ui/RadioGroup';
import { styled } from '@elementor/ui/styles';
import Button from '@elementor/ui/Button';
import { __ } from '@wordpress/i18n';
import { MoodEmpty, MoodHappy, MoodSad, MoodSadSquint, MoodSmile } from '../icons';
import { useSettings } from '../hooks/use-settings';

const RatingForm = ( { close, handleSubmitForm } ) => {
	const {
		rating,
		setRating,
		setCurrentPage,
		nextButtonDisabled,
		setNextButtonDisabled,
	} = useSettings();

	const ratingsMap = [
		{ value: '5', label: __( 'Excellent', 'image-optimization' ), icon: <MoodHappy /> },
		{ value: '4', label: __( 'Pretty good', 'image-optimization' ), icon: <MoodSmile /> },
		{ value: '3', label: __( "It's okay", 'image-optimization' ), icon: <MoodEmpty /> },
		{ value: '2', label: __( 'Could be better', 'image-optimization' ), icon: <MoodSadSquint /> },
		{ value: '1', label: __( 'Needs improvement', 'image-optimization' ), icon: <MoodSad /> },
	];

	const handleRatingChange = ( value ) => {
		setRating( value );
		setNextButtonDisabled( false );
	};

	const handleNextButton = async () => {
		if ( parseInt( rating ) < 4 ) {
			setCurrentPage( 'feedback' );
		} else {
			const submitted = await handleSubmitForm( close, true );

			if ( submitted ) {
				setCurrentPage( 'review' );
			}
		}
	};

	return (
		<FormControl fullWidth>
			<RadioGroup
				aria-labelledby="Image Optimizer feedback form"
				onChange={ ( event, value ) => handleRatingChange( value ) }
				name="radio-buttons-group"
			>
				{ ratingsMap.map( ( { value, label, icon } ) => {
					return (
						<ListItem key={ 'item-' + value } disableGutters disablePadding>
							<ListItemIcon>{ icon }</ListItemIcon>
							<StyledFormControlLabel
								control={ <Radio color="secondary" /> }
								label={ label }
								value={ value }
								labelPlacement="start" />
						</ListItem>
					);
				} ) }
			</RadioGroup>
			<Button
				color="primary"
				variant="contained"
				onClick={ handleNextButton }
				disabled={ nextButtonDisabled }
			>
				{ __( 'Next', 'image-optimization' ) }
			</Button>
		</FormControl>
	);
};

export default RatingForm;

const StyledFormControlLabel = styled( FormControlLabel )`
	justify-content: space-between;
	margin-left: 0;
	width: 100%;
`;
