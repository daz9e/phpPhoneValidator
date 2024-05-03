<?php

require 'vendor/autoload.php';
require 'PhoneNumberNormalizer.php';

$phoneNumberNormalizer = PhoneNumberNormalizer::getInstance();
$normalizedPhones = $phoneNumberNormalizer->parseCSV('phones.csv');

// С данным массивом мы можем работать далее, например добавить его в базу данных, но сейчас он просто выводится
foreach ($normalizedPhones as $normalizedPhone) {
    echo "Normalized phone number: $normalizedPhone" . PHP_EOL;
}

// Для единичных случаев обработки номера, или например когда он берется не из csv файла, мы так же можем использовать normalize()
$singlyNormalizedPhone = $phoneNumberNormalizer->normalize("971568080000", "AE");
echo "Singly normalized file: $singlyNormalizedPhone" . PHP_EOL;
