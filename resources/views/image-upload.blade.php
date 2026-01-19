<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Test</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .content {
            padding: 30px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }

        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px dashed #667eea;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        input[type="file"]:hover {
            border-color: #764ba2;
            background: #f8f9fa;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .image-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .image-info h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 18px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            color: #333;
        }

        .preview-image {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #e0e0e0;
        }

        .helper-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🖼️ Image Upload Test</h1>
            <p>Test ImageProcessor class with different formats and quality settings</p>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    ✗ {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <strong>Validation Errors:</strong>
                    <ul style="margin-top: 10px; margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="image">Select Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                    <p class="helper-text">Supported formats: JPEG, PNG, GIF, WebP (Max: 10MB)</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="format">Output Format</label>
                        <select id="format" name="format">
                            <option value="webp" selected>WebP (Recommended)</option>
                            <option value="jpg">JPEG</option>
                            <option value="png">PNG</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quality">Quality (1-100)</label>
                        <input type="number" id="quality" name="quality" value="85" min="1" max="100">
                        <p class="helper-text">Higher = Better quality, Larger file</p>
                    </div>
                </div>

                <button type="submit">🚀 Upload & Process Image</button>
            </form>

            @if(session('imageInfo'))
                <div class="image-info">
                    <h3>📊 Upload Details</h3>

                    <div class="info-row">
                        <span class="info-label">Path:</span>
                        <span class="info-value">{{ session('imageInfo')['path'] }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Original Filename:</span>
                        <span class="info-value">{{ session('imageInfo')['filename'] }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Size:</span>
                        <span class="info-value">{{ session('imageInfo')['size'] }} MB</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Format:</span>
                        <span class="info-value">{{ strtoupper(session('imageInfo')['format']) }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">MIME Type:</span>
                        <span class="info-value">{{ session('imageInfo')['mime_type'] }}</span>
                    </div>

                    <img src="{{ session('imageInfo')['url'] }}" alt="Uploaded Image" class="preview-image">
                </div>
            @endif
        </div>
    </div>

    <script>
        // Preview file name when selected
        document.getElementById('image').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                console.log('Selected file:', e.target.files[0].name);
            }
        });
    </script>
</body>
</html>

