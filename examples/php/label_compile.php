<?php
// Label Compile API – PHP example (ext-curl)
// Usage: CHARTQUERY_API_KEY=your-key php label_compile.php

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

$response = call('POST', 'https://api.chartquery.com/v1/label/compile', '{"width": 40, "height": 30, "unit": "mm", "language": "zpl", "elements": [{"type": "text", "content": "Order: 1042", "x": 10, "y": 10, "size": 2}, {"type": "text", "content": "SKU: BOX-12", "x": 10, "y": 35, "size": 2}]}');

echo json_encode(json_decode($response, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), PHP_EOL;
