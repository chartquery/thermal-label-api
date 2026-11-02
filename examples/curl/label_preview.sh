#!/usr/bin/env bash
# Label Preview API – cURL example
# Usage: CHARTQUERY_API_KEY=your-key bash label_preview.sh
set -euo pipefail

curl -sS --fail-with-body -X POST "https://api.chartquery.com/v1/label" \
  -H "x-api-key: ${CHARTQUERY_API_KEY}" \
  -H "Content-Type: application/json" \
  --data '{"width": 40, "height": 30, "unit": "mm", "language": "tsc", "format": "png", "elements": [{"type": "text", "content": "Order: 1042", "x": 10, "y": 10, "size": 2}, {"type": "text", "content": "SKU: BOX-12", "x": 10, "y": 35, "size": 2}]}' \
  -o label.png

echo "Saved label.png"
