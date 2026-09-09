<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

$tables = [
    'users',
    'cities',
    'services',
    'kecamatans',
    'locations',
    'city_service_contents',
    'articles',
    'faqs',
    'training_schedules',
];

$sqlFile = database_path('trainingkota.sql');
$handle = fopen($sqlFile, 'w');

fwrite($handle, "SET FOREIGN_KEY_CHECKS = 0;\n\n");

foreach ($tables as $table) {
    fwrite($handle, "-- Data for table: $table\n");
    $rows = DB::table($table)->get();
    
    if ($rows->isEmpty()) {
        fwrite($handle, "-- Table $table is empty\n\n");
        continue;
    }

    foreach ($rows as $row) {
        $columns = array_keys((array)$row);
        $values = array_values((array)$row);
        
        $escapedValues = array_map(function($value) {
            if ($value === null) return 'NULL';
            if (is_numeric($value)) return $value;
            return "'" . str_replace("'", "''", addslashes($value)) . "'";
        }, $values);

        $sql = "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $escapedValues) . ");\n";
        fwrite($handle, $sql);
    }
    fwrite($handle, "\n");
}

fwrite($handle, "SET FOREIGN_KEY_CHECKS = 1;\n");
fclose($handle);

echo "Export completed successfully to $sqlFile\n";