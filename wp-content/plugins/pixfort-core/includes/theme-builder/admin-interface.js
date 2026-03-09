/**
 * Theme Builder Admin Interface Scripts
 */

(function($) {
    'use strict';
    
    /**
     * Modify Add New button and handle menu highlighting
     */
    function initThemeBuilderMenu() {
        if (typeof pixThemeBuilderAdmin === 'undefined') {
            return;
        }

        // Modify the "Add New" button if it exists
        var addNewBtn = document.querySelector(".page-title-action");
        if (addNewBtn && pixThemeBuilderAdmin.addNewUrl) {
            addNewBtn.href = pixThemeBuilderAdmin.addNewUrl;
            // Add plus icon
            var plusIcon = document.createElement("span");
            plusIcon.className = "dashicons dashicons-plus-alt2";
            plusIcon.style.cssText = "font-size: 16px; width: 16px; height: 16px; margin-right: 4px;";
            addNewBtn.insertBefore(plusIcon, addNewBtn.firstChild);
            
            // Add flexbox styling to the button
            addNewBtn.style.cssText += "display: inline-flex; align-items: center; justify-content: center;";
        }
        
        // Force the Theme Builder menu to be open
        // First, find the Theme Builder menu item
        var menuItems = document.querySelectorAll("#adminmenu > li");
        var themeBuilderItem = null;
        
        for (var i = 0; i < menuItems.length; i++) {
            var link = menuItems[i].querySelector("a");
            if (link && link.href && link.href.includes("edit.php?post_type=pixheader")) {
                themeBuilderItem = menuItems[i];
                break;
            }
        }
        
        // If we found the menu item, make sure it's open
        if (themeBuilderItem) {
            // Add the "wp-has-current-submenu" class to open the menu
            themeBuilderItem.classList.remove("wp-not-current-submenu");
            themeBuilderItem.classList.add("wp-has-current-submenu");
            themeBuilderItem.classList.add("wp-menu-open");
            
            // Find the link and update its class as well
            var themeBuilderLink = themeBuilderItem.querySelector("a");
            if (themeBuilderLink) {
                themeBuilderLink.classList.remove("wp-not-current-submenu");
                themeBuilderLink.classList.add("wp-has-current-submenu");
                themeBuilderLink.classList.add("wp-menu-open");
            }
            
            // Find the submenu item for the current post type and highlight it
            var subMenuItems = themeBuilderItem.querySelectorAll(".wp-submenu li");
            var currentPostType = pixThemeBuilderAdmin.postType;
            
            for (var j = 0; j < subMenuItems.length; j++) {
                var subLink = subMenuItems[j].querySelector("a");
                let isActiveTemplateLink = false;
                if(subLink&&subLink.href) {
                    if(subLink.href.includes("pixfort_template")) {
                        if(pixThemeBuilderAdmin.templateType) {
                        let searchString = "pixfort_template_type=" + pixThemeBuilderAdmin.templateType;
                            if(subLink.href.includes(searchString)) {
                                isActiveTemplateLink = true;
                            }
                        }
                    } else {
                        isActiveTemplateLink = true;
                    }
                }
                
                if (subLink && subLink.href && subLink.href.includes("post_type=" + currentPostType) && isActiveTemplateLink) {
                    subMenuItems[j].classList.add("current");
                    subLink.classList.add("current");
                    subLink.setAttribute("aria-current", "page");
                } else {
                    subMenuItems[j].classList.remove("current");
                    if (subLink) {
                        subLink.classList.remove("current");
                        subLink.removeAttribute("aria-current");
                    }
                }
            }
        }
    }

    /**
     * Initialize admin pointer for Theme Builder menu
     */
    function initThemeBuilderPointer() {
        if (typeof pixThemeBuilderPointer === 'undefined' || !pixThemeBuilderPointer.enabled) {
            return;
        }

        // Find the Theme Builder menu item
        var themeBuilderMenuItem = $('#adminmenu a.menu-top').filter(function() {
            return this.href.indexOf('edit.php?post_type=pixheader') > -1;
        });
        
        // If we found the menu item, attach the pointer
        if (themeBuilderMenuItem.length) {
            themeBuilderMenuItem.pointer({
                content: pixThemeBuilderPointer.content,
                position: {
                    edge: 'left',
                    align: 'center'
                },
                close: function() {
                    // Send AJAX request to mark pointer as dismissed
                    $.post(ajaxurl, {
                        action: 'dismiss-wp-pointer',
                        pointer: pixThemeBuilderPointer.pointerId
                    });
                }
            }).pointer('open');
        }
    }

    // Initialize on DOM ready
    document.addEventListener("DOMContentLoaded", function() {
        initThemeBuilderMenu();
    });

    // Initialize pointer on jQuery ready (requires jQuery and wp-pointer)
    $(document).ready(function() {
        initThemeBuilderPointer();
    });

})(jQuery);

