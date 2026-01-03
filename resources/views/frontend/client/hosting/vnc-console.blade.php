<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VNC Console - {{ $service->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #1a1a1a;
            overflow: hidden;
            font-family: system-ui, -apple-system, sans-serif;
        }
        #console-container {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #toolbar {
            background: #2d2d2d;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #3d3d3d;
            color: #fff;
            flex-shrink: 0;
        }
        #toolbar .title {
            font-weight: 600;
            flex: 1;
        }
        #toolbar .status {
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        #toolbar .status.connecting {
            background: #fbbf24;
            color: #000;
        }
        #toolbar .status.connected {
            background: #10b981;
            color: #fff;
        }
        #toolbar .status.disconnected {
            background: #ef4444;
            color: #fff;
        }
        #screen {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            position: relative;
            overflow: hidden;
        }
        #loading {
            color: #fff;
            text-align: center;
            position: absolute;
            z-index: 10;
        }
        #loading .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #3d3d3d;
            border-top-color: #8b5cf6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        #error {
            display: none;
            color: #ef4444;
            text-align: center;
            padding: 20px;
            position: absolute;
            z-index: 10;
        }
        #error h2 {
            margin-bottom: 10px;
        }
        #vnc-canvas {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="console-container">
        <div id="toolbar">
            <div class="title">{{ $service->name }} - VNC Console</div>
            <div id="status" class="status connecting">Connecting...</div>
        </div>
        <div id="screen">
            <div id="loading">
                <div class="spinner"></div>
                <div>Connecting to console...</div>
            </div>
            <div id="error">
                <h2>Connection Failed</h2>
                <p id="error-message"></p>
            </div>
            <div id="vnc-canvas"></div>
        </div>
    </div>

    <script type="module">
        import RFB from '/vendor/novnc/noVNC-1.4.0/core/rfb.js';
        
        const consoleUrl = '{{ $consoleUrl }}';
        const password = '{{ $password }}';
        
        console.log('Console URL:', consoleUrl);
        console.log('Password:', password ? 'Present' : 'Missing');
        
        const statusEl = document.getElementById('status');
        const loadingEl = document.getElementById('loading');
        const errorEl = document.getElementById('error');
        const screenEl = document.getElementById('vnc-canvas');
        
        try {
            console.log('Creating RFB connection...');
            
            // Create RFB object
            const rfb = new RFB(screenEl, consoleUrl, {
                credentials: { password: password }
            });
            
            // Handle connection events
            rfb.addEventListener("connect", function() {
                console.log('Connected successfully');
                statusEl.textContent = 'Connected';
                statusEl.className = 'status connected';
                loadingEl.style.display = 'none';
            });
            
            rfb.addEventListener("disconnect", function(e) {
                console.log('Disconnected:', e.detail);
                statusEl.textContent = 'Disconnected';
                statusEl.className = 'status disconnected';
                loadingEl.style.display = 'none';
                
                if (!e.detail.clean) {
                    errorEl.style.display = 'block';
                    document.getElementById('error-message').textContent = 'Connection lost: ' + (e.detail.reason || 'Unknown reason');
                }
            });
            
            rfb.addEventListener("securityfailure", function(e) {
                console.error('Security failure:', e.detail);
                statusEl.textContent = 'Authentication Failed';
                statusEl.className = 'status disconnected';
                loadingEl.style.display = 'none';
                errorEl.style.display = 'block';
                document.getElementById('error-message').textContent = 'Authentication failed: ' + e.detail.reason;
            });
            
            // Set quality and compression
            rfb.qualityLevel = 6;
            rfb.compressionLevel = 2;
            
            // Scale viewport
            rfb.scaleViewport = true;
            rfb.resizeSession = false;
            
        } catch (err) {
            console.error('Failed to connect:', err);
            statusEl.textContent = 'Connection Failed';
            statusEl.className = 'status disconnected';
            loadingEl.style.display = 'none';
            errorEl.style.display = 'block';
            document.getElementById('error-message').textContent = err.message;
        }
    </script>
</body>
</html>
