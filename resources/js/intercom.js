import Intercom from '@intercom/messenger-js-sdk';

// Get Intercom config from Laravel (passed via meta tag or data attribute)
function getIntercomConfig() {
    const configElement = document.getElementById('intercom-config');
    if (configElement) {
        try {
            return JSON.parse(configElement.textContent);
        } catch (e) {
            console.error('Failed to parse Intercom config:', e);
        }
    }
    // Fallback to default
    return {
        app_id: 'i848b5ou',
        enabled: true
    };
}

// Initialize Intercom
export function initIntercom(user = null) {
    const intercomConfig = getIntercomConfig();
    
    // Don't initialize if disabled
    if (!intercomConfig.enabled) {
        console.log('Intercom is disabled');
        return;
    }
    
    const config = {
        app_id: intercomConfig.app_id,
    };

    // Add messenger settings
    if (intercomConfig.alignment) {
        config.alignment = intercomConfig.alignment;
    }
    if (intercomConfig.horizontal_padding) {
        config.horizontal_padding = intercomConfig.horizontal_padding;
    }
    if (intercomConfig.vertical_padding) {
        config.vertical_padding = intercomConfig.vertical_padding;
    }
    if (intercomConfig.hide_default_launcher) {
        config.hide_default_launcher = intercomConfig.hide_default_launcher;
    }

    // If user is logged in, add user data
    if (user) {
        config.user_id = user.user_id || user.id;
        config.name = user.name;
        config.email = user.email;
        
        // Add user_hash for identity verification
        if (user.user_hash && intercomConfig.identity_verification) {
            config.user_hash = user.user_hash;
        }
        
        // Convert created_at to Unix timestamp if needed
        if (user.created_at) {
            // If already a number, use it directly
            if (typeof user.created_at === 'number') {
                config.created_at = user.created_at;
            } else {
                // Otherwise convert from date string
                const createdDate = new Date(user.created_at);
                config.created_at = Math.floor(createdDate.getTime() / 1000);
            }
        }
    }

    Intercom(config);
}

// Update Intercom when user logs in
export function updateIntercomUser(user) {
    if (window.Intercom) {
        const updateData = {
            user_id: user.user_id || user.id,
            name: user.name,
            email: user.email,
        };
        
        // Add user_hash if available
        if (user.user_hash) {
            updateData.user_hash = user.user_hash;
        }
        
        // Add created_at if available
        if (user.created_at) {
            updateData.created_at = typeof user.created_at === 'number' 
                ? user.created_at 
                : Math.floor(new Date(user.created_at).getTime() / 1000);
        }
        
        window.Intercom('update', updateData);
    }
}

// Show Intercom messenger
export function showIntercom() {
    if (window.Intercom) {
        window.Intercom('show');
    }
}

// Hide Intercom messenger
export function hideIntercom() {
    if (window.Intercom) {
        window.Intercom('hide');
    }
}

// Shutdown Intercom (on logout)
export function shutdownIntercom() {
    if (window.Intercom) {
        window.Intercom('shutdown');
    }
}
