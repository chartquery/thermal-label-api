// Label Preview API – C# example (.NET 6+, top-level statements)
// Usage: dotnet new console -n Example && copy this file to Program.cs, then CHARTQUERY_API_KEY=your-key dotnet run
using System.Text;
using System.Text.Json;

var apiKey = Environment.GetEnvironmentVariable("CHARTQUERY_API_KEY") ?? throw new InvalidOperationException("Set CHARTQUERY_API_KEY");
using var http = new HttpClient { Timeout = TimeSpan.FromSeconds(120) };
http.DefaultRequestHeaders.Add("x-api-key", apiKey);

var body = new StringContent(@"{""width"": 40, ""height"": 30, ""unit"": ""mm"", ""language"": ""tsc"", ""format"": ""png"", ""elements"": [{""type"": ""text"", ""content"": ""Order: 1042"", ""x"": 10, ""y"": 10, ""size"": 2}, {""type"": ""text"", ""content"": ""SKU: BOX-12"", ""x"": 10, ""y"": 35, ""size"": 2}]}", Encoding.UTF8, "application/json");
var request = new HttpRequestMessage(new HttpMethod("POST"), "https://api.chartquery.com/v1/label") { Content = body };
var response = await http.SendAsync(request);
if (!response.IsSuccessStatusCode)
{
    Console.Error.WriteLine($"HTTP {(int)response.StatusCode}: {await response.Content.ReadAsStringAsync()}");
    return;
}

await File.WriteAllBytesAsync("label.png", await response.Content.ReadAsByteArrayAsync());
Console.WriteLine("Saved label.png");
