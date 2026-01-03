import './bootstrap';

// Alpine.js for interactive components
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

// Register Alpine plugins
Alpine.plugin(collapse);

window.Alpine = Alpine;
Alpine.start();

// Intercom Live Chat
import { initIntercom, updateIntercomUser, showIntercom, hideIntercom, shutdownIntercom } from './intercom';

// Make Intercom functions available globally
window.initIntercom = initIntercom;
window.updateIntercomUser = updateIntercomUser;
window.showIntercom = showIntercom;
window.hideIntercom = hideIntercom;
window.shutdownIntercom = shutdownIntercom;

// Initialize Intercom when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Check if user data is available in the page (from Laravel)
    const userDataElement = document.getElementById('user-data');
    let userData = null;
    
    if (userDataElement) {
        try {
            userData = JSON.parse(userDataElement.textContent);
        } catch (e) {
            console.error('Failed to parse user data:', e);
        }
    }
    
    // Initialize Intercom
    initIntercom(userData);
});
