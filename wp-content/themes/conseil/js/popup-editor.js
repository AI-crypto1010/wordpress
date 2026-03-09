window.dispatchEvent(new Event('resize'));
$(document).ready(function($) {
    window.dispatchEvent(new Event('resize'));
    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 1000);
});
