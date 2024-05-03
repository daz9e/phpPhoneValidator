<?php

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

class PhoneNumberNormalizer
{
    private static ?PhoneNumberNormalizer $instance = null;
    private PhoneNumberUtil $phoneNumberUtil;

    private function __construct()
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }

    public static function getInstance(): PhoneNumberNormalizer
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function parseCSV($filePath): array
    {
        $normalizedPhones = [];

        $file = fopen($filePath, 'r');
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $phone = $row[0];
            $country = $row[1];

            $normalizedPhone = $this->normalize($phone, $country);
            if ($normalizedPhone === false) {
                echo "Error parsing phone number: $phone" . PHP_EOL;
            } else {
                $normalizedPhones[] = $normalizedPhone;
            }
        }

        fclose($file);
        return $normalizedPhones;
    }

    public function normalize($phoneNumber, $countryCode)
    {
        try {
            $parsedNumber = $this->phoneNumberUtil->parse($phoneNumber, $countryCode);

            $isValid = $this->phoneNumberUtil->isValidNumber($parsedNumber);

            if ($isValid) {
                return $this->phoneNumberUtil->format($parsedNumber, PhoneNumberFormat::E164);
            } else {
                return $phoneNumber;
            }
        } catch (NumberParseException $e) {
            echo "Error parsing phone number: " . $e->getMessage() . PHP_EOL;
            return false;
        }
    }
}
