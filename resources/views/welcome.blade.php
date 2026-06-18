<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print API Example</title>
</head>

<body>

    <h1>Print Document</h1>
    @if(!empty($printerServiceError))
    <div style="padding:10px; margin-bottom:12px; color:#842029; background:#f8d7da; border:1px solid #f5c2c7;">
        {{ $printerServiceError }}
    </div>
    @endif
    <select name="printer" class="form-control">
        @if(empty($printers))
        <option value="">No printers available</option>
        @endif
        @foreach($printers as $printer)
        <option value="{{ $printer['name'] }}">
            {{ $printer['name'] }} ({{ $printer['paperWidth'] }} x {{ $printer['paperHeight'] }})
        </option>
        @endforeach
    </select>
    <button id="printButton">Print Document</button>

    <script src="/js/sp-client.js"></script>
    <script>
    // Direct browser → localhost communication (no server proxy)
    const sp = new SPClient(4545);

    document.getElementById("printButton").addEventListener("click", async function() {
        this.disabled = true;
        this.textContent = 'Sending...';
        try {
            const data = await sp.print({
                url: "https://shipczar.com/usps_label_pdf/1725876169.jpg",
                printer: "EPSON L3260 Series",
            });
            console.log("Success:", data);
            alert("Print job successfully sent to the printer.");
        } catch (err) {
            console.error("Error:", err);
            alert("Failed to send the print job: " + err.message);
        } finally {
            this.disabled = false;
            this.textContent = 'Print Document';
        }
    });
    </script>
</body>

</html>