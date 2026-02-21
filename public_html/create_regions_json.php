<?php
$nzRegions = ['Auckland', 'Wellington', 'Canterbury', 'Waikato', 'Bay of Plenty', 'Otago', 'Manawatū-Whanganui', 'Taranaki', 'Northland', 'Hawke\'s Bay', 'Southland', 'Nelson', 'Gisborne', 'Marlborough', 'Tasman', 'West Coast'];
$auStates = ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia', 'Tasmania', 'Australian Capital Territory', 'Northern Territory'];

file_put_contents(resource_path('views/partials/regions.json'), json_encode([
    'New Zealand' => $nzRegions,
    'Australia' => $auStates
]));

echo "Regions JSON created successfully.";
