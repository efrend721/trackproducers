<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        #pdfViewer {
            flex: 1;
            width: 100%;
            border: none;
        }
        #printButton {
            width: 100%;
            background-color: #007BFF;
            color: white;
            font-size: 18px;
            border: none;
            cursor: pointer;
            padding: 15px 0;
            text-align: center;
        }
        @media (max-width: 600px) {
            #pdfViewer {
                height: auto;
            }
        }
    </style>
</head>
<body>
    <?php
    session_start();

    $user = $_SESSION["name_user"] ?? 'Guest'; // Use default value if session is not set
    $baseFileName = $_SESSION["baseFileName"] ?? 'default_report';

    // PDFViewer class to handle PDF embedding and printing
    class PDFViewer {
        private $pdfPath;

        // Constructor to initialize PDF path
        public function __construct($pdfPath) {
            $this->pdfPath = $pdfPath;
        }

        // Function to check if the PDF file exists
        public function fileExists() {
            return file_exists($this->pdfPath);
        }

        // Function to generate the iframe for displaying PDF
        public function displayPDF() {
            if ($this->fileExists()) {
                echo '<iframe id="pdfViewer" src="' . htmlspecialchars($this->pdfPath) . '" type="application/pdf" width="100%" height="100%"></iframe>';
            } else {
                echo '<p style="text-align:center;color:red;">PDF file not found.</p>';
            }
        }

        // Function to generate the print button
        public function displayPrintButton() {
            echo '<button id="printButton" onclick="printPDF()">Print PDF</button>';
        }

        // Function to add JavaScript for printing functionality
        public function addPrintFunction() {
            echo '<script>
                function printPDF() {
                    const pdfFrame = document.getElementById("pdfViewer");
                    if (pdfFrame && pdfFrame.contentWindow) {
                        pdfFrame.focus();
                        pdfFrame.contentWindow.print();
                    } else {
                        alert("PDF cannot be printed at this time.");
                    }
                }
                </script>';
        }
    }

    // Path to the PDF file
    $fileName = $baseFileName . '_user_' . $user . '.pdf';
    $pdfPath = '../uploads/reports/' . $fileName;

    // Create an instance of the PDFViewer class
    $pdfViewer = new PDFViewer($pdfPath);

    // Display the PDF and print button
    $pdfViewer->displayPDF();
    $pdfViewer->displayPrintButton();

    // Add the print function JavaScript
    $pdfViewer->addPrintFunction();
    ?>
</body>
</html>
