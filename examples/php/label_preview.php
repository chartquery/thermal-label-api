<?php
// Label Preview API – PHP example (ext-curl)
// Usage: CHARTQUERY_API_KEY=your-key php label_preview.php

function call(string $method, string $url, ?string $body = null): string
{
    $ch = curl_init($url);
    $headers = ['x-api-key: ' . getenv('CHARTQUERY_API_KEY')];
    if ($body !== null) {
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_HTTPHEADER => $headers,
    ]);
    $res = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($status >= 400) {
        fwrite(STDERR, "HTTP $status: $res\n");
        exit(1);
    }
    return $res;
}

$response = call('POST', 'https://api.chartquery.com/v1/label', '{"width": 40, "height": 30, "unit": "mm", "language": "tsc", "format": "png", "elements": [{"type": "text", "content": "Order: 1042", "x": 10, "y": 10, "size": 2}, {"type": "text", "content": "SKU: BOX-12", "x": 10, "y": 35, "size": 2}]}');

file_put_contents('label.png', $response);
echo 'Saved label.png', PHP_EOL;
