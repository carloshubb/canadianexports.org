<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template Preview</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }
        
        h1 {
            color: #1a202c;
            font-size: 32px;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            color: #718096;
            text-align: center;
            margin-bottom: 40px;
            font-size: 16px;
        }
        
        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 30px;
        }
        
        .template-card {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 24px;
            transition: all 0.3s ease;
        }
        
        .template-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }
        
        .template-card h3 {
            color: #2d3748;
            font-size: 20px;
            margin-bottom: 8px;
        }
        
        .template-card p {
            color: #718096;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        
        .template-card a {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: opacity 0.3s ease;
        }
        
        .template-card a:hover {
            opacity: 0.9;
        }
        
        .info-box {
            background: #edf2f7;
            border-left: 4px solid #667eea;
            padding: 16px;
            border-radius: 4px;
            margin-bottom: 30px;
        }
        
        .info-box p {
            color: #4a5568;
            font-size: 14px;
            margin: 0;
        }
        
        @media (max-width: 768px) {
            .templates-grid {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Email Template Preview</h1>
        <p class="subtitle">Preview all your beautiful email templates</p>
        
        <div class="info-box">
            <p><strong>Note:</strong> These preview routes are only available in local/development environment. Click on any template below to see how it looks!</p>
        </div>
        
        <div class="templates-grid">
            @foreach($templates as $template)
            <div class="template-card">
                <h3>{{ $template['name'] }}</h3>
                <p>{{ $template['description'] }}</p>
                <a href="{{ $template['url'] }}" target="_blank">Preview Template →</a>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
