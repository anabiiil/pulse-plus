<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>File Upload</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2em;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
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
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="file"],
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input[type="file"]:focus,
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .image-options, .file-options {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .image-options h3, .file-options h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.1em;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .file-info {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .file-info h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .info-item {
            background: white;
            padding: 12px;
            border-radius: 6px;
        }

        .info-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 14px;
            color: #333;
            font-weight: 600;
            word-break: break-all;
        }

        .preview-image {
            max-width: 100%;
            margin-top: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        small {
            color: #888;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📁 File Upload System</h1>

        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="file">Choose File *</label>
                <input type="file" name="file" id="file" required>
                <small>Maximum file size: 50MB</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="directory">Directory</label>
                    <input type="text" name="directory" id="directory" placeholder="e.g., uploads/documents">
                    <small>Leave empty for default (images/files)</small>
                </div>

                <div class="form-group">
                    <label for="custom_filename">Custom Filename</label>
                    <input type="text" name="custom_filename" id="custom_filename" placeholder="my-file">
                    <small>Without extension</small>
                </div>
            </div>

            <div class="form-group">
                <label for="disk">Storage Disk</label>
                <select name="disk" id="disk">
                    <option value="public">Public</option>
                    <option value="local">Local</option>
                    <option value="s3">S3 (if configured)</option>
                </select>
            </div>

            <div class="image-options">
                <h3>🖼️ Image Options (for image files only)</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="quality">Quality (1-100)</label>
                        <input type="number" name="quality" id="quality" min="1" max="100" placeholder="85">
                        <small>Higher = better quality, larger size</small>
                    </div>

                    <div class="form-group">
                        <label for="format">Convert Format</label>
                        <select name="format" id="format">
                            <option value="">Keep original</option>
                            <option value="webp">WebP</option>
                            <option value="png">PNG</option>
                            <option value="jpg">JPG</option>
                            <option value="jpeg">JPEG</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="file-options">
                <h3>📄 File Options (for non-image files)</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="max_size">Max Size (MB)</label>
                        <input type="number" name="max_size" id="max_size" min="1" max="100" placeholder="10">
                        <small>Maximum allowed file size</small>
                    </div>

                    <div class="form-group">
                        <label for="allowed_extensions">Allowed Extensions</label>
                        <input type="text" name="allowed_extensions" id="allowed_extensions" placeholder="pdf,doc,docx">
                        <small>Comma separated (leave empty to allow all)</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                🚀 Upload File
            </button>
        </form>

        @if(session('fileInfo'))
            <div class="file-info">
                <h3>📊 File Information</h3>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Type</div>
                        <div class="info-value">{{ session('fileInfo')['type'] ?? 'Unknown' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Filename</div>
                        <div class="info-value">{{ session('fileInfo')['filename'] }}</div>
                    </div>

                    @if(isset(session('fileInfo')['stored_name']))
                    <div class="info-item">
                        <div class="info-label">Stored Name</div>
                        <div class="info-value">{{ session('fileInfo')['stored_name'] }}</div>
                    </div>
                    @endif

                    <div class="info-item">
                        <div class="info-label">Size</div>
                        <div class="info-value">{{ session('fileInfo')['size'] }} MB</div>
                    </div>

                    @if(isset(session('fileInfo')['format']))
                    <div class="info-item">
                        <div class="info-label">Format</div>
                        <div class="info-value">{{ strtoupper(session('fileInfo')['format']) }}</div>
                    </div>
                    @endif

                    @if(isset(session('fileInfo')['extension']))
                    <div class="info-item">
                        <div class="info-label">Extension</div>
                        <div class="info-value">{{ strtoupper(session('fileInfo')['extension']) }}</div>
                    </div>
                    @endif

                    <div class="info-item">
                        <div class="info-label">MIME Type</div>
                        <div class="info-value">{{ session('fileInfo')['mime_type'] }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Path</div>
                        <div class="info-value">{{ session('fileInfo')['path'] }}</div>
                    </div>
                </div>

                @if(session('fileInfo')['type'] === 'image')
                    <div style="margin-top: 20px;">
                        <div class="info-label">Preview</div>
                        <img src="{{ session('fileInfo')['url'] }}" alt="Uploaded image" class="preview-image">
                    </div>
                @endif

                @if(isset(session('fileInfo')['url']))
                    <div style="margin-top: 15px;">
                        <a href="{{ session('fileInfo')['url'] }}" target="_blank" style="color: #667eea; text-decoration: none; font-weight: 600;">
                            🔗 View/Download File
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</body>
</html>

