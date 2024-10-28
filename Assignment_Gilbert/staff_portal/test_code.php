<?php

class AutoTester {
    private $baseUrl;
    private $email; // Change from username to email
    private $password;
    private $cookieJar;
    
    public function __construct($url, $email = null, $password = null) {
        $this->baseUrl = rtrim($url, '/'); // Ensure no trailing slash
        $this->email = $email; // Change to email
        $this->password = $password;
        $this->cookieJar = tempnam(sys_get_temp_dir(), 'cookie'); // Store cookies in a temp file
    }

    // Function to login if credentials are provided
    private function login() {
        if (!$this->email || !$this->password) {
            return true; // Skip login if no credentials provided
        }

        $loginUrl = $this->baseUrl . '/'; // Change according to your login page URL (index.php)
        $postData = http_build_query([
            'email' => $this->email, // Use 'email' instead of 'username'
            'password' => $this->password
        ]);

        $response = $this->postRequest($loginUrl, $postData);

        // Check if login is successful, adjust this condition based on actual response
        if (strpos($response, 'Login successful') !== false || strpos($response, 'Dashboard') !== false) {
            echo "Login successful.\n";
            return true;
        } else {
            echo "Login failed.\n";
            return false;
        }
    }

    // Function to send a POST request
    private function postRequest($url, $data, $files = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar); // Save cookies for session
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar); // Use cookies for subsequent requests
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

        if (!empty($files)) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true); // Allow file uploads
        }
        
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    // Function to send a GET request
    private function getRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar); // Reuse login cookies
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    // Function to parse the HTML and find all links
    private function getAllLinks($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $links = [];

        foreach ($dom->getElementsByTagName('a') as $link) {
            $href = $link->getAttribute('href');
            if (!empty($href) && strpos($href, '#') === false && strpos($href, 'javascript:') === false) {
                // Only include valid links
                $links[] = strpos($href, 'http') === false ? $this->baseUrl . $href : $href;
            }
        }

        return $links;
    }

    // Function to parse forms and submit sample data
    private function processForms($html, $url) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $forms = $dom->getElementsByTagName('form');

        foreach ($forms as $form) {
            $action = $form->getAttribute('action');
            $method = strtolower($form->getAttribute('method')) ?: 'get';
            $formUrl = strpos($action, 'http') === false ? $this->baseUrl . '/' . ltrim($action, '/') : $action;

            // Prepare form data
            $data = [];
            $files = [];
            $dynamicFields = [];

            foreach ($form->getElementsByTagName('input') as $input) {
                $name = $input->getAttribute('name');
                $type = $input->getAttribute('type') ?: 'text';
                if ($name) {
                    if ($type == 'file') {
                        $files[$name] = new CURLFile('/path/to/sample/file.txt'); // Adjust path as needed
                    } else {
                        $data[$name] = $this->generateSampleData($type);
                    }
                }
            }

            // Handle select and textarea elements, including dynamic selects
            foreach ($form->getElementsByTagName('select') as $select) {
                $name = $select->getAttribute('name');
                if ($name) {
                    $options = $select->getElementsByTagName('option');
                    if ($options->length > 0) {
                        $data[$name] = $options->item(0)->getAttribute('value'); // Select the first option
                    }
                    if ($select->hasAttribute('onchange') || $select->hasAttribute('data-*')) {
                        $dynamicFields[] = $name; // Add dynamic fields for further processing
                    }
                }
            }

            foreach ($form->getElementsByTagName('textarea') as $textarea) {
                $name = $textarea->getAttribute('name');
                if ($name) {
                    $data[$name] = 'Sample Text';
                }
            }

            // Handle dynamic fields via AJAX or dependent dropdowns
            if (!empty($dynamicFields)) {
                foreach ($dynamicFields as $dynamicField) {
                    $response = $this->postRequest($formUrl, $data); // Submit form to trigger dynamic field
                    $data = $this->processDynamicField($dynamicField, $response);
                }
            }

            // Submit the form
            $postData = http_build_query($data);
            if ($method == 'post') {
                $response = $this->postRequest($formUrl, array_merge($data, $files));
            } else {
                $response = $this->getRequest($formUrl . '?' . $postData);
            }

            // Check for errors
            if ($this->detectErrors($response)) {
                echo "Errors detected in form submission at: $formUrl\n";
            } else {
                echo "Form submitted successfully at: $formUrl\n";
            }
        }
    }

    // Process dynamic field (AJAX responses)
    private function processDynamicField($fieldName, $response) {
        $dom = new DOMDocument();
        @$dom->loadHTML($response);

        $selects = $dom->getElementsByTagName('select');
        foreach ($selects as $select) {
            $name = $select->getAttribute('name');
            if ($name == $fieldName) {
                $options = $select->getElementsByTagName('option');
                if ($options->length > 0) {
                    return [$fieldName => $options->item(0)->getAttribute('value')];
                }
            }
        }
        return [];
    }

    // Generate sample data for form inputs
    private function generateSampleData($type) {
        switch ($type) {
            case 'text':
                return 'SampleText';
            case 'email':
                return 'test@example.com';
            case 'password':
                return 'SamplePassword';
            case 'number':
                return rand(1, 100);
            default:
                return 'SampleData';
        }
    }

    // Detect errors in form submissions
    private function detectErrors($response) {
        return strpos($response, 'error') !== false || strpos($response, 'invalid') !== false;
    }

    // Main function to traverse pages and test forms
    public function startTesting() {
        if (!$this->login()) {
            echo "Login failed! Exiting...\n";
            return;
        }

        // Traverse all links starting from the base URL
        $html = $this->getRequest($this->baseUrl);
        $links = $this->getAllLinks($html);

        foreach ($links as $link) {
            echo "Testing page: $link\n";
            $pageHtml = $this->getRequest($link);
            $this->processForms($pageHtml, $link);
        }
    }
}

// Usage
$url = 'http://localhost/staff_portal'; // Base URL to test
$email = 'user@'; // Set email if login is required
$password = '1q2w3e4r5t6!'; // Set password if login is required

$tester = new AutoTester($url, $email, $password);
$tester->startTesting();






