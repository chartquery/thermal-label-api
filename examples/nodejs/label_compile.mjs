// Label Compile API – Node.js example (Node 18+, ES module)
// Usage: CHARTQUERY_API_KEY=your-key node label_compile.mjs

const headers = { "x-api-key": process.env.CHARTQUERY_API_KEY, "Content-Type": "application/json" };

const response = await fetch("https://api.chartquery.com/v1/label/compile", {
  method: "POST",
  headers,
  body: JSON.stringify({
  "width": 40,
  "height": 30,
  "unit": "mm",
  "language": "zpl",
  "elements": [
    {
      "type": "text",
      "content": "Order: 1042",
      "x": 10,
      "y": 10,
      "size": 2
    },
    {
      "type": "text",
      "content": "SKU: BOX-12",
      "x": 10,
      "y": 35,
      "size": 2
    }
  ]
}),
});
if (!response.ok) {
  console.error(`HTTP ${response.status}: ${await response.text()}`);
  process.exit(1);
}

console.log(JSON.stringify(await response.json(), null, 2));
