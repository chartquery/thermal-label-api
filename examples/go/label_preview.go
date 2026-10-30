// Label Preview API – Go example
// Usage: CHARTQUERY_API_KEY=your-key go run label_preview.go
package main

import (
	"bytes"
	"encoding/json"
	"fmt"
	"io"
	"net/http"
	"net/url"
	"os"
	"time"
)

var client = &http.Client{Timeout: 120 * time.Second}

func call(method, target string, body []byte) []byte {
	var reader io.Reader
	if body != nil {
		reader = bytes.NewReader(body)
	}
	req, _ := http.NewRequest(method, target, reader)
	req.Header.Set("x-api-key", os.Getenv("CHARTQUERY_API_KEY"))
	if body != nil {
		req.Header.Set("Content-Type", "application/json")
	}
	resp, err := client.Do(req)
	if err != nil {
		panic(err)
	}
	defer resp.Body.Close()
	data, _ := io.ReadAll(resp.Body)
	if resp.StatusCode >= 400 {
		fmt.Fprintf(os.Stderr, "HTTP %d: %s\n", resp.StatusCode, data)
		os.Exit(1)
	}
	return data
}

func main() {
	_ = url.Values{}
	_ = json.Valid
	body := []byte(`{"width": 40, "height": 30, "unit": "mm", "language": "tsc", "format": "png", "elements": [{"type": "text", "content": "Order: 1042", "x": 10, "y": 10, "size": 2}, {"type": "text", "content": "SKU: BOX-12", "x": 10, "y": 35, "size": 2}]}`)
	data := call("POST", "https://api.chartquery.com/v1/label", body)
	if err := os.WriteFile("label.png", data, 0o644); err != nil {
		panic(err)
	}
	fmt.Println("Saved label.png")
}
