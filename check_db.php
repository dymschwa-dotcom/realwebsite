<?php
include 'public_html/index.php';
use Illuminate\Support\Facades\Schema;
$columns = Schema::getColumnListing('influencer_packages');
echo json_encode($columns);
