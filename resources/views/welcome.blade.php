<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print API Example</title>
</head>

<body>

    <h1>Print Document</h1>
    <select name="printer" class="form-control">
        @foreach($printers as $printer)
        <option value="{{ $printer['name'] }}">
            {{ $printer['name'] }} ({{ $printer['paperWidth'] }} x {{ $printer['paperHeight'] }})
        </option>
        @endforeach
    </select>
    <button id="printButton">Print Document</button>

    <script>
    document.getElementById("printButton").addEventListener("click", function() {
        // Data to be sent to the API
        const data = {
            printer_name: "EPSON L3260 Series",
            imageurl: "https://shipczar.com/usps_label_pdf/1725876169.jpg"
        };
        const API_URL = @json(url('/api/v1/printpage'));
        fetch(API_URL, {
                method: "POST", // HTTP method
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // Important if using web routes
                },
                body: JSON.stringify(data) // Convert the data to a JSON string
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok " + response.statusText);
                }
                return response.json(); // Parsing the JSON response
            })
            .then(data => {
                console.log("Success:", data);
                alert("Print job successfully sent to the printer.");
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Failed to send the print job.");
            });
    });
    </script>
</body>

</html>