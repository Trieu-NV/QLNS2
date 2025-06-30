<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Test Logout</h4>
                    </div>
                    <div class="card-body">
                        <p>Current cookies:</p>
                        <ul>
                            <li>Username: <span id="username-cookie"></span></li>
                            <li>User Type: <span id="usertype-cookie"></span></li>
                        </ul>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('logout') }}" class="btn btn-primary">Normal Logout (POST)</a>
                            <a href="{{ route('test.logout') }}" class="btn btn-warning">Test Logout (GET)</a>
                            <a href="{{ route('logout.alt') }}" class="btn btn-info">Alternative Logout</a>
                            <a href="{{ route('logout.final') }}" class="btn btn-danger">Final Logout</a>
                            <button onclick="clearCookiesJS()" class="btn btn-secondary">Clear Cookies (JS)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return 'Not found';
        }
        
        function updateCookieDisplay() {
            document.getElementById('username-cookie').textContent = getCookie('username');
            document.getElementById('usertype-cookie').textContent = getCookie('user_type');
        }
        
        function clearCookiesJS() {
            document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "user_type=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            updateCookieDisplay();
            alert('Cookies cleared via JavaScript!');
        }
        
        // Update display on page load
        updateCookieDisplay();
    </script>
</body>
</html> 