$baseUrl = 'http://127.0.0.1:8001'
$loginUrl = "$baseUrl/login"
$materiUrl = "$baseUrl/kelola-materi"

# Step 1: Get login page + CSRF
$response = Invoke-WebRequest -Uri $loginUrl -SessionVariable 'session' -UseBasicParsing
$csrfToken = if ($response.Content -match 'name="csrf-token" content="([^"]+)"') { $matches[1] } else { '' }
$cookies = $session.Cookies.GetCookies($loginUrl)

Write-Output "Step 1: Got CSRF=$csrfToken"

# Step 2: POST login with explicit cookie handling
$loginData = @{
    email = 'siti.nurhaliza@sekolah.sch.id'
    password = 'password123'
    _token = $csrfToken
}

try {
    $loginResp = Invoke-WebRequest -Uri $loginUrl -Method POST -Body $loginData -WebSession $session -UseBasicParsing -MaximumRedirection 5
    Write-Output "Step 2: Login response status=$($loginResp.StatusCode)"
} catch {
    Write-Output "Step 2: Login threw error (expected redirect)"
}

# Get updated CSRF from authenticated page
$indexResp = Invoke-WebRequest -Uri $materiUrl -WebSession $session -UseBasicParsing
Write-Output "Step 3: Got kelola-materi status=$($indexResp.StatusCode)"

# Extract CSRF from authenticated page
$newCsrf = if ($indexResp.Content -match 'name="csrf-token" content="([^"]+)"') { $matches[1] } else { '' }
Write-Output "Step 4: New CSRF=$newCsrf"

# Check if we're authenticated by looking for specific content
if ($indexResp.Content -match 'Kelola Materi Belajar') {
    Write-Output "AUTHENTICATED: Found page title"
    
    # Test CREATE with form data (not JSON)
    $createData = @{
        _token = $newCsrf
        judul = "PHP Backend"
        level = "Lanjutan"
        deskripsi = "Belajar PHP server-side programming"
        estimasi_waktu = "180"
        id_materi = "MAT-PHP-001"
        kategori = "JS Dasar"
        konten = "Konten materi PHP backend dengan OOP"
        tingkat_kesulitan = "3"
    }
    
    try {
        $createResp = Invoke-WebRequest -Uri $materiUrl -Method POST -Body $createData -WebSession $session -UseBasicParsing -MaximumRedirection 10
        Write-Output "Step 5: CREATE status=$($createResp.StatusCode)"
        Write-Output "Response length: $($createResp.Content.Length)"
    } catch {
        Write-Output "Step 5: CREATE error: $($_.Exception.Message)"
    }
} else {
    Write-Output "NOT AUTHENTICATED"
    Write-Output "Page content sample: $($indexResp.Content.Substring(0, 500))"
}
