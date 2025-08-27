<?php
// Set the input and output file names
$inputFile = 'your_input_file.csv'; // Replace with your CSV file name
$outputFile = 'reshaped_output_file.csv'; // The name of the output file

// Open the input file for reading
$file = fopen($inputFile, 'r');

// Initialize variables
$rowsPerRecord = 8; // Number of rows to group together
$data = [];
$reshapedData = [];

// Read the data from the CSV
while (($line = fgetcsv($file)) !== FALSE) {
    $data[] = $line[0]; // Assuming data is in the first column
}

fclose($file);

// Reshape the data into rows and columns
for ($i = 0; $i < count($data); $i += $rowsPerRecord) {
    $row = array_slice($data, $i, $rowsPerRecord);
    $reshapedData[] = $row;
}

// Open the output file for writing
$file = fopen($outputFile, 'w');

// Write the reshaped data to the output CSV
foreach ($reshapedData as $row) {
    fputcsv($file, $row);
}

fclose($file);

echo "Reshaped data saved to $outputFile\n";
?>