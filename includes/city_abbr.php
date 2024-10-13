
<?php
function getCityAbbr(string $city): string {
    return match ($city) {
        'Calgary' => 'CGY',
        'Cochrane' => 'COC',
        'Airdrie' => 'AIR',
        default => $city,
    };
}
?>