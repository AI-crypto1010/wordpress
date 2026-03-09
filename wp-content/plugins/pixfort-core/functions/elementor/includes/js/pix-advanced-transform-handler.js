/**
 * Advanced Transform Handler for Elementor Editor
 * 
 * This handler manages real-time preview updates for the advanced transform
 * scroll effects inside the Elementor editor.
 */
class PixAdvancedTransformHandler extends elementorModules.frontend.handlers.Base {

    /**
     * Get default settings
     */
    getDefaultSettings() {
        return {
            selectors: {
                wrapper: '.elementor-element',
            },
        };
    }

    /**
     * Get default elements
     */
    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $wrapper: this.$element.find(selectors.wrapper),
        };
    }

    /**
     * Apply advanced transform effect
     */
    applyAdvancedTransform() {
        const settings = this.getElementSettings();

        let element = this.$element[0];
        if($(element).hasClass('elementor-widget')){
            if($(element).find('.pix-advanced-transform').length > 0){
                element = $(element).find('.pix-advanced-transform')[0];
            }
        }
        if(!element) return;

        // Only proceed if advanced transform is enabled
        if (settings.pix_scale_in !== 'pix-advanced-transform') {
            // Clean up if advanced transform is disabled
            const candidates = [];

            // If we previously resolved a different target element (e.g. widget inner wrapper),
            // clean it too so the effect is removed immediately.
            if (this._pixAdvancedTransformTargetElement &&
                jQuery.contains(document.documentElement, this._pixAdvancedTransformTargetElement)) {
                candidates.push(this._pixAdvancedTransformTargetElement);
            }

            if (jQuery.contains(document.documentElement, element)) {
                candidates.push(element);
            }

            const uniqueCandidates = new Set(candidates);
            uniqueCandidates.forEach((candidate) => {
                if (!candidate) return;

                // Cancel any existing Motion scroll observer for this element so the effect
                // stops immediately (no waiting for refresh).
                if (typeof candidate.__pixAdvancedTransformScrollCleanup === 'function') {
                    candidate.__pixAdvancedTransformScrollCleanup();
                    candidate.__pixAdvancedTransformScrollCleanup = null;
                }

                candidate.removeAttribute('data-pix-transform');
                // Remove the marker class so pix_section_stack won't consider it for advanced transform again.
                jQuery(candidate).removeClass('pix-loaded pix-advanced-transform');

                // Clear any inline styles applied by the effect.
                candidate.style.transform = '';
                candidate.style.opacity = '';

                // These are set by pix_section_stack() when initializing the effect.
                // Only clear if they match the effect defaults to avoid clobbering user-defined inline styles.
                if (candidate.style.zIndex === '1000') {
                    candidate.style.zIndex = '';
                }
                if (candidate.style.transformStyle === 'preserve-3d') {
                    candidate.style.transformStyle = '';
                }
            });

            this._pixAdvancedTransformTargetElement = null;
            return;
        }

        // Remember the actual element being controlled so we can clean it up even if Elementor
        // removes classes/markup before our onElementChange callback runs.
        this._pixAdvancedTransformTargetElement = element;
        
        // Check if we're in the editor
        if (!elementorFrontend.isEditMode()) {
            return;
        }
        
        // Build transform data
        const start = {};
        const end = {};

        // Get start values if popover is enabled
        if (settings.advanced_transform_start_popover === 'yes') {
            start.opacity = this.getSettingValue(settings, 'pix_transform_start_opacity', 1);
            start.scale = this.getSettingValue(settings, 'pix_transform_start_scale', 1);
            start.rotateType = settings.pix_transform_start_rotate_type || '2d';
            start.rotate2d = this.getSettingValue(settings, 'pix_transform_start_rotate_2d', 0);
            start.rotate3dX = this.getSettingValue(settings, 'pix_transform_start_rotate_3d_x', 0);
            start.rotate3dY = this.getSettingValue(settings, 'pix_transform_start_rotate_3d_y', 0);
            start.rotate3dZ = this.getSettingValue(settings, 'pix_transform_start_rotate_3d_z', 0);
            start.skewX = settings.pix_transform_start_skew_x || 0;
            start.skewY = settings.pix_transform_start_skew_y || 0;
            start.offsetX = settings.pix_transform_start_offset_x || 0;
            start.offsetY = settings.pix_transform_start_offset_y || 0;
        }

        // Get end values if popover is enabled
        if (settings.advanced_transform_end_popover === 'yes') {
            end.opacity = this.getSettingValue(settings, 'pix_transform_end_opacity', 1);
            end.scale = this.getSettingValue(settings, 'pix_transform_end_scale', 1);
            end.rotateType = settings.pix_transform_end_rotate_type || '2d';
            end.rotate2d = this.getSettingValue(settings, 'pix_transform_end_rotate_2d', 0);
            end.rotate3dX = this.getSettingValue(settings, 'pix_transform_end_rotate_3d_x', 0);
            end.rotate3dY = this.getSettingValue(settings, 'pix_transform_end_rotate_3d_y', 0);
            end.rotate3dZ = this.getSettingValue(settings, 'pix_transform_end_rotate_3d_z', 0);
            end.skewX = settings.pix_transform_end_skew_x || 0;
            end.skewY = settings.pix_transform_end_skew_y || 0;
            end.offsetX = settings.pix_transform_end_offset_x || 0;
            end.offsetY = settings.pix_transform_end_offset_y || 0;
        }

        // Store data for frontend use and reinitialize animation
        
        // Reset element inline styles
        element.style.transform = '';
        element.style.opacity = '';
        
        // Prevent multiple stacked scroll observers when settings change repeatedly in the editor.
        if (typeof element.__pixAdvancedTransformScrollCleanup === 'function') {
            element.__pixAdvancedTransformScrollCleanup();
            element.__pixAdvancedTransformScrollCleanup = null;
        }
        
        if (Object.keys(start).length > 0 || Object.keys(end).length > 0) {
            const transformData = { start, end };
            element.setAttribute('data-pix-transform', JSON.stringify(transformData));
            
            // Add pix-advanced-transform class and remove pix-loaded to allow re-initialization
            jQuery(element).addClass('pix-advanced-transform');
            jQuery(element).removeClass('pix-loaded');
            
            // pix_section_stack() re-scans the whole document; schedule a single coalesced run.
            PixAdvancedTransformHandler.scheduleSectionStackRun();
        } else {
            if (typeof element.__pixAdvancedTransformScrollCleanup === 'function') {
                element.__pixAdvancedTransformScrollCleanup();
                element.__pixAdvancedTransformScrollCleanup = null;
            }

            element.removeAttribute('data-pix-transform');
            jQuery(element).removeClass('pix-loaded pix-advanced-transform');

            element.style.transform = '';
            element.style.opacity = '';
            if (element.style.zIndex === '1000') {
                element.style.zIndex = '';
            }
            if (element.style.transformStyle === 'preserve-3d') {
                element.style.transformStyle = '';
            }
        }
    }

    /**
     * Get setting value (handle slider controls)
     */
    getSettingValue(settings, key, defaultValue) {
        const value = settings[key];
        if (value && typeof value === 'object' && value.size !== undefined) {
            return value.size;
        }
        return value !== undefined ? value : defaultValue;
    }

    /**
     * Debounced runner for pix_section_stack().
     *
     * Important: pix_section_stack() re-scans the whole document; calling it per-element
     * during large template imports causes long main-thread stalls in the editor.
     * We coalesce bursts into a single run.
     */
    static getSectionStackSchedulerState() {
        if (!window.pixAdvancedTransformSectionStackScheduler) {
            window.pixAdvancedTransformSectionStackScheduler = {
                timerId: null,
                rafId: null,
                inFlight: false,
                needsRun: false,
            };
        }

        return window.pixAdvancedTransformSectionStackScheduler;
    }

    static scheduleSectionStackRun(delayMs = 60) {
        const state = PixAdvancedTransformHandler.getSectionStackSchedulerState();
        state.needsRun = true;

        if (state.timerId !== null) {
            clearTimeout(state.timerId);
        }

        state.timerId = setTimeout(() => {
            state.timerId = null;
            PixAdvancedTransformHandler.runSectionStackIfNeeded();
        }, delayMs);
    }

    // Throttled/near-immediate scheduling (at most once per frame).
    static requestSectionStackRun() {
        const state = PixAdvancedTransformHandler.getSectionStackSchedulerState();
        state.needsRun = true;

        if (state.rafId !== null) {
            return;
        }

        state.rafId = requestAnimationFrame(() => {
            state.rafId = null;
            PixAdvancedTransformHandler.runSectionStackIfNeeded();
        });
    }

    static async runSectionStackIfNeeded() {
        const state = PixAdvancedTransformHandler.getSectionStackSchedulerState();

        if (state.inFlight || !state.needsRun) {
            return;
        }

        if (typeof window.pix_section_stack !== 'function') {
            // Keep needsRun true and try again shortly once the global is available.
            PixAdvancedTransformHandler.scheduleSectionStackRun(120);
            return;
        }

        // Avoid calling into pix_section_stack() if there is nothing new to initialize.
        const hasWork = !!document.querySelector(
            '.pix-advanced-transform:not(.pix-loaded), ' +
            '.pix-scale-in:not(.pix-loaded), ' +
            '.pix-scale-in-xs:not(.pix-loaded), ' +
            '.pix-scale-in-sm:not(.pix-loaded), ' +
            '.pix-scale-in-lg:not(.pix-loaded)'
        );

        if (!hasWork) {
            state.needsRun = false;
            return;
        }

        state.needsRun = false;
        state.inFlight = true;

        try {
            await window.pix_section_stack();
        } catch (e) {
            if (window.console && console.error) {
                console.error('pix_section_stack failed:', e);
            }
        } finally {
            state.inFlight = false;
            if (state.needsRun) {
                PixAdvancedTransformHandler.scheduleSectionStackRun(0);
            }
        }
    }

    /**
     * Shared queue state for nested reinitialization.
     * Batched processing avoids repeated deep traversals during large imports.
     */
    static getNestedReinitState() {
        if (!window.pixAdvancedTransformNestedReinitState) {
            window.pixAdvancedTransformNestedReinitState = {
                pendingRoots: new Set(),
                rafId: null,
            };
        }

        return window.pixAdvancedTransformNestedReinitState;
    }

    /**
     * Process all queued roots in one frame and deduplicate nested targets.
     */
    static flushNestedReinitializationQueue() {
        const state = PixAdvancedTransformHandler.getNestedReinitState();
        const pendingRoots = state.pendingRoots;

        state.rafId = null;

        if (!pendingRoots.size) {
            return;
        }

        const nestedTargets = new Set();

        pendingRoots.forEach((rootElement) => {
            if (!rootElement || !jQuery.contains(document.documentElement, rootElement)) {
                return;
            }

            const nestedElements = rootElement.querySelectorAll('.pix-advanced-transform');
            nestedElements.forEach((nestedElement) => {
                if (nestedElement && jQuery.contains(document.documentElement, nestedElement)) {
                    nestedTargets.add(nestedElement);
                }
            });
        });

        pendingRoots.clear();

        let didReset = false;
        nestedTargets.forEach((nestedElement) => {
            const $nestedElement = jQuery(nestedElement);

            if (typeof nestedElement.__pixAdvancedTransformScrollCleanup === 'function') {
                nestedElement.__pixAdvancedTransformScrollCleanup();
                nestedElement.__pixAdvancedTransformScrollCleanup = null;
            }

            $nestedElement.removeClass('pix-loaded');
            nestedElement.style.transform = '';
            nestedElement.style.opacity = '';
            didReset = true;
        });

        if (didReset) {
            PixAdvancedTransformHandler.scheduleSectionStackRun();
        }
    }

    /**
     * Queue a root element for batched nested reinitialization.
     */
    queueNestedReinitialization(rootElement) {
        if (!rootElement || !jQuery.contains(document.documentElement, rootElement)) {
            return;
        }

        const state = PixAdvancedTransformHandler.getNestedReinitState();
        const pendingRoots = state.pendingRoots;

        // Keep only highest relevant roots to avoid scanning nested trees repeatedly.
        for (const pendingRoot of pendingRoots) {
            if (!pendingRoot || !jQuery.contains(document.documentElement, pendingRoot)) {
                pendingRoots.delete(pendingRoot);
                continue;
            }

            if (pendingRoot === rootElement || pendingRoot.contains(rootElement)) {
                return;
            }

            if (rootElement.contains(pendingRoot)) {
                pendingRoots.delete(pendingRoot);
            }
        }

        pendingRoots.add(rootElement);

        if (state.rafId !== null) {
            return;
        }

        state.rafId = requestAnimationFrame(() => {
            PixAdvancedTransformHandler.flushNestedReinitializationQueue();
        });
    }

    /**
     * On Init
     */
    onInit() {
        super.onInit();
        this.applyAdvancedTransform();
    }
    
    /**
     * Bind events - called when element is bound/re-bound to DOM
     */
    bindEvents() {
        // Call parent bindEvents
        if (super.bindEvents) {
            super.bindEvents();
        }

        // bindEvents fires during initial binding too; nested reinit is only required on re-bind/rerender.
        if (!this._pixAdvancedTransformHasBoundOnce) {
            this._pixAdvancedTransformHasBoundOnce = true;
            return;
        }

        this.reinitializeNestedContainers();
    }

    /**
     * On Element Change
     * 
     * This is called whenever a control value changes in the editor
     */
    onElementChange(propertyName) {
        
        // List of all advanced transform related properties
        const advancedTransformProps = [
            'pix_scale_in',
            'advanced_transform_start_popover',
            'advanced_transform_end_popover',
            'pix_transform_start_opacity',
            'pix_transform_start_scale',
            'pix_transform_start_rotate_type',
            'pix_transform_start_rotate_2d',
            'pix_transform_start_rotate_3d_x',
            'pix_transform_start_rotate_3d_y',
            'pix_transform_start_rotate_3d_z',
            'pix_transform_start_skew_x',
            'pix_transform_start_skew_y',
            'pix_transform_start_offset_x',
            'pix_transform_start_offset_y',
            'pix_transform_end_opacity',
            'pix_transform_end_scale',
            'pix_transform_end_rotate_type',
            'pix_transform_end_rotate_2d',
            'pix_transform_end_rotate_3d_x',
            'pix_transform_end_rotate_3d_y',
            'pix_transform_end_rotate_3d_z',
            'pix_transform_end_skew_x',
            'pix_transform_end_skew_y',
            'pix_transform_end_offset_x',
            'pix_transform_end_offset_y',
        ];

        if (advancedTransformProps.includes(propertyName)) {
            this.applyAdvancedTransform();
            
            // After applying transform, re-initialize nested containers
            this.reinitializeNestedContainers();

            // Keep the editor feeling responsive while dragging controls.
            PixAdvancedTransformHandler.requestSectionStackRun();
        }
    }
    
    /**
     * Reinitialize nested containers with advanced transform
     * This is needed when parent container re-renders
     */
    reinitializeNestedContainers() {
        this.queueNestedReinitialization(this.$element[0]);
    }
}

