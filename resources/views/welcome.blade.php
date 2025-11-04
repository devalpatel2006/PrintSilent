<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print API Example</title>
</head>

<body>

    <h1>Print Document</h1>

    <button id="printButton">Print Document</button>

    <script>
    document.getElementById("printButton").addEventListener("click", function() {
        // Data to be sent to the API
        const data = {
            printer_name: "HP LaserJet Pro MFP M126nw",
            imageurl: "https://shipczar.com/usps_label_pdf/1725876169.jpg",
            height: 432,
            width: 288
        };

        // Making a POST request to the API
        fetch("http://127.0.0.1:8781/shippingprint", {
                method: "GET", // HTTP method
                mode: "no-cors",
                headers: {
                    "Content-Type": "application/json" // Content type expected by the API
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