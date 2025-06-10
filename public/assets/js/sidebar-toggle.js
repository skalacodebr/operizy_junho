/**
 * Advanced Sidebar Toggle System
 * Features: Desktop/Mobile responsive, localStorage, animations, tooltips, accessibility
 */

class SidebarToggle {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.restoreUserPreference();
        this.addTooltips();
        this.handleResize();
        this.setupKeyboardNavigation();
        this.addMobileOverlay();
    }

    setupEventListeners() {
        // Desktop toggle button
        const desktopToggle = document.getElementById('sidebar-toggle');
        if (desktopToggle) {
            desktopToggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleSidebar();
            });
        }

        // Mobile hamburger button
        const mobileToggle = document.getElementById('mobile-collapse');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleMobileSidebar();
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + B to toggle sidebar
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                if (window.innerWidth >= 992) {
                    this.toggleSidebar();
                } else {
                    this.toggleMobileSidebar();
                }
            }

            // ESC to close mobile sidebar
            if (e.key === 'Escape' && window.innerWidth < 992) {
                this.closeMobileSidebar();
            }
        });

        // Window resize handler
        window.addEventListener('resize', () => {
            this.handleResize();
        });

        // Click outside to close mobile sidebar
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 992) {
                const sidebar = document.querySelector('.dash-sidebar');
                const toggleBtn = document.getElementById('mobile-collapse');
                
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && 
                    document.body.classList.contains('sidebar-open')) {
                    this.closeMobileSidebar();
                }
            }
        });
    }

    toggleSidebar() {
        const body = document.body;
        const isCollapsed = body.classList.contains('sidebar-collapsed');
        
        // Add loading state
        body.classList.add('sidebar-loading');
        
        setTimeout(() => {
            if (isCollapsed) {
                this.expandSidebar();
            } else {
                this.collapseSidebar();
            }
            
            // Remove loading state
            setTimeout(() => {
                body.classList.remove('sidebar-loading');
            }, 300);
        }, 50);
    }

    collapseSidebar() {
        document.body.classList.add('sidebar-collapsed');
        this.saveUserPreference('collapsed');
        this.updateToggleIcon('collapsed');
        this.addTooltips();
        
        // Announce to screen readers
        this.announceToScreenReader('Sidebar collapsed');
        
        // Trigger custom event
        this.dispatchCustomEvent('sidebarCollapsed');
    }

    expandSidebar() {
        document.body.classList.remove('sidebar-collapsed');
        this.saveUserPreference('expanded');
        this.updateToggleIcon('expanded');
        this.removeTooltips();
        
        // Announce to screen readers
        this.announceToScreenReader('Sidebar expanded');
        
        // Trigger custom event
        this.dispatchCustomEvent('sidebarExpanded');
    }

    toggleMobileSidebar() {
        const body = document.body;
        const isOpen = body.classList.contains('sidebar-open');
        
        if (isOpen) {
            this.closeMobileSidebar();
        } else {
            this.openMobileSidebar();
        }
    }

    openMobileSidebar() {
        document.body.classList.add('sidebar-open');
        this.trapFocus();
        
        // Announce to screen readers
        this.announceToScreenReader('Navigation menu opened');
        
        // Trigger custom event
        this.dispatchCustomEvent('mobileSidebarOpened');
    }

    closeMobileSidebar() {
        document.body.classList.remove('sidebar-open');
        this.releaseFocus();
        
        // Announce to screen readers
        this.announceToScreenReader('Navigation menu closed');
        
        // Trigger custom event
        this.dispatchCustomEvent('mobileSidebarClosed');
    }

    updateToggleIcon(state) {
        const icon = document.querySelector('.sidebar-toggle-icon');
        if (!icon) return;

        if (state === 'collapsed') {
            icon.className = 'ti ti-menu-2 sidebar-toggle-icon';
            icon.parentElement.setAttribute('title', 'Expand Sidebar');
        } else {
            icon.className = 'ti ti-x sidebar-toggle-icon';
            icon.parentElement.setAttribute('title', 'Collapse Sidebar');
        }
    }

    addTooltips() {
        if (window.innerWidth >= 992 && document.body.classList.contains('sidebar-collapsed')) {
            const menuItems = document.querySelectorAll('.dash-sidebar .dash-link');
            
            menuItems.forEach(item => {
                const textElement = item.querySelector('.dash-mtext');
                if (textElement) {
                    const text = textElement.textContent.trim();
                    item.setAttribute('data-title', text);
                    item.setAttribute('aria-label', text);
                }
            });
        }
    }

    removeTooltips() {
        const menuItems = document.querySelectorAll('.dash-sidebar .dash-link');
        menuItems.forEach(item => {
            item.removeAttribute('data-title');
            item.removeAttribute('aria-label');
        });
    }

    saveUserPreference(state) {
        try {
            localStorage.setItem('sidebar-state', state);
        } catch (e) {
            console.warn('Could not save sidebar preference to localStorage:', e);
        }
    }

    restoreUserPreference() {
        try {
            const savedState = localStorage.getItem('sidebar-state');
            const isDesktop = window.innerWidth >= 992;
            
            if (isDesktop && savedState === 'collapsed') {
                this.collapseSidebar();
            } else if (isDesktop) {
                this.expandSidebar();
            }
        } catch (e) {
            console.warn('Could not restore sidebar preference from localStorage:', e);
        }
    }

    handleResize() {
        const isDesktop = window.innerWidth >= 992;
        const isMobile = window.innerWidth < 992;
        
        if (isDesktop) {
            // Close mobile sidebar if open
            document.body.classList.remove('sidebar-open');
            
            // Restore desktop state
            this.restoreUserPreference();
        } else if (isMobile) {
            // Remove collapsed state on mobile
            document.body.classList.remove('sidebar-collapsed');
            this.removeTooltips();
        }
    }

    addMobileOverlay() {
        // Create overlay for mobile
        if (!document.querySelector('.sidebar-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.addEventListener('click', () => {
                this.closeMobileSidebar();
            });
            document.body.appendChild(overlay);
        }
    }

    setupKeyboardNavigation() {
        // Enhanced keyboard navigation for sidebar
        const sidebarLinks = document.querySelectorAll('.dash-sidebar .dash-link');
        
        sidebarLinks.forEach((link, index) => {
            link.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const nextLink = sidebarLinks[index + 1];
                    if (nextLink) nextLink.focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prevLink = sidebarLinks[index - 1];
                    if (prevLink) prevLink.focus();
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    sidebarLinks[0].focus();
                } else if (e.key === 'End') {
                    e.preventDefault();
                    sidebarLinks[sidebarLinks.length - 1].focus();
                }
            });
        });
    }

    trapFocus() {
        // Trap focus within sidebar when mobile menu is open
        const sidebar = document.querySelector('.dash-sidebar');
        const focusableElements = sidebar.querySelectorAll(
            'a, button, [tabindex]:not([tabindex="-1"])'
        );
        
        if (focusableElements.length === 0) return;
        
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        
        this.focusTrapHandler = (e) => {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        };
        
        document.addEventListener('keydown', this.focusTrapHandler);
        firstElement.focus();
    }

    releaseFocus() {
        if (this.focusTrapHandler) {
            document.removeEventListener('keydown', this.focusTrapHandler);
            this.focusTrapHandler = null;
        }
    }

    announceToScreenReader(message) {
        // Create live region for screen reader announcements
        let liveRegion = document.getElementById('sidebar-announcements');
        
        if (!liveRegion) {
            liveRegion = document.createElement('div');
            liveRegion.id = 'sidebar-announcements';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.style.position = 'absolute';
            liveRegion.style.left = '-10000px';
            liveRegion.style.width = '1px';
            liveRegion.style.height = '1px';
            liveRegion.style.overflow = 'hidden';
            document.body.appendChild(liveRegion);
        }
        
        liveRegion.textContent = message;
    }

    dispatchCustomEvent(eventName) {
        const event = new CustomEvent(eventName, {
            bubbles: true,
            detail: {
                timestamp: Date.now(),
                sidebarState: this.getCurrentState()
            }
        });
        document.dispatchEvent(event);
    }

    getCurrentState() {
        const body = document.body;
        
        if (window.innerWidth < 992) {
            return body.classList.contains('sidebar-open') ? 'mobile-open' : 'mobile-closed';
        } else {
            return body.classList.contains('sidebar-collapsed') ? 'desktop-collapsed' : 'desktop-expanded';
        }
    }

    // Public API methods
    collapse() {
        if (window.innerWidth >= 992) {
            this.collapseSidebar();
        }
    }

    expand() {
        if (window.innerWidth >= 992) {
            this.expandSidebar();
        }
    }

    toggle() {
        if (window.innerWidth >= 992) {
            this.toggleSidebar();
        } else {
            this.toggleMobileSidebar();
        }
    }

    isCollapsed() {
        return document.body.classList.contains('sidebar-collapsed');
    }

    isMobileOpen() {
        return document.body.classList.contains('sidebar-open');
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Create global instance
    window.sidebarToggle = new SidebarToggle();
    
    // Enhanced submenu handling for collapsed state
    document.addEventListener('mouseenter', (e) => {
        if (e.target.closest('.dash-hasmenu') && 
            document.body.classList.contains('sidebar-collapsed') &&
            window.innerWidth >= 992) {
            
            const submenu = e.target.closest('.dash-hasmenu').querySelector('.dash-submenu');
            if (submenu) {
                const rect = e.target.closest('.dash-hasmenu').getBoundingClientRect();
                submenu.style.top = `${rect.top}px`;
            }
        }
    }, true);
    
    // Add smooth scroll to sidebar
    const sidebarContent = document.querySelector('.dash-sidebar .navbar-content');
    if (sidebarContent) {
        sidebarContent.style.scrollBehavior = 'smooth';
    }
    
    // Add performance monitoring
    if ('performance' in window) {
        window.addEventListener('load', () => {
            console.log('Sidebar Toggle System initialized successfully');
        });
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SidebarToggle;
} 