/**
 * Register the handler when Elementor frontend is initialized
 */
jQuery(window).on('elementor/frontend/init', function() {

    
    window.pixAdvancedTransformFunction = function(element, animationProps) {
        if($(element).hasClass('elementor-widget')){
            const inner = $(element).find('.pix-advanced-transform')[0];
            if (inner) {
                element = inner;
            }
        }

        if (!element) {
            return function(){};
        }

        const $element = jQuery(element);
        const pixAnimationFunction = function(value, data) {
            // This callback can remain registered after control changes; keep it gated to the
            // advanced-transform state so it doesn't keep applying when other scroll effects
            // (like scale-in) re-add `pix-loaded`.
            if(!$element.hasClass('pix-loaded')) return;
            if(!$element.hasClass('pix-advanced-transform')) return;
            if(!element.getAttribute('data-pix-transform')) return;

            if(animationProps.opacity){
                const opacityStart = animationProps.opacity[0];
                const opacityEnd = animationProps.opacity[1];
                const opacity = opacityStart + (opacityEnd - opacityStart) * value;
                element.style.opacity = opacity;
            }

            let transform = '';
            if(animationProps.scale){
                const scaleStart = animationProps.scale[0];
                const scaleEnd = animationProps.scale[1];
                const scale = scaleStart + (scaleEnd - scaleStart) * value;
                transform += `scale(${scale})`;
            }
            if(animationProps.rotate){
                const rotateStart = animationProps.rotate[0];
                const rotateEnd = animationProps.rotate[1];
                const rotate = rotateStart + (rotateEnd - rotateStart) * value;
                transform += ` rotate(${rotate}deg)`;
            }
            if(animationProps.skewX){
                const skewXStart = animationProps.skewX[0];
                const skewXEnd = animationProps.skewX[1];
                const skewX = skewXStart + (skewXEnd - skewXStart) * value;
                transform += ` skewX(${skewX}deg)`;
            }
            if(animationProps.skewY){
                const skewYStart = animationProps.skewY[0];
                const skewYEnd = animationProps.skewY[1];
                const skewY = skewYStart + (skewYEnd - skewYStart) * value;
                transform += ` skewY(${skewY}deg)`;
            }
            if(animationProps.x){
                const xStart = animationProps.x[0];
                const xEnd = animationProps.x[1];
                const x = xStart + (xEnd - xStart) * value;
                transform += ` translateX(${x}px)`;
            }
            if(animationProps.y){
                const yStart = animationProps.y[0];
                const yEnd = animationProps.y[1];
                const y = yStart + (yEnd - yStart) * value;
                transform += ` translateY(${y}px)`;
            }
            if(animationProps.rotateX){
                const rotateXStart = animationProps.rotateX[0];
                const rotateXEnd = animationProps.rotateX[1];
                const rotateX = rotateXStart + (rotateXEnd - rotateXStart) * value;
                transform += ` rotateX(${rotateX}deg)`;
            }
            if(animationProps.rotateY){
                const rotateYStart = animationProps.rotateY[0];
                const rotateYEnd = animationProps.rotateY[1];
                const rotateY = rotateYStart + (rotateYEnd - rotateYStart) * value;
                transform += ` rotateY(${rotateY}deg)`;
            }
            if(animationProps.rotateZ){
                const rotateZStart = animationProps.rotateZ[0];
                const rotateZEnd = animationProps.rotateZ[1];
                const rotateZ = rotateZStart + (rotateZEnd - rotateZStart) * value;
                transform += ` rotateZ(${rotateZ}deg)`;
            }
            // build transform string
            element.style.transform = transform;
        }
        return pixAnimationFunction;
    }
    
    // Track which elements already have handlers - use WeakSet for automatic cleanup
    window.pixAdvancedTransformHandlerElements = window.pixAdvancedTransformHandlerElements || new Map();
    
    // Function to add handler to an element
    const addHandler = function($element) {
        if (!$element || !$element.length) return;
        
        const element = $element[0];
        const elementId = $element.attr('data-id') || $element.attr('id') || '';
        
        // Check if element already has a handler by checking if it's in the DOM and has a handler
        const existingElement = window.pixAdvancedTransformHandlerElements.get(elementId);
        
        // If the element is still in the DOM and has the same reference, don't add duplicate
        if (existingElement === element && jQuery.contains(document.documentElement, element)) {
            return;
        }
        
        // Element was re-rendered or is new, add/re-add handler
        window.pixAdvancedTransformHandlerElements.set(elementId, element);
        
        elementorFrontend.elementsHandler.addHandler(PixAdvancedTransformHandler, {
            $element: $element,
        });
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend !== null) {
        // Register for elements with .default suffix (standard Elementor format)
        // elementorFrontend.hooks.addAction('frontend/element_ready/section.default', addHandler);
        // elementorFrontend.hooks.addAction('frontend/element_ready/column.default', addHandler);
        // elementorFrontend.hooks.addAction('frontend/element_ready/container.default', addHandler);
        
        // Also register without .default suffix
        elementorFrontend.hooks.addAction('frontend/element_ready/section', addHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/column', addHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/container', addHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/pix-img.default', addHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/pix-auto-video.default', addHandler);
        
        // // Manually attach handlers to existing elements (for elements already loaded)
        // if (elementorFrontend.isEditMode()) {
            
        //     // Wait for editor to be fully loaded
        //     setTimeout(function() {
        //         // Attach to sections
        //         jQuery('.elementor-element.elementor-section').each(function() {
        //             addHandler(jQuery(this));
        //         });
                
        //         // Attach to containers (both old and new container classes)
        //         jQuery('.elementor-element.e-con, .elementor-element.e-container, .elementor-element[data-element_type="container"]').each(function() {
        //             addHandler(jQuery(this));
        //         });
                
        //         // Attach to columns
        //         jQuery('.elementor-element.elementor-column').each(function() {
        //             addHandler(jQuery(this));
        //         });
                
        //     }, 500);
        // }
    }
});
