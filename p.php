<?php

$payload = '{
    "Data":[
        {
            "transaction_reference": "RABIUL123123"
        }
    ]
 }';

 echo base64_encode($payload);


$payload = '{
    "Data":[
        {
            "transaction_reference": "RABIUL123123", 
            "amount_in_bdt": "50",
            "beneficiary": "Joy JP",
            "beneficiary_msisdn": "+8801752790414",
            "sender_name": "Rabiul Hasan",
            "sender_msisdn": "+8801345234234",
            "sender_country_iso": "ZW",
            "sender_date_of_birth": "1978-09-01",
            "sender_address": "380 GEORGE AVENUE BRAKPAN,CAPETOWN,GAUTENG,Western Cape,1541",
            "purpose_of_remittance": "Compensation paid by a resident to a migrant worker employee",
            "source_of_fund": "BUSINESS",
            "sender_document_type": "Foreign Passport",
            "sender_document_no": "BW0666713",
            "user": "39c8a757b50b4068628042d467cf1b81140a81b1",
            "agent_code": "241"
        }
    ]
 }';
// echo base64_encode($payload);