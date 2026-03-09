class WidgetHandlerClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                firstSelector: '.alert',
                secondSelector: '.secondSelectorClass',
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $firstSelector: this.$element.find(selectors.firstSelector),
            $secondSelector: this.$element.find(selectors.secondSelector),
        };
    }

    bindEvents() {
        this.elements.$firstSelector.on(
            'click',
            this.onFirstSelectorClick.bind(this)
        );
    }

    onFirstSelectorClick(event) {
        event.preventDefault();
        this.elements.$secondSelector.show();
    }
}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        pix_animation($element);
        elementorFrontend.elementsHandler.addHandler(WidgetHandlerClass, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/pix-alert.default',
        addHandler
    );
});
