<?php
// Site Settings Configuration

class Settings {
    // WhatsApp Business Number (format: country code + number without + or spaces)
    // Example: For +251 911 234 567, use: 251911234567
    public static $whatsapp_number = '251911234567';
    
    // Company Information
    public static $company_name = 'NEO Printing and Advertising';
    public static $company_email = 'info@neoprinting.com';
    
    // Social Media Links
    public static $telegram = 'https://t.me/neoprinting';
    public static $facebook = 'https://facebook.com/neoprinting';
    public static $instagram = 'https://instagram.com/neoprinting';
    
    /**
     * Generate WhatsApp link with pre-filled message
     * @param string $service_name The name of the service
     * @return string WhatsApp URL
     */
    public static function getWhatsAppLink($service_name = '') {
        $message = "Hello! I'm interested in ";
        if (!empty($service_name)) {
            $message .= $service_name . " service";
        } else {
            $message .= "your services";
        }
        $message .= ". Can you provide more information?";
        
        return 'https://wa.me/' . self::$whatsapp_number . '?text=' . urlencode($message);
    }
}
