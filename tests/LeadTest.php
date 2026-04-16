<?php

use PHPUnit\Framework\TestCase;

class LeadTest extends TestCase
{
    public function testCreateLead()
    {
        $cookieFile = tempnam(sys_get_temp_dir(), 'cookie');

        // Login
        $ch = curl_init("http://localhost/Leads/api/auth/login.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            "email" => "admin@test.com",
            "password" => "P@55word"
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_exec($ch);
        curl_close($ch);

        // Create test Lead
        $ch = curl_init("http://localhost/Leads/api/leads/create.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            "name" => "Unit Test",
            "description" => "Lead Test"
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

        $result = curl_exec($ch);
        curl_close($ch);
        $this->assertNotFalse($result);
        $response = json_decode($result, true);
        $this->assertArrayHasKey("message", $response);
    }
}