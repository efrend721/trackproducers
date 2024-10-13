<?php 
function getAbbr($word) {
    return match ($word) {
        'Standard' => 'St',
        'High' => 'H',
        'Medium' => 'M',
        'Very High' => 'VH',
        'Immediately' => 'Imm',
        default => $word,
    };
}

function formatDate($date) {
    $dt = DateTime::createFromFormat('Y-m-d', $date);
    return $dt->format('M d');
}


function getCityAbbr(string $city): string {
    return match ($city) {
        'Calgary' => 'CGY',
        'Cochrane' => 'COC',
        'Airdrie' => 'AIR',
        default => $city,
    };
}
?>