<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print API GET Example</title>
</head>

<body>
    <h1>Print Document (GET)</h1>
    <button id="printButton">Print Document</button>

    <div id="response" style="margin-top: 20px;"></div>

    <script>
    document.getElementById("printButton").addEventListener("click", function() {
        // Build query parameters
        const params = new URLSearchParams({
            printer: "HP LaserJet Pro MFP M126nw",
            url: "https://shipczar.com/usps_label_pdf/1725876169.jpg",
            height: 432,
            width: 288
        });

        // Call the GET API
        fetch(`http://127.0.0.1:8781/shippingprint?${params.toString()}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                console.log("Success:", data);
                document.getElementById("response").innerText = "Print job sent: " + JSON.stringify(data);
            })
            .catch(err => {
                console.error("Error:", err);
                document.getElementById("response").innerText = "Failed to send print job.";
            });
    });
    </script>
</body>

</html>