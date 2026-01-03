<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Email Check API</title>
</head>
<body>
    <h1>Test Email Check API</h1>
    
    <input type="email" id="test-email" value="ahmed.y@progineous.com" style="width: 300px; padding: 10px;">
    <button onclick="testEmail()" style="padding: 10px 20px;">Check Email</button>
    
    <div id="result" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;"></div>
    
    <script>
        async function testEmail() {
            const email = document.getElementById('test-email').value;
            const resultDiv = document.getElementById('result');
            
            resultDiv.innerHTML = 'Checking...';
            
            try {
                const response = await fetch('{{ route("api.check-email") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const data = await response.json();
                
                resultDiv.innerHTML = `
                    <h3>Response:</h3>
                    <pre>${JSON.stringify(data, null, 2)}</pre>
                    <p><strong>Available:</strong> ${data.available ? 'YES' : 'NO'}</p>
                `;
            } catch (error) {
                resultDiv.innerHTML = `<p style="color: red;">Error: ${error.message}</p>`;
                console.error('Error:', error);
            }
        }
        
        // Auto-run on page load
        window.onload = function() {
            testEmail();
        };
    </script>
</body>
</html>